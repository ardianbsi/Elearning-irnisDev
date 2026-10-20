@extends('layouts.app')

@section('title', 'Detail Mata Kuliah — MyCampus LMS')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold">{{ $course->name }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.courses.edit', $course) }}" class="rounded bg-amber-500 px-3 py-1.5 text-sm font-semibold text-white hover:bg-amber-600">Ubah</a>
        <form method="POST" action="{{ route('admin.courses.toggle', $course) }}" onsubmit="return confirm('Ubah status aktif mata kuliah ini?')">
            @csrf
            <button type="submit" class="rounded {{ $course->is_active ? 'bg-slate-500 hover:bg-slate-600' : 'bg-green-600 hover:bg-green-700' }} px-3 py-1.5 text-sm font-semibold text-white">
                {{ $course->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
    </div>
</div>

<dl class="grid max-w-2xl gap-3 rounded-lg bg-white p-6 shadow sm:grid-cols-2">
    <div><dt class="text-xs text-slate-500">Kode</dt><dd class="font-mono font-semibold">{{ $course->code }}</dd></div>
    <div><dt class="text-xs text-slate-500">SKS</dt><dd>{{ $course->credits }}</dd></div>
    <div><dt class="text-xs text-slate-500">Program studi</dt><dd>{{ $course->studyProgram?->name ?? 'Umum' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Fakultas</dt><dd>{{ $course->studyProgram?->faculty?->name ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Status</dt><dd>{{ $course->is_active ? 'Aktif' : 'Nonaktif' }}</dd></div>
    <div class="sm:col-span-2"><dt class="text-xs text-slate-500">Deskripsi</dt><dd>{{ $course->description ?? '-' }}</dd></div>
</dl>

<p class="mt-4"><a href="{{ route('admin.courses.index') }}" class="text-sky-700 hover:underline">← Kembali ke daftar</a></p>
@endsection
