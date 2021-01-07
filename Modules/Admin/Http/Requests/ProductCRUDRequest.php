<?php

namespace Modules\Admin\Http\Requests;

use App\Rules\ProductPriceRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductCRUDRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:250',
            'image' => 'required|url',
            'value' => 'required|numeric|min:0',
            'price' => ['required', 'numeric', 'min:0', new ProductPriceRule($this->all())],
            'description' => 'required',
            'quantity' => 'required|numeric|min:0',
            'language' => 'required'
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
            'title.required' => "Title has not been entered",
            'title.max' => "Title is too long",
            'image.required' => "Illustrative image has not been imported",
            'image.url' => "Invalid image link",
            'value.required' => "Value has not been entered",
            'value.numeric' => "Value is not valid",
            'value.min' => "Value must be greater than 0",
            'price.required' => "Price has not been entered",
            'price.numeric' => "Price is not valid",
            'price.min' => "Price must be greater than 0",
            'description.required' => 'Description has not been entered',
            'quantity.required' => "Quantity has not been entered",
            'quantity.numeric' => "Quantity is not valid",
            'quantity.min' => "Quantity must be greater than 0",
            'language.required' => "The product language has not been recognized",
        ];
    }
}
