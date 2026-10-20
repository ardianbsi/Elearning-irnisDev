@extends('layouts.app')

@section('title', 'Ubah Dosen — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Ubah Profil Dosen</h1>

<form method="POST" action="{{ route('admin.lecturers.update', $lecturer) }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    @method('PUT')
    <div>
        <label class="mb-1 block text-sm font-medium">Akun (tidak dapat diganti)</label>
        <p class="rounded bg-slate-100 px-3 py-2 text-sm">{{ $lecturer->user?->name }} ({{ $lecturer->user?->email }})</p>
    </div>
    <div>
        <label for="faculty_id" class="mb-1 block text-sm font-medium">Fakultas</label>
        <select id="faculty_id" name="faculty_id" class="w-full rounded border border-slate-300 px-3 py-2">
            <option value="">—</option>
            @foreach ($faculties as $faculty)
                <option value="{{ $faculty->id }}" @selected(old('faculty_id', $lecturer->faculty_id) == $faculty->id)>{{ $faculty->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label for="nip" class="mb-1 block text-sm font-medium">NIP</label>
            <input id="nip" name="nip" value="{{ old('nip', $lecturer->nip) }}" required maxlength="30" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label for="position" class="mb-1 block text-sm font-medium">Jabatan</label>
            <input id="position" name="position" value="{{ old('position', $lecturer->position) }}" maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
    </div>
    <div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $lecturer->is_active)) class="rounded"> Aktif
        </label>
    </div>
    <div class="flex gap-2">
        <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
        <a href="{{ route('admin.lecturers.show', $lecturer) }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
    </div>
</form>
@endsection
