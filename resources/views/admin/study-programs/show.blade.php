@extends('layouts.app')

@section('title', 'Detail Program Studi — MyCampus LMS')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold">{{ $program->name }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.study-programs.edit', $program) }}" class="rounded bg-amber-500 px-3 py-1.5 text-sm font-semibold text-white hover:bg-amber-600">Ubah</a>
        <form method="POST" action="{{ route('admin.study-programs.toggle', $program) }}" onsubmit="return confirm('Ubah status aktif prodi ini?')">
            @csrf
            <button type="submit" class="rounded {{ $program->is_active ? 'bg-slate-500 hover:bg-slate-600' : 'bg-green-600 hover:bg-green-700' }} px-3 py-1.5 text-sm font-semibold text-white">
                {{ $program->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
    </div>
</div>

<dl class="grid max-w-2xl gap-3 rounded-lg bg-white p-6 shadow sm:grid-cols-2">
    <div><dt class="text-xs text-slate-500">Kode</dt><dd class="font-mono font-semibold">{{ $program->code }}</dd></div>
    <div><dt class="text-xs text-slate-500">Jenjang</dt><dd>{{ $program->degree ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Fakultas</dt><dd>{{ $program->faculty?->name ?? '-' }}</dd></div>
    <div><dt class="text-xs text-slate-500">Status</dt><dd>{{ $program->is_active ? 'Aktif' : 'Nonaktif' }}</dd></div>
</dl>

<p class="mt-4"><a href="{{ route('admin.study-programs.index') }}" class="text-sky-700 hover:underline">← Kembali ke daftar</a></p>
@endsection
