<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\StudyProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Course::class);

        $courses = Course::query()
            ->with('studyProgram')
            ->when($request->input('study_program_id'), fn ($q, $id) => $q->where('study_program_id', $id))
            ->when($request->input('q'), fn ($q, $search) => $q->where(fn ($w) => $w
                ->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")))
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        $programs = StudyProgram::where('is_active', true)->orderBy('name')->get();

        return view('admin.courses.index', compact('courses', 'programs'));
    }

    public function create(): View
    {
        $this->authorize('create', Course::class);
        $programs = StudyProgram::where('is_active', true)->orderBy('name')->get();

        return view('admin.courses.create', compact('programs'));
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        $course = Course::create($request->validated());

        return redirect()->route('admin.courses.show', $course)
            ->with('status', 'Mata kuliah berhasil dibuat.');
    }

    public function show(Course $course): View
    {
        $this->authorize('view', $course);
        $course->load('studyProgram.faculty');

        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course): View
    {
        $this->authorize('update', $course);
        $programs = StudyProgram::where('is_active', true)->orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'programs'));
    }

    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);
        $course->update($request->validated());

        return redirect()->route('admin.courses.show', $course)
            ->with('status', 'Mata kuliah berhasil diperbarui.');
    }

    public function toggle(Course $course): RedirectResponse
    {
        $this->authorize('toggleActive', $course);
        $course->update(['is_active' => ! $course->is_active]);

        return back()->with('status', $course->is_active ? 'Mata kuliah diaktifkan.' : 'Mata kuliah dinonaktifkan.');
    }
}
