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

    protected function prepareForValidation()
    {
        $this->merge([
            'initial_reading' => str_replace(',', '.', str_replace('.', '', $this->initial_reading)),
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
            'register' => "required|min:1|max:191|unique:meters,register,{$this->id},id,deleted_at,NULL",
            'status' => 'nullable|min:3|max:20',
            'apartment_id' => 'required|min:1|',
            'type_meter_id' => 'required|min:1',
            'location' => 'nullable|max:191',
            'initial_reading' => 'nullable|numeric|between:0,999999999.9999999999999',
        ];
    }

    public function messages()
    {
        return [
            'initial_reading.between' => 'O campo leitura inicial deve ser entre 0 e 999.999.999,9999999999999.'
        ];
    }
}
