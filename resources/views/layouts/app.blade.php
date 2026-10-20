<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyCampus LMS')</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <nav class="bg-slate-900 text-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-4 py-3">
            <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="text-lg font-bold">
                MyCampus LMS
            </a>
            <div class="flex flex-wrap items-center gap-2 text-sm">
                @auth
                    <span class="rounded bg-slate-700 px-2 py-1">{{ auth()->user()->role->label() }}</span>
                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded bg-red-600 px-3 py-1.5 hover:bg-red-700">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded bg-sky-600 px-3 py-1.5 hover:bg-sky-700">Masuk</a>
                @endauth
            </div>
        </div>
        @auth
            <div class="border-t border-slate-700">
                <div class="mx-auto flex max-w-6xl flex-wrap gap-2 px-4 py-2 text-sm">
                    <a href="{{ route('dashboard') }}" class="rounded px-2 py-1 hover:bg-slate-700">Dasbor</a>
                    @if (auth()->user()->hasRole(\App\Enums\UserRole::Superadmin))
                        <a href="{{ route('dashboard.superadmin') }}" class="rounded px-2 py-1 hover:bg-slate-700">Superadmin</a>
                        <a href="{{ route('dashboard.admin') }}" class="rounded px-2 py-1 hover:bg-slate-700">Akademik</a>
                    @endif
                    @if (auth()->user()->hasRole(\App\Enums\UserRole::AdminAcademic))
                        <a href="{{ route('dashboard.admin') }}" class="rounded px-2 py-1 hover:bg-slate-700">Akademik</a>
                    @endif
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.faculties.index') }}" class="rounded px-2 py-1 hover:bg-slate-700">Fakultas</a>
                        <a href="{{ route('admin.study-programs.index') }}" class="rounded px-2 py-1 hover:bg-slate-700">Prodi</a>
                        <a href="{{ route('admin.academic-years.index') }}" class="rounded px-2 py-1 hover:bg-slate-700">Tahun</a>
                        <a href="{{ route('admin.semesters.index') }}" class="rounded px-2 py-1 hover:bg-slate-700">Semester</a>
                        <a href="{{ route('admin.courses.index') }}" class="rounded px-2 py-1 hover:bg-slate-700">Matkul</a>
                        <a href="{{ route('admin.rooms.index') }}" class="rounded px-2 py-1 hover:bg-slate-700">Ruang</a>
                        <a href="{{ route('admin.students.index') }}" class="rounded px-2 py-1 hover:bg-slate-700">Mahasiswa</a>
                        <a href="{{ route('admin.lecturers.index') }}" class="rounded px-2 py-1 hover:bg-slate-700">Dosen</a>
                    @endif
                    @if (auth()->user()->hasRole(\App\Enums\UserRole::Lecturer))
                        <a href="{{ route('dashboard.lecturer') }}" class="rounded px-2 py-1 hover:bg-slate-700">Dosen</a>
                    @endif
                    @if (auth()->user()->hasRole(\App\Enums\UserRole::Student))
                        <a href="{{ route('dashboard.student') }}" class="rounded px-2 py-1 hover:bg-slate-700">Mahasiswa</a>
                    @endif
                </div>
            </div>
        @endauth
    </nav>

    <main class="mx-auto w-full max-w-6xl px-4 py-6">
        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 px-4 py-3 text-green-800" role="status">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800" role="alert">
                <p class="font-semibold">Terjadi kesalahan:</p>
                <ul class="ml-5 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mx-auto max-w-6xl px-4 pb-8 text-center text-xs text-slate-500">
        MyCampus LMS — Fase 1 Fondasi
    </footer>
</body>
</html>
