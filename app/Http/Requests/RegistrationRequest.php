<?php

namespace App\Http\Requests;

use App\Models\Registration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'       => trim((string) $this->input('name')),
            'email'      => strtolower(trim((string) $this->input('email'))),
            'enrollment' => strtoupper(trim((string) $this->input('enrollment'))),
            'phone'      => trim((string) $this->input('phone')),
        ]);
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'min:2', 'max:60', "regex:/^[A-Za-z][A-Za-z .'-]*$/"],
            'email'      => ['required', 'email', 'max:100'],
            'enrollment' => ['required', 'alpha_num', 'min:6', 'max:15'],
            'phone'      => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'class_name' => ['required', Rule::in(Registration::CLASS_OPTIONS)],
            'consent'    => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Enter your full name.',
            'name.regex'          => 'Enter your full name (letters only, 2-60 characters).',
            'email.required'      => 'Enter your email address.',
            'email.email'         => 'Enter a valid email address.',
            'enrollment.required' => 'Enter your enrolment number.',
            'enrollment.alpha_num'=> 'Enrolment number should be 6-15 letters or digits.',
            'enrollment.min'      => 'Enrolment number should be 6-15 letters or digits.',
            'enrollment.max'      => 'Enrolment number should be 6-15 letters or digits.',
            'phone.required'      => 'Enter your mobile number.',
            'phone.regex'         => 'Enter a 10-digit mobile number.',
            'class_name.required' => 'Select your class.',
            'class_name.in'       => 'Select your class.',
            'consent.accepted'    => 'Please confirm the details are correct.',
        ];
    }
}
