<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyProgramRequest;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudyProgramController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', StudyProgram::class);

        $programs = StudyProgram::query()
            ->with('faculty')
            ->when($request->input('faculty_id'), fn ($q, $id) => $q->where('faculty_id', $id))
            ->when($request->input('q'), fn ($q, $search) => $q->where(fn ($w) => $w
                ->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")))
            ->when($request->has('is_active'), fn ($q) => $q->where('study_programs.is_active', $request->boolean('is_active')))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();

        return view('admin.study-programs.index', compact('programs', 'faculties'));
    }

    public function create(): View
    {
        $this->authorize('create', StudyProgram::class);
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();

        return view('admin.study-programs.create', compact('faculties'));
    }

    public function store(StudyProgramRequest $request): RedirectResponse
    {
        $program = StudyProgram::create($request->validated());

        return redirect()->route('admin.study-programs.show', $program)
            ->with('status', 'Program studi berhasil dibuat.');
    }

    public function show(StudyProgram $studyProgram): View
    {
        $this->authorize('view', $studyProgram);
        $studyProgram->load(['faculty', 'courses']);

        return view('admin.study-programs.show', ['program' => $studyProgram]);
    }

    public function edit(StudyProgram $studyProgram): View
    {
        $this->authorize('update', $studyProgram);
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();

        return view('admin.study-programs.edit', ['program' => $studyProgram, 'faculties' => $faculties]);
    }

    public function update(StudyProgramRequest $request, StudyProgram $studyProgram): RedirectResponse
    {
        $this->authorize('update', $studyProgram);
        $studyProgram->update($request->validated());

        return redirect()->route('admin.study-programs.show', $studyProgram)
            ->with('status', 'Program studi berhasil diperbarui.');
    }

    public function toggle(StudyProgram $studyProgram): RedirectResponse
    {
        $this->authorize('toggleActive', $studyProgram);
        $studyProgram->update(['is_active' => ! $studyProgram->is_active]);

        return back()->with('status', $studyProgram->is_active ? 'Program studi diaktifkan.' : 'Program studi dinonaktifkan.');
    }
}
