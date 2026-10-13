@extends('layouts.app')

@section('title', 'Masuk — MyCampus LMS')

@section('content')
<div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow">
    <h1 class="mb-1 text-2xl font-bold">Masuk</h1>
    <p class="mb-4 text-sm text-slate-600">Gunakan akun demo development: superadmin/admin/dosen/mahasiswa@example.com (password).</p>

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium">Kata sandi</label>
            <input id="password" type="password" name="password" required
                class="w-full rounded border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember" value="1" class="rounded">
                Ingat saya
            </label>
            <a href="{{ route('password.request') }}" class="text-sky-700 hover:underline">Lupa kata sandi?</a>
        </div>

        <button type="submit" class="w-full rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">
            Masuk
        </button>
    </form>
</div>
@endsection
