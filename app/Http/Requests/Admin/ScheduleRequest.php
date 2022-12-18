<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'title' => 'required|min:1|max:191',
            'description' => 'nullable|min:1|max:40000',
            'start' => 'required|date_format:Y-m-d\TH:i',
            'end' => 'required|date_format:Y-m-d\TH:i|after:start',
            'color' => 'nullable|in:teal,warning,primary,secondary,danger,success',
            'complex_id' => 'nullable|exists:complexes,id'
        ];
    }

    public function messages()
    {
        return [
            'start.date_format' => 'Formato de data do campo início inválido',
            'end.date_format' => 'Formato de data do campo término inválido',
            'color.in' => 'Cor inválida',
        ];
    }
}
