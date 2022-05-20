<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
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

    protected function prepareForValidation()
    {

        $this->merge([
            'fraction' => str_replace(',', '.', str_replace(['.', '%', '_'], '', ($this->fraction ?? 0)))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:100',
            'status' => 'nullable|min:3|max:20',
            'fraction' => 'nullable|numeric|between:0,999',
        ];
    }
}
