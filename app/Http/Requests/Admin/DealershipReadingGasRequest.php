<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DealershipReadingGasRequest extends FormRequest
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
            'dealership_consumption' => str_replace(',', '.', str_replace('.', '', $this->dealership_consumption)),
            'billed_consumption' => str_replace(',', '.', str_replace('.', '', $this->billed_consumption)),
            'dealership_cost' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost))),
            'reading_date' => Carbon::createFromFormat('d/m/Y', $this->reading_date)->format('Y-m-d'),
            'reading_date_next' => Carbon::createFromFormat('d/m/Y', $this->reading_date_next)->format('Y-m-d'),
            'monthly_consumption' => str_replace(',', '.', str_replace('.', '', $this->monthly_consumption)),
            'total_value' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_value))),
            'consumption_value' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->consumption_value))),
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
            'complex_id' => 'required|min:1|exists:complexes,id',
            'month_ref' => 'required|min:1|max:20|in:Janeiro,Fevereiro,Março,Abril,Maio,Junho,Julho,Agosto,Setembro,Outubro,Novembro,Dezembro',
            'year_ref' => 'required|min:4|max:4',
            'dealership_id' => 'required|min:1|exists:dealerships,id',
            'reading_date' => 'required|date_format:Y-m-d',
            'reading_date_next' => 'required|date_format:Y-m-d',
            'total_days' => 'required|numeric|between:0,31',
            'billed_consumption' => 'required|numeric|between:0,999999999.999',
            'dealership_consumption' => 'required|numeric|between:0,999999999.999',
            'dealership_cost' => 'required|numeric|between:0,999999999.99',
            'monthly_consumption' => 'required|numeric|between:0,999999999.999',
            'total_value' => 'nullable|numeric|between:0,999999999.99',
            'consumption_value' => 'nullable|numeric|between:0,999999999.99',
        ];
    }

    public function messages()
    {
        return [
            'dealership_consumption.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_cost' => 'O campo custo da concessionária deve ser entre 0 e 999.999.999,.',
            'reading_date.date_format' => 'Formato de data inválido',
            'reading_date_next.date_format' => 'Formato de data inválido',
            'monthly_consumption.between' => 'O campo consumo das unidades deve ser entre 0 e 999.999.999,999.',
            'total_value.between' => 'O campo conta total deve ser entre 0 e 999.999.999,99.',
            'consumption_value.between' => 'O campo conta total deve ser entre 0 e 999.999.999,99.',
        ];
    }
}
