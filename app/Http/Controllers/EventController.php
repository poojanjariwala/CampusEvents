<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $category = in_array($request->query('cat'), Event::CATEGORIES, true) ? $request->query('cat') : null;
        $term = trim((string) $request->query('q', ''));
        $show = in_array($request->query('show'), ['upcoming', 'past', 'all'], true)
            ? $request->query('show')
            : 'upcoming';

        $events = Event::query()
            ->withCount('registrations')
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($term !== '', function ($q) use ($term) {
                $like = '%' . addcslashes($term, '%_\\') . '%';
                $q->where(fn ($w) => $w->where('title', 'like', $like)
                    ->orWhere('venue', 'like', $like)
                    ->orWhere('organizer', 'like', $like));
            })
            ->when($show === 'upcoming', fn ($q) => $q->upcoming())
            ->when($show === 'past', fn ($q) => $q->past())
            ->orderBy('starts_at', $show === 'past' ? 'desc' : 'asc')
            ->get();

        return view('events.index', [
            'events'   => $events,
            'category' => $category,
            'term'     => $term,
            'show'     => $show,
        ]);
    }

    public function show(Event $event): View
    {
        $event->loadCount('registrations');

        return view('events.show', [
            'event'        => $event,
            'classOptions' => Registration::CLASS_OPTIONS,
        ]);
    }
}
