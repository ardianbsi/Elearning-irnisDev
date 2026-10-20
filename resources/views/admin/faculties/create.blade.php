@extends('layouts.app')

@section('title', 'Tambah Fakultas — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Tambah Fakultas</h1>

<form method="POST" action="{{ route('admin.faculties.store') }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    <div>
        <label for="code" class="mb-1 block text-sm font-medium">Kode</label>
        <input id="code" name="code" value="{{ old('code') }}" required maxlength="20"
            class="w-full rounded border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
    </div>
    <div>
        <label for="name" class="mb-1 block text-sm font-medium">Nama</label>
        <input id="name" name="name" value="{{ old('name') }}" required maxlength="255"
            class="w-full rounded border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
    </div>
    <div class="flex gap-2">
        <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
        <a href="{{ route('admin.faculties.index') }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
    </div>
</form>
@endsection
