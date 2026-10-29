<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Event;
use App\Models\Registration;
use DomainException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function store(RegistrationRequest $request, Event $event): RedirectResponse
    {
        if ($event->isPast()) {
            return back()->withInput()->withErrors(['form' => 'This event has already taken place.']);
        }

        $data = $request->validated();

        try {
            $registration = DB::transaction(function () use ($event, $data) {
                $taken = Registration::where('event_id', $event->id)->count();
                if ($taken >= $event->capacity) {
                    throw new DomainException('Sorry, all seats were just taken.');
                }

                $duplicate = Registration::where('event_id', $event->id)
                    ->where(fn ($q) => $q->where('email', $data['email'])
                        ->orWhere('enrollment', $data['enrollment']))
                    ->exists();
                if ($duplicate) {
                    throw new DomainException('This email or enrolment number is already registered for this event.');
                }

                return $event->registrations()->create([
                    'name'       => $data['name'],
                    'email'      => $data['email'],
                    'enrollment' => $data['enrollment'],
                    'phone'      => $data['phone'],
                    'class_name' => $data['class_name'],
                ]);
            });
        } catch (DomainException $e) {
            return back()->withInput()->withErrors(['form' => $e->getMessage()]);
        }

        // remember which registration this browser just made so only they can see the ticket
        session(['last_registration' => $registration->id]);

        return redirect()->route('registration.success', $registration);
    }

    public function success(Registration $registration): View|RedirectResponse
    {
        if (session('last_registration') !== $registration->id) {
            return redirect()->route('events.index');
        }

        return view('events.success', [
            'registration' => $registration->load('event'),
        ]);
    }
}
