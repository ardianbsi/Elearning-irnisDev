@extends('layouts.app')

@section('title', 'Tambah Tahun Akademik — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Tambah Tahun Akademik</h1>

<form method="POST" action="{{ route('admin.academic-years.store') }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    <div>
        <label for="code" class="mb-1 block text-sm font-medium">Kode (contoh: 2025/2026)</label>
        <input id="code" name="code" value="{{ old('code') }}" required maxlength="20" class="w-full rounded border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label for="name" class="mb-1 block text-sm font-medium">Nama</label>
        <input id="name" name="name" value="{{ old('name') }}" required maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label for="starts_at" class="mb-1 block text-sm font-medium">Mulai</label>
            <input id="starts_at" type="date" name="starts_at" value="{{ old('starts_at') }}" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label for="ends_at" class="mb-1 block text-sm font-medium">Selesai</label>
            <input id="ends_at" type="date" name="ends_at" value="{{ old('ends_at') }}" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
    </div>
    <div class="flex gap-2">
        <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
        <a href="{{ route('admin.academic-years.index') }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
    </div>
</form>
@endsection
