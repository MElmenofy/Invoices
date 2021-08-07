<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductsRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => 'required|unique:products|max:255',
            'description' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'product_name.required' => 'يرجى ادخال اسم القسم',
            'product_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجى ادخال البيان',
        ];
    }

}
