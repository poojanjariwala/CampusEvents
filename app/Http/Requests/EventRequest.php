<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // the route is already behind the admin middleware
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'min:3', 'max:90'],
            'category'    => ['required', Rule::in(Event::CATEGORIES)],
            'starts_at'   => ['required', 'date'],
            'venue'       => ['required', 'string', 'min:2', 'max:100'],
            'organizer'   => ['required', 'string', 'min:2', 'max:100'],
            'description' => ['required', 'string', 'min:20', 'max:3000'],
            'capacity'    => ['required', 'integer', 'min:1', 'max:5000'],
            'fee'         => ['required', 'integer', 'min:0', 'max:10000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.min'       => 'Title should be 3-90 characters.',
            'title.max'       => 'Title should be 3-90 characters.',
            'starts_at.date'  => 'Pick a valid date and time.',
            'description.min' => 'Describe the event in at least 20 characters.',
            'capacity.min'    => 'Capacity must be between 1 and 5000.',
            'capacity.max'    => 'Capacity must be between 1 and 5000.',
            'fee.min'         => 'Fee must be between 0 and 10000.',
            'fee.max'         => 'Fee must be between 0 and 10000.',
        ];
    }

    /** When editing, the seat count can't be lowered below the people already registered. */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $event = $this->route('event');

                if ($event instanceof Event && (int) $this->input('capacity') < $event->registrations()->count()) {
                    $validator->errors()->add(
                        'capacity',
                        'Already ' . $event->registrations()->count() . ' people registered; capacity cannot be lower.'
                    );
                }
            },
        ];
    }
}
