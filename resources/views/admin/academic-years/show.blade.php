@extends('layouts.app')

@section('title', 'Detail Tahun Akademik — MyCampus LMS')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold">{{ $year->name }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.academic-years.edit', $year) }}" class="rounded bg-amber-500 px-3 py-1.5 text-sm font-semibold text-white hover:bg-amber-600">Ubah</a>
        <form method="POST" action="{{ route('admin.academic-years.toggle', $year) }}" onsubmit="return confirm('Ubah status aktif tahun akademik ini?')">
            @csrf
            <button type="submit" class="rounded {{ $year->is_active ? 'bg-slate-500 hover:bg-slate-600' : 'bg-green-600 hover:bg-green-700' }} px-3 py-1.5 text-sm font-semibold text-white">
                {{ $year->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
    </div>
</div>

<dl class="grid max-w-2xl gap-3 rounded-lg bg-white p-6 shadow sm:grid-cols-2">
    <div><dt class="text-xs text-slate-500">Kode</dt><dd class="font-mono font-semibold">{{ $year->code }}</dd></div>
    <div><dt class="text-xs text-slate-500">Status</dt><dd>{{ $year->is_active ? 'Aktif' : 'Nonaktif' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Mulai</dt><dd>{{ $year->starts_at?->format('d/m/Y') ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Selesai</dt><dd>{{ $year->ends_at?->format('d/m/Y') ?? '-' }}</dd></div>
</dl>

<h2 class="mb-2 mt-6 text-lg font-bold">Semester</h2>
<ul class="max-w-2xl space-y-2">
    @forelse ($year->semesters as $semester)
        <li class="rounded bg-white px-4 py-2 shadow">
            <a href="{{ route('admin.semesters.show', $semester) }}" class="text-sky-700 hover:underline">{{ $semester->name }}</a>
            <span class="text-sm text-slate-500">({{ $semester->term_code }})</span>
        </li>
    @empty
        <li class="text-slate-500">Belum ada semester.</li>
    @endforelse
</ul>

<p class="mt-4"><a href="{{ route('admin.academic-years.index') }}" class="text-sky-700 hover:underline">← Kembali ke daftar</a></p>
@endsection
