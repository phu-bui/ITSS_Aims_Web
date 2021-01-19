<?php

namespace Modules\Admin\Http\Requests;

use App\Rules\ProductPriceRule;
use Illuminate\Foundation\Http\FormRequest;

class PromotionCRUDRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discount' => 'required|min:10|max:80|numeric',
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
            'discount.required' => "Discount has not been entered",
            'discount.max' => "Discount is less than 80%",
            'discount.min' => "Discount over 10%",
            'discount.numeric' => "Discount is a number",
        ];
    }
}
