<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Message;
use App\Models\Registration;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $upcoming = Event::upcoming()->withCount('registrations')->orderBy('starts_at')->get();

        return view('admin.dashboard', [
            'eventCount'        => Event::count(),
            'upcoming'          => $upcoming,
            'registrationCount' => Registration::count(),
            'messageCount'      => Message::count(),
            'recent'            => Registration::with('event')->latest()->take(6)->get(),
        ]);
    }
}
