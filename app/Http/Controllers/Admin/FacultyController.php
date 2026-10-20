<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacultyRequest;
use App\Models\Faculty;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Faculty::class);

        $faculties = Faculty::query()
            ->when($request->input('q'), fn ($q, $search) => $q->where(fn ($w) => $w
                ->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")))
            ->when($request->has('is_active'), fn ($q) => $q->where('is_active', $request->boolean('is_active')))
            ->withCount('studyPrograms')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.faculties.index', compact('faculties'));
    }

    public function create(): View
    {
        $this->authorize('create', Faculty::class);

        return view('admin.faculties.create');
    }

    public function store(FacultyRequest $request): RedirectResponse
    {
        $faculty = Faculty::create($request->validated());

        return redirect()->route('admin.faculties.show', $faculty)
            ->with('status', 'Fakultas berhasil dibuat.');
    }

    public function show(Faculty $faculty): View
    {
        $this->authorize('view', $faculty);
        $faculty->loadCount('studyPrograms');

        return view('admin.faculties.show', compact('faculty'));
    }

    public function edit(Faculty $faculty): View
    {
        $this->authorize('update', $faculty);

        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(FacultyRequest $request, Faculty $faculty): RedirectResponse
    {
        $this->authorize('update', $faculty);
        $faculty->update($request->validated());

        return redirect()->route('admin.faculties.show', $faculty)
            ->with('status', 'Fakultas berhasil diperbarui.');
    }

    public function toggle(Faculty $faculty): RedirectResponse
    {
        $this->authorize('toggleActive', $faculty);
        $faculty->update(['is_active' => ! $faculty->is_active]);

        return back()->with('status', $faculty->is_active ? 'Fakultas diaktifkan.' : 'Fakultas dinonaktifkan.');
    }
}
