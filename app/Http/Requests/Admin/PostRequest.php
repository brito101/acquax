<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|max:100',
            'headline' => 'nullable|max:100',
            'content' => 'required',
            'cover' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:1024|dimensions:max_width=1800,max_height=1800',
            'status' => 'nullable|in:Publicado,Rascunho,Lixo|max:191'
        ];
    }
}
