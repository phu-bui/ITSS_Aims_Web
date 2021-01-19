<?php

namespace Modules\Admin\Http\Requests;

use App\Rules\ProductPriceRule;
use Illuminate\Foundation\Http\FormRequest;

class UserCRUDRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' =>'required|email',
            'password' => 'required|min:6',
            'phone_number' => 'required|regex:/^0(\d{9})$/i'
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
            'email.required' => "Email has not been entered",
            'email.email' => "Email must be in @ gmail.com format",
            'password.required' => "Password has not been entered",
            'password.min' => "Password longer than 6 characters",
            'phone_number.required' => 'Phone number has not been entered',
            'phone_number.regex' => 'Phone number incorrect format',
        ];
    }
}
