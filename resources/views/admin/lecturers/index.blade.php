@extends('layouts.app')

@section('title', 'Dosen — MyCampus LMS')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold">Dosen</h1>
    <a href="{{ route('admin.lecturers.create') }}" class="rounded bg-sky-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-sky-700">+ Tambah</a>
</div>

@include('components.filter-form', ['action' => route('admin.lecturers.index')])

@if ($lecturers->isEmpty())
    <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
        <p class="font-semibold">Belum ada data.</p>
    </div>
@else
    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-3 py-2">NIP</th>
                    <th class="px-3 py-2">Nama</th>
                    <th class="px-3 py-2">Fakultas</th>
                    <th class="px-3 py-2">Jabatan</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lecturers as $lecturer)
                    <tr class="border-t">
                        <td class="px-3 py-2 font-mono">{{ $lecturer->nip }}</td>
                        <td class="px-3 py-2">{{ $lecturer->user?->name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $lecturer->faculty?->name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $lecturer->position ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $lecturer->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="px-3 py-2 text-right">
                            <a href="{{ route('admin.lecturers.show', $lecturer) }}" class="text-sky-700 hover:underline">Detail</a>
                            <a href="{{ route('admin.lecturers.edit', $lecturer) }}" class="ml-2 text-amber-700 hover:underline">Ubah</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $lecturers->links() }}</div>
@endif
@endsection
