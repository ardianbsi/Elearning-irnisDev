<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', AcademicYear::class);

        $years = AcademicYear::query()
            ->when($request->input('q'), fn ($q, $search) => $q->where(fn ($w) => $w
                ->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")))
            ->withCount('semesters')
            ->orderByDesc('code')
            ->paginate(15)
            ->withQueryString();

        return view('admin.academic-years.index', compact('years'));
    }

    public function create(): View
    {
        $this->authorize('create', AcademicYear::class);

        return view('admin.academic-years.create');
    }

    public function store(AcademicYearRequest $request): RedirectResponse
    {
        $year = AcademicYear::create($request->validated());

        return redirect()->route('admin.academic-years.show', $year)
            ->with('status', 'Tahun akademik berhasil dibuat.');
    }

    public function show(AcademicYear $academicYear): View
    {
        $this->authorize('view', $academicYear);
        $academicYear->load('semesters');

        return view('admin.academic-years.show', ['year' => $academicYear]);
    }

    public function edit(AcademicYear $academicYear): View
    {
        $this->authorize('update', $academicYear);

        return view('admin.academic-years.edit', ['year' => $academicYear]);
    }

    public function update(AcademicYearRequest $request, AcademicYear $academicYear): RedirectResponse
    {
        $this->authorize('update', $academicYear);
        $academicYear->update($request->validated());

        return redirect()->route('admin.academic-years.show', $academicYear)
            ->with('status', 'Tahun akademik berhasil diperbarui.');
    }

    public function toggle(AcademicYear $academicYear): RedirectResponse
    {
        $this->authorize('toggleActive', $academicYear);
        $academicYear->update(['is_active' => ! $academicYear->is_active]);

        return back()->with('status', $academicYear->is_active ? 'Tahun akademik diaktifkan.' : 'Tahun akademik dinonaktifkan.');
    }
}
