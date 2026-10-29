<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $upcoming = Event::upcoming()
            ->withCount('registrations')
            ->orderBy('starts_at')
            ->get();

        return view('home', [
            'next'              => $upcoming->first(),
            'featured'          => $upcoming->take(3),
            'upcomingCount'     => $upcoming->count(),
            'registrationCount' => Registration::count(),
            'categoryCounts'    => $upcoming->countBy('category'),
        ]);
    }

    public function about(): View
    {
        return view('about');
    }
}
