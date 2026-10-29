<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:60'],
            'email'   => ['required', 'email', 'max:100'],
            'subject' => ['required', 'string', 'min:3', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Enter your name.',
            'email.required'   => 'Enter your email address.',
            'email.email'      => 'Enter a valid email address.',
            'subject.required' => 'Enter a subject.',
            'subject.min'      => 'Subject should be 3-100 characters.',
            'subject.max'      => 'Subject should be 3-100 characters.',
            'message.required' => 'Write a message.',
            'message.min'      => 'Message should be 10-1000 characters.',
            'message.max'      => 'Message should be 10-1000 characters.',
        ];
    }
}
