@extends('layouts.app')

@section('title', 'Tambah Dosen — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Tambah Profil Dosen</h1>

@if ($users->isEmpty())
    <div class="max-w-lg rounded-lg bg-amber-50 p-4 text-sm text-amber-800">
        Tidak ada akun dosen yang belum memiliki profil. Buatkan akun user ber-role dosen terlebih dahulu.
    </div>
@else
    <form method="POST" action="{{ route('admin.lecturers.store') }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
        @csrf
        <div>
            <label for="user_id" class="mb-1 block text-sm font-medium">Akun pengguna</label>
            <select id="user_id" name="user_id" required class="w-full rounded border border-slate-300 px-3 py-2">
                <option value="">— Pilih —</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="faculty_id" class="mb-1 block text-sm font-medium">Fakultas</label>
            <select id="faculty_id" name="faculty_id" class="w-full rounded border border-slate-300 px-3 py-2">
                <option value="">—</option>
                @foreach ($faculties as $faculty)
                    <option value="{{ $faculty->id }}" @selected(old('faculty_id') == $faculty->id)>{{ $faculty->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="nip" class="mb-1 block text-sm font-medium">NIP</label>
                <input id="nip" name="nip" value="{{ old('nip') }}" required maxlength="30" class="w-full rounded border border-slate-300 px-3 py-2">
            </div>
            <div>
                <label for="position" class="mb-1 block text-sm font-medium">Jabatan</label>
                <input id="position" name="position" value="{{ old('position') }}" maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
            <a href="{{ route('admin.lecturers.index') }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
        </div>
    </form>
@endif
@endsection
