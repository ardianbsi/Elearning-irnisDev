@extends('layouts.app')

@section('title', 'Ubah Mata Kuliah — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Ubah Mata Kuliah</h1>

<form method="POST" action="{{ route('admin.courses.update', $course) }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    @method('PUT')
    <div>
        <label for="study_program_id" class="mb-1 block text-sm font-medium">Program studi</label>
        <select id="study_program_id" name="study_program_id" class="w-full rounded border border-slate-300 px-3 py-2">
            <option value="">— Umum —</option>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}" @selected(old('study_program_id', $course->study_program_id) == $program->id)>{{ $program->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label for="code" class="mb-1 block text-sm font-medium">Kode</label>
            <input id="code" name="code" value="{{ old('code', $course->code) }}" required maxlength="20" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label for="credits" class="mb-1 block text-sm font-medium">SKS</label>
            <input id="credits" type="number" name="credits" value="{{ old('credits', $course->credits) }}" required min="0" max="12" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
    </div>
    <div>
        <label for="name" class="mb-1 block text-sm font-medium">Nama</label>
        <input id="name" name="name" value="{{ old('name', $course->name) }}" required maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label for="description" class="mb-1 block text-sm font-medium">Deskripsi</label>
        <textarea id="description" name="description" rows="3" class="w-full rounded border border-slate-300 px-3 py-2">{{ old('description', $course->description) }}</textarea>
    </div>
    <div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $course->is_active)) class="rounded"> Aktif
        </label>
    </div>
    <div class="flex gap-2">
        <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
        <a href="{{ route('admin.courses.show', $course) }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
    </div>
</form>
@endsection
