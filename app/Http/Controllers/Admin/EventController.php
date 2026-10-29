<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function index(): View
    {
        return view('admin.events.index', [
            'events' => Event::withCount('registrations')->orderByDesc('starts_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.form', [
            'event' => new Event(['category' => Event::CATEGORIES[0], 'capacity' => 100, 'fee' => 0]),
        ]);
    }

    public function store(EventRequest $request): RedirectResponse
    {
        Event::create($request->validated());

        return redirect()->route('admin.events.index')->with('success', 'Event added.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.form', ['event' => $event]);
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->validated());

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->registrations()->delete();
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event and its registrations were deleted.');
    }
}
