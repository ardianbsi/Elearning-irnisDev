@extends('layouts.app')

@section('title', 'Reset Kata Sandi — MyCampus LMS')

@section('content')
<div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow">
    <h1 class="mb-4 text-2xl font-bold">Reset kata sandi</h1>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required
                class="w-full rounded border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium">Kata sandi baru</label>
            <input id="password" type="password" name="password" required
                class="w-full rounded border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium">Konfirmasi kata sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full rounded border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
        </div>

        <button type="submit" class="w-full rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">
            Ubah kata sandi
        </button>
    </form>
</div>
@endsection
