<form method="GET" action="{{ $action }}" class="mb-4 flex flex-wrap items-end gap-2 rounded-lg bg-white p-3 shadow">
    <div class="min-w-52 flex-1">
        <label for="q" class="mb-1 block text-xs font-medium text-slate-600">Cari</label>
        <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Kata kunci…"
            class="w-full rounded border border-slate-300 px-3 py-1.5 text-sm focus:border-sky-500 focus:outline-none">
    </div>
    <div class="flex gap-2">
        <button type="submit" class="rounded bg-sky-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-sky-700">Filter</button>
        <a href="{{ $action }}" class="rounded border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-100">Reset</a>
    </div>
</form>
