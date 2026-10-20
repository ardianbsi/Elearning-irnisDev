@extends('layouts.app')

@section('title', 'Mahasiswa — MyCampus LMS')

@section('content')
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <h1 class="text-2xl font-bold">Mahasiswa</h1>
    <a href="{{ route('admin.students.create') }}" class="rounded bg-sky-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-sky-700">+ Tambah</a>
</div>

@include('components.filter-form', ['action' => route('admin.students.index')])

@if ($students->isEmpty())
    <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
        <p class="font-semibold">Belum ada data.</p>
    </div>
@else
    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="px-3 py-2">NIM</th>
                    <th class="px-3 py-2">Nama</th>
                    <th class="px-3 py-2">Prodi</th>
                    <th class="px-3 py-2">Angkatan</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr class="border-t">
                        <td class="px-3 py-2 font-mono">{{ $student->nim }}</td>
                        <td class="px-3 py-2">{{ $student->user?->name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $student->studyProgram?->name ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $student->cohort ?? '-' }}</td>
                        <td class="px-3 py-2">{{ $student->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="px-3 py-2 text-right">
                            <a href="{{ route('admin.students.show', $student) }}" class="text-sky-700 hover:underline">Detail</a>
                            <a href="{{ route('admin.students.edit', $student) }}" class="ml-2 text-amber-700 hover:underline">Ubah</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $students->links() }}</div>
@endif
@endsection
