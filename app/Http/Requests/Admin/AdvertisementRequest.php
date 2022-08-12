<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
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
            'title' => 'required|min:1|max:100',
            'cover' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:10240',
            'link' => 'required|url|max:191',
            'status' => 'nullable|min:3|max:20|in:Ativo,Inativo'
        ];
    }
}
