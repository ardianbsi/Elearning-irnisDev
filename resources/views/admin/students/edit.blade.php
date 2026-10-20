@extends('layouts.app')

@section('title', 'Ubah Mahasiswa — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Ubah Profil Mahasiswa</h1>

<form method="POST" action="{{ route('admin.students.update', $student) }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    @method('PUT')
    <div>
        <label class="mb-1 block text-sm font-medium">Akun (tidak dapat diganti)</label>
        <p class="rounded bg-slate-100 px-3 py-2 text-sm">{{ $student->user?->name }} ({{ $student->user?->email }})</p>
    </div>
    <div>
        <label for="study_program_id" class="mb-1 block text-sm font-medium">Program studi</label>
        <select id="study_program_id" name="study_program_id" class="w-full rounded border border-slate-300 px-3 py-2">
            <option value="">—</option>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}" @selected(old('study_program_id', $student->study_program_id) == $program->id)>{{ $program->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label for="nim" class="mb-1 block text-sm font-medium">NIM</label>
            <input id="nim" name="nim" value="{{ old('nim', $student->nim) }}" required maxlength="30" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label for="cohort" class="mb-1 block text-sm font-medium">Angkatan</label>
            <input id="cohort" name="cohort" value="{{ old('cohort', $student->cohort) }}" maxlength="10" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
    </div>
    <div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $student->is_active)) class="rounded"> Aktif
        </label>
    </div>
    <div class="flex gap-2">
        <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
        <a href="{{ route('admin.students.show', $student) }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
    </div>
</form>
@endsection
