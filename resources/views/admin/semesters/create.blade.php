@extends('layouts.app')

@section('title', 'Tambah Semester — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Tambah Semester</h1>

<form method="POST" action="{{ route('admin.semesters.store') }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    <div>
        <label for="academic_year_id" class="mb-1 block text-sm font-medium">Tahun akademik</label>
        <select id="academic_year_id" name="academic_year_id" required class="w-full rounded border border-slate-300 px-3 py-2">
            <option value="">— Pilih —</option>
            @foreach ($years as $year)
                <option value="{{ $year->id }}" @selected(old('academic_year_id') == $year->id)>{{ $year->code }} — {{ $year->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label for="term_code" class="mb-1 block text-sm font-medium">Kode termin</label>
            <select id="term_code" name="term_code" required class="w-full rounded border border-slate-300 px-3 py-2">
                <option value="">— Pilih —</option>
                @foreach (['ganjil', 'genap', 'pendek'] as $term)
                    <option value="{{ $term }}" @selected(old('term_code') == $term)>{{ ucfirst($term) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="name" class="mb-1 block text-sm font-medium">Nama</label>
            <input id="name" name="name" value="{{ old('name') }}" required maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
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
        <a href="{{ route('admin.semesters.index') }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
    </div>
</form>
@endsection
