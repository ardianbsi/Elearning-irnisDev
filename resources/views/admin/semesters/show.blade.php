@extends('layouts.app')

@section('title', 'Detail Semester — MyCampus LMS')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold">{{ $semester->name }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.semesters.edit', $semester) }}" class="rounded bg-amber-500 px-3 py-1.5 text-sm font-semibold text-white hover:bg-amber-600">Ubah</a>
        <form method="POST" action="{{ route('admin.semesters.toggle', $semester) }}" onsubmit="return confirm('Ubah status aktif semester ini?')">
            @csrf
            <button type="submit" class="rounded {{ $semester->is_active ? 'bg-slate-500 hover:bg-slate-600' : 'bg-green-600 hover:bg-green-700' }} px-3 py-1.5 text-sm font-semibold text-white">
                {{ $semester->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
    </div>
</div>

<dl class="grid max-w-2xl gap-3 rounded-lg bg-white p-6 shadow sm:grid-cols-2">
    <div><dt class="text-xs text-slate-500">Tahun akademik</dt><dd>{{ $semester->academicYear?->code ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Termin</dt><dd>{{ $semester->term_code }}</dd></div>
    <div><dt class="text-xs text-slate-500">Mulai</dt><dd>{{ $semester->starts_at?->format('d/m/Y') ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Selesai</dt><dd>{{ $semester->ends_at?->format('d/m/Y') ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Status</dt><dd>{{ $semester->is_active ? 'Aktif' : 'Nonaktif' }}</dd></div>
</dl>

<p class="mt-4"><a href="{{ route('admin.semesters.index') }}" class="text-sky-700 hover:underline">← Kembali ke daftar</a></p>
@endsection
