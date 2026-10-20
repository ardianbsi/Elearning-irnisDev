@extends('layouts.app')

@section('title', 'Ubah Ruang — MyCampus LMS')

@section('content')
<h1 class="mb-4 text-2xl font-bold">Ubah Ruang</h1>

<form method="POST" action="{{ route('admin.rooms.update', $room) }}" class="max-w-lg space-y-4 rounded-lg bg-white p-6 shadow">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label for="code" class="mb-1 block text-sm font-medium">Kode</label>
            <input id="code" name="code" value="{{ old('code', $room->code) }}" required maxlength="20" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
        <div>
            <label for="capacity" class="mb-1 block text-sm font-medium">Kapasitas</label>
            <input id="capacity" type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" min="1" max="1000" class="w-full rounded border border-slate-300 px-3 py-2">
        </div>
    </div>
    <div>
        <label for="name" class="mb-1 block text-sm font-medium">Nama</label>
        <input id="name" name="name" value="{{ old('name', $room->name) }}" required maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label for="location" class="mb-1 block text-sm font-medium">Lokasi</label>
        <input id="location" name="location" value="{{ old('location', $room->location) }}" maxlength="255" class="w-full rounded border border-slate-300 px-3 py-2">
    </div>
    <div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $room->is_active)) class="rounded"> Aktif
        </label>
    </div>
    <div class="flex gap-2">
        <button type="submit" class="rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Simpan</button>
        <a href="{{ route('admin.rooms.show', $room) }}" class="rounded border border-slate-300 px-4 py-2 hover:bg-slate-100">Batal</a>
    </div>
</form>
@endsection
