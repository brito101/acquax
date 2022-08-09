<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ComplexRequest extends FormRequest
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
            'social_name' => 'required|min:2|max:100',
            'alias_name' => 'required|min:2|max:100',
            'document_company' => "required|min:11|max:18",
            'document_company_secondary' => 'max:100',
            'email' => "required|min:8|max:100",
            'telephone' => 'required|min:8|max:25',
            'cell' => 'max:25',
            'zipcode' => 'required|min:8|max:13',
            'street' => 'required|min:3|max:100',
            'number' => 'required|min:1|max:100',
            'complement' => 'max:100',
            'neighborhood' => 'max:100',
            'state' => 'required|min:2|max:3',
            'city' => 'required|min:2|max:100',
            'photo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:1024|dimensions:max_width=1800,max_height=1800',
            'facebook' => 'nullable|url|max:150',
            'instagram' => 'nullable|url|max:150',
            'twitter' => 'nullable|url|max:150',
            'status' => 'nullable|min:3|max:20',
        ];
    }
}
