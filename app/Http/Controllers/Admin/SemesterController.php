<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SemesterRequest;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SemesterController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Semester::class);

        $semesters = Semester::query()
            ->with('academicYear')
            ->when($request->input('academic_year_id'), fn ($q, $id) => $q->where('academic_year_id', $id))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $years = AcademicYear::orderByDesc('code')->get();

        return view('admin.semesters.index', compact('semesters', 'years'));
    }

    public function create(): View
    {
        $this->authorize('create', Semester::class);
        $years = AcademicYear::where('is_active', true)->orderByDesc('code')->get();

        return view('admin.semesters.create', compact('years'));
    }

    public function store(SemesterRequest $request): RedirectResponse
    {
        $semester = Semester::create($request->validated());

        return redirect()->route('admin.semesters.show', $semester)
            ->with('status', 'Semester berhasil dibuat.');
    }

    public function show(Semester $semester): View
    {
        $this->authorize('view', $semester);
        $semester->load('academicYear');

        return view('admin.semesters.show', compact('semester'));
    }

    public function edit(Semester $semester): View
    {
        $this->authorize('update', $semester);
        $years = AcademicYear::where('is_active', true)->orderByDesc('code')->get();

        return view('admin.semesters.edit', compact('semester', 'years'));
    }

    public function update(SemesterRequest $request, Semester $semester): RedirectResponse
    {
        $this->authorize('update', $semester);
        $semester->update($request->validated());

        return redirect()->route('admin.semesters.show', $semester)
            ->with('status', 'Semester berhasil diperbarui.');
    }

    public function toggle(Semester $semester): RedirectResponse
    {
        $this->authorize('toggleActive', $semester);
        $semester->update(['is_active' => ! $semester->is_active]);

        return back()->with('status', $semester->is_active ? 'Semester diaktifkan.' : 'Semester dinonaktifkan.');
    }
}
