@extends('layouts.app')

@section('title', 'Ubah Program Studi — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Ubah Program Studi</h1>

<form method="POST" action="{{ route('admin.study-programs.update', $program) }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    @method('PUT')
    <div>
        <label for="faculty_id" class="mb-1 block text-sm font-medium">Fakultas</label>
        <select id="faculty_id" name="faculty_id" required class="w-full rounded border border-slate-300 px-3 py-2">
            @foreach ($faculties as $faculty)
                <option value="{{ $faculty->id }}" @selected(old('faculty_id', $program->faculty_id) == $faculty->id)>{{ $faculty->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="code" class="mb-1 block text-sm font-medium">Kode</label>
        <input id="code" name="code" value="{{ old('code', $program->code) }}" required maxlength="20" class="w-full rounded border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label for="name" class="mb-1 block text-sm font-medium">Nama</label>
        <input id="name" name="name" value="{{ old('name', $program->name) }}" required maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label for="degree" class="mb-1 block text-sm font-medium">Jenjang</label>
        <select id="degree" name="degree" class="w-full rounded border border-slate-300 px-3 py-2">
            <option value="">—</option>
            @foreach (['D3', 'D4', 'S1', 'S2', 'S3'] as $degree)
                <option value="{{ $degree }}" @selected(old('degree', $program->degree) == $degree)>{{ $degree }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $program->is_active)) class="rounded"> Aktif
        </label>
    </div>
    <div class="flex gap-2">
        <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
        <a href="{{ route('admin.study-programs.show', $program) }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
    </div>
</form>
@endsection
