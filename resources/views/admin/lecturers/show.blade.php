@extends('layouts.app')

@section('title', 'Detail Dosen — MyCampus LMS')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold">{{ $lecturer->user?->name ?? 'Dosen' }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.lecturers.edit', $lecturer) }}" class="rounded bg-amber-500 px-3 py-1.5 text-sm font-semibold text-white hover:bg-amber-600">Ubah</a>
        <form method="POST" action="{{ route('admin.lecturers.toggle', $lecturer) }}" onsubmit="return confirm('Ubah status aktif dosen ini?')">
            @csrf
            <button type="submit" class="rounded {{ $lecturer->is_active ? 'bg-slate-500 hover:bg-slate-600' : 'bg-green-600 hover:bg-green-700' }} px-3 py-1.5 text-sm font-semibold text-white">
                {{ $lecturer->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
    </div>
</div>

<dl class="grid max-w-2xl gap-3 rounded-lg bg-white p-6 shadow sm:grid-cols-2">
    <div><dt class="text-xs text-slate-500">NIP</dt><dd class="font-mono font-semibold">{{ $lecturer->nip }}</dd></div>
    <div><dt class="text-xs text-slate-500">Jabatan</dt><dd>{{ $lecturer->position ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Email</dt><dd>{{ $lecturer->user?->email ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Fakultas</dt><dd>{{ $lecturer->faculty?->name ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Status</dt><dd>{{ $lecturer->is_active ? 'Aktif' : 'Nonaktif' }}</dd></div>
</dl>

<p class="mt-4"><a href="{{ route('admin.lecturers.index') }}" class="text-sky-700 hover:underline">← Kembali ke daftar</a></p>
@endsection
