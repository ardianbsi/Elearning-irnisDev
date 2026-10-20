@extends('layouts.app')

@section('title', 'Program Studi — MyCampus LMS')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold">Program Studi</h1>
    <a href="{{ route('admin.study-programs.create') }}" class="rounded bg-sky-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-sky-700">+ Tambah</a>
</div>

@include('components.filter-form', ['action' => route('admin.study-programs.index')])

@if ($programs->isEmpty())
    <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
        <p class="font-semibold">Belum ada data.</p>
    </div>
@else
    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-3 py-2">Kode</th>
                    <th class="px-3 py-2">Nama</th>
                    <th class="px-3 py-2">Fakultas</th>
                    <th class="px-3 py-2">Jenjang</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                    <tr class="border-t">
                        <td class="px-3 py-2 font-mono">{{ $program->code }}</td>
                        <td class="px-3 py-2">{{ $program->name }}</td>
                        <td class="px-3 py-2">{{ $program->faculty?->name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $program->degree ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $program->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="px-3 py-2 text-right">
                            <a href="{{ route('admin.study-programs.show', $program) }}" class="text-sky-700 hover:underline">Detail</a>
                            <a href="{{ route('admin.study-programs.edit', $program) }}" class="ml-2 text-amber-700 hover:underline">Ubah</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $programs->links() }}</div>
@endif
@endsection
