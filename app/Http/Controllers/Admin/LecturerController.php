<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LecturerRequest;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LecturerController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Lecturer::class);

        $lecturers = Lecturer::query()
            ->with(['user', 'faculty'])
            ->when($request->input('faculty_id'), fn ($q, $id) => $q->where('faculty_id', $id))
            ->when($request->input('q'), fn ($q, $search) => $q
                ->where('nip', 'like', "%{$search}%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();

        return view('admin.lecturers.index', compact('lecturers', 'faculties'));
    }

    public function create(): View
    {
        $this->authorize('create', Lecturer::class);
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();
        $users = User::where('role', 'lecturer')->whereDoesntHave('lecturer')->orderBy('name')->limit(200)->get();

        return view('admin.lecturers.create', compact('faculties', 'users'));
    }

    public function store(LecturerRequest $request): RedirectResponse
    {
        $lecturer = Lecturer::create($request->validated());

        return redirect()->route('admin.lecturers.show', $lecturer)
            ->with('status', 'Profil dosen berhasil dibuat.');
    }

    public function show(Lecturer $lecturer): View
    {
        $this->authorize('view', $lecturer);
        $lecturer->load(['user', 'faculty']);

        return view('admin.lecturers.show', compact('lecturer'));
    }

    public function edit(Lecturer $lecturer): View
    {
        $this->authorize('update', $lecturer);
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();

        return view('admin.lecturers.edit', compact('lecturer', 'faculties'));
    }

    public function update(LecturerRequest $request, Lecturer $lecturer): RedirectResponse
    {
        $this->authorize('update', $lecturer);
        $data = $request->validated();
        unset($data['user_id']); // user pengikat tidak boleh diganti
        $lecturer->update($data);

        return redirect()->route('admin.lecturers.show', $lecturer)
            ->with('status', 'Profil dosen berhasil diperbarui.');
    }

    public function toggle(Lecturer $lecturer): RedirectResponse
    {
        $this->authorize('toggleActive', $lecturer);
        $lecturer->update(['is_active' => ! $lecturer->is_active]);

        return back()->with('status', $lecturer->is_active ? 'Dosen diaktifkan.' : 'Dosen dinonaktifkan.');
    }
}
