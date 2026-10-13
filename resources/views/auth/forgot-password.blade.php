@extends('layouts.app')

@section('title', 'Lupa Kata Sandi — MyCampus LMS')

@section('content')
<div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow">
    <h1 class="mb-1 text-2xl font-bold">Lupa kata sandi</h1>
    <p class="mb-4 text-sm text-slate-600">Masukkan email Anda. Pada development, tautan reset tercatat di log (MAIL_MAILER=log).</p>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full rounded border border-slate-300 px-3 py-2 focus:border-sky-500 focus:outline-none">
        </div>
        <button type="submit" class="w-full rounded bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">
            Kirim tautan reset
        </button>
    </form>
</div>
@endsection
