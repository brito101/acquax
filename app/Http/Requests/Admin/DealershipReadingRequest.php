<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DealershipReadingRequest extends FormRequest
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
            'dealership_consumption_tax_1' => str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_1)),
            'dealership_consumption_tax_2' => str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_2)),
            'monthly_consumption' => str_replace(',', '.', str_replace('.', '', $this->monthly_consumption)),
            'water_value_consumption' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_1))),
            'sewage_value_consumption' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_2))),
            'regulation_tax' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->regulation_tax))),
            'dealership_cost_tax_1' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_1))),
            'dealership_cost_tax_2' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_2))),
            'reading_date' => Carbon::createFromFormat('d/m/Y', $this->reading_date)->format('Y-m-d'),
            'reading_date_next' => Carbon::createFromFormat('d/m/Y', $this->reading_date_next)->format('Y-m-d'),
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
            'reading_date' => 'required|date_format:Y-m-d',
            'reading_date_next' => 'required|date_format:Y-m-d',
            'total_days' => 'required|numeric|between:0,31',
            'dealership_consumption' => 'required|numeric|between:0,999999999.999',
            'dealership_consumption_tax_1' => 'required|numeric|between:0,999999999.999',
            'dealership_consumption_tax_2' => 'required|numeric|between:0,999999999.999',
            'monthly_consumption' => 'required|numeric|between:0,999999999.999',
            'water_value_consumption' => 'required|numeric|between:0,999999999.99',
            'sewage_value_consumption' => 'required|numeric|between:0,999999999.99',
            'regulation_tax' => 'nullable|numeric|between:0,999999999.99',
            'dealership_cost_tax_1' => 'required|numeric|between:0,999999999.999',
            'dealership_cost_tax_2' => 'required|numeric|between:0,999999999.999',
            'dealership_id' => 'required|min:1',
            'complex_id' => 'required|min:1',
            'month_ref' => 'required|min:1|max:20|in:Janeiro,Fevereiro,Março,Abril,Maio,Junho,Julho,Agosto,Setembro,Outubro,Novembro,Dezembro',
        ];
    }

    public function messages()
    {
        return [
            'dealership_consumption.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_1.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_2.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'monthly_consumption.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'water_value_consumption.between' => 'O campo leitura deve ser entre 0 e 999.999.999,99.',
            'sewage_value_consumption.between' => 'O campo leitura deve ser entre 0 e 999.999.99,999.',
            'regulation_tax.between' => 'O campo leitura deve ser entre 0 e 999.999.999,99.',
            'dealership_cost_tax_1.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_cost_tax_2.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'reading_date.date_format' => 'Formato de data inválido',
            'reading_date_next.date_format' => 'Formato de data inválido',
        ];
    }
}
