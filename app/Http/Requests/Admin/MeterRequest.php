<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MeterRequest extends FormRequest
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
            'register' => "required|min:1|max:191|unique:meters,register,{$this->id},id,deleted_at,NULL",
            'status' => 'nullable|min:3|max:20',
            'apartment_id' => 'required|min:1|',
            'type_meter_id' => 'required|min:1',
        ];
    }
}
