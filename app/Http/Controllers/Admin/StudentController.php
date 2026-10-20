<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Student::class);

        $students = Student::query()
            ->with(['user', 'studyProgram'])
            ->when($request->input('study_program_id'), fn ($q, $id) => $q->where('study_program_id', $id))
            ->when($request->input('q'), fn ($q, $search) => $q
                ->where('nim', 'like', "%{$search}%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $programs = StudyProgram::where('is_active', true)->orderBy('name')->get();

        return view('admin.students.index', compact('students', 'programs'));
    }

    public function create(): View
    {
        $this->authorize('create', Student::class);
        $programs = StudyProgram::where('is_active', true)->orderBy('name')->get();
        $users = User::where('role', 'student')->whereDoesntHave('student')->orderBy('name')->limit(200)->get();

        return view('admin.students.create', compact('programs', 'users'));
    }

    public function store(StudentRequest $request): RedirectResponse
    {
        $student = Student::create($request->validated());

        return redirect()->route('admin.students.show', $student)
            ->with('status', 'Profil mahasiswa berhasil dibuat.');
    }

    public function show(Student $student): View
    {
        $this->authorize('view', $student);
        $student->load(['user', 'studyProgram.faculty']);

        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        $this->authorize('update', $student);
        $programs = StudyProgram::where('is_active', true)->orderBy('name')->get();

        return view('admin.students.edit', compact('student', 'programs'));
    }

    public function update(StudentRequest $request, Student $student): RedirectResponse
    {
        $this->authorize('update', $student);
        $data = $request->validated();
        unset($data['user_id']); // user pengikat tidak boleh diganti
        $student->update($data);

        return redirect()->route('admin.students.show', $student)
            ->with('status', 'Profil mahasiswa berhasil diperbarui.');
    }

    public function toggle(Student $student): RedirectResponse
    {
        $this->authorize('toggleActive', $student);
        $student->update(['is_active' => ! $student->is_active]);

        return back()->with('status', $student->is_active ? 'Mahasiswa diaktifkan.' : 'Mahasiswa dinonaktifkan.');
    }
}
