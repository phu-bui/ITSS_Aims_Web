<?php

namespace Modules\Web\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => "Recipient's name has not been entered",
            'name.max' => "Recipient's name is too long",
            'phone.required' => 'Phone number is not entered',
            'phone.regex' => 'Phone number incorrect format',
            'email.required' => 'Email has not been entered',
            'email.email' => 'Email is not in the correct format',
            'email.max' => 'Email is too long',
            'address.required' => 'The address has not been entered',
            'shipNote.required' => 'Note has not been entered'
        ];
    }
}
