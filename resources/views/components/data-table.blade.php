@if ($items->isEmpty())
    <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">
        <p class="font-semibold">Belum ada data.</p>
        <p class="text-sm">Tambahkan data baru melalui tombol di atas.</p>
    </div>
@else
    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    @foreach ($headers as $header)
                        <th class="px-3 py-2 {{ $loop->last ? 'text-right' : '' }}">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-t">
                        @foreach ($columns($item) as $i => $column)
                            <td class="px-3 py-2 {{ $i === count($columns($item)) - 1 ? 'text-right' : '' }}">{!! $column !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $items->links() }}
    </div>
@endif
