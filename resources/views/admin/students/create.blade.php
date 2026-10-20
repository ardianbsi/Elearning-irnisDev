@extends('layouts.app')

@section('title', 'Tambah Mahasiswa — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Tambah Profil Mahasiswa</h1>

@if ($users->isEmpty())
    <div class="max-w-lg rounded-lg bg-amber-50 p-4 text-sm text-amber-800">
        Tidak ada akun mahasiswa yang belum memiliki profil. Buatkan akun user ber-role mahasiswa terlebih dahulu.
    </div>
@else
    <form method="POST" action="{{ route('admin.students.store') }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
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
            <label for="study_program_id" class="mb-1 block text-sm font-medium">Program studi</label>
            <select id="study_program_id" name="study_program_id" class="w-full rounded border border-slate-300 px-3 py-2">
                <option value="">—</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}" @selected(old('study_program_id') == $program->id)>{{ $program->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="nim" class="mb-1 block text-sm font-medium">NIM</label>
                <input id="nim" name="nim" value="{{ old('nim') }}" required maxlength="30" class="w-full rounded border border-slate-300 px-3 py-2">
            </div>
            <div>
                <label for="cohort" class="mb-1 block text-sm font-medium">Angkatan</label>
                <input id="cohort" name="cohort" value="{{ old('cohort') }}" maxlength="10" placeholder="2024" class="w-full rounded border border-slate-300 px-3 py-2">
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
            <a href="{{ route('admin.students.index') }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
        </div>
    </form>
@endif
@endsection
