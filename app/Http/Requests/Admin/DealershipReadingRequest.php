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
            'billed_consumption' => str_replace(',', '.', str_replace('.', '', $this->billed_consumption)),
            'minimum_value'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->minimum_value))),
            'dealership_consumption_tax_1' => str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_1)),
            'dealership_consumption_tax_2' => str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_2)),
            'dealership_cost_tax_1' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_1))),
            'dealership_cost_tax_2' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_2))),
            'dealership_cost' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost))),
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
            'dealership_cost_tax_1' => 'required|numeric|between:0,999999999.999',
            'dealership_cost_tax_2' => 'required|numeric|between:0,999999999.999',
            'dealership_cost' => 'required|numeric|between:0,999999999.99',
            'dealership_id' => 'required|min:1',
            'complex_id' => 'required|min:1',
            'month_ref' => 'required|min:1|max:20|in:Janeiro,Fevereiro,Março,Abril,Maio,Junho,Julho,Agosto,Setembro,Outubro,Novembro,Dezembro',
            'year_ref' => 'required|min:4|max:4',
            'billed_consumption' => 'required|numeric|between:0,999999999.999',
            'consumption_calculation' => 'required|min:1|max:20|in:Consumo Real,Consumo com Mínimo,Consumo sem Mínimo',
            'type_minimum_value' => 'required|min:1|max:20|in:Da Concessionária,Pré Estabelecido',
            'minimum_value' => 'required|numeric|between:0,999999999.999',
            'fare_type'  => 'required|min:1|max:191|in:Concessionária com 2ª faixa pela Progressividade,Concessionária com 2ª faixa pela Média,Metro Cúbico Médio',
            'common_area'  => 'required|min:1|max:20|in:Sem,Simples,Fração',
        ];
    }

    public function messages()
    {
        return [
            'dealership_consumption.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_1.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_2.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_cost' => 'O campo custo da concessionária deve ser entre 0 e 999.999.999,.',
            'dealership_cost_tax_1.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_cost_tax_2.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'reading_date.date_format' => 'Formato de data inválido',
            'reading_date_next.date_format' => 'Formato de data inválido',
            'billed_consumption.between' => 'O campo consumo faturado deve ser entre 0 e 999.999.999,999.',
            'minimum_value.between' => 'O campo consumo faturado deve ser entre 0 e 999.999.999,999.',
        ];
    }
}
