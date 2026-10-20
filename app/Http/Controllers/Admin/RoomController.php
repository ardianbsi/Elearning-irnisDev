<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Room::class);

        $rooms = Room::query()
            ->when($request->input('q'), fn ($q, $search) => $q->where(fn ($w) => $w
                ->where('code', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")))
            ->orderBy('code')
            ->paginate(15)
            ->withQueryString();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        $this->authorize('create', Room::class);

        return view('admin.rooms.create');
    }

    public function store(RoomRequest $request): RedirectResponse
    {
        $room = Room::create($request->validated());

        return redirect()->route('admin.rooms.show', $room)
            ->with('status', 'Ruang berhasil dibuat.');
    }

    public function show(Room $room): View
    {
        $this->authorize('view', $room);

        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room): View
    {
        $this->authorize('update', $room);

        return view('admin.rooms.edit', compact('room'));
    }

    public function update(RoomRequest $request, Room $room): RedirectResponse
    {
        $this->authorize('update', $room);
        $room->update($request->validated());

        return redirect()->route('admin.rooms.show', $room)
            ->with('status', 'Ruang berhasil diperbarui.');
    }

    public function toggle(Room $room): RedirectResponse
    {
        $this->authorize('toggleActive', $room);
        $room->update(['is_active' => ! $room->is_active]);

        return back()->with('status', $room->is_active ? 'Ruang diaktifkan.' : 'Ruang dinonaktifkan.');
    }
}
