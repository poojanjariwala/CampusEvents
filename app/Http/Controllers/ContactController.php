<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Message;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Message::create([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'subject' => $data['subject'],
            'body'    => $data['message'],
        ]);

        return redirect()->route('contact')
            ->with('success', 'Thanks, your message has been sent. We will reply within two working days.');
    }
}
