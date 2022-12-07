<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class DealershipReadingRequestV2 extends FormRequest
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
            'dealership_consumption_tax_1' => $this->consumption_ranges > 1 ? str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_1)) : 0,
            'dealership_consumption_tax_2' => $this->consumption_ranges > 2 ? str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_2)) : 0,
            'dealership_consumption_tax_3' => $this->consumption_ranges > 3 ? str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_3)) : 0,
            'dealership_consumption_tax_4' => $this->consumption_ranges > 4 ? str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_4)) : 0,
            'dealership_consumption_tax_5' => $this->consumption_ranges > 5 ? str_replace(',', '.', str_replace('.', '', $this->dealership_consumption_tax_5)) : 0,
            'dealership_cost_tax_1' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_1))),
            'dealership_cost_tax_2' => $this->consumption_ranges > 1 ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_2))) : 0,
            'dealership_cost_tax_3' => $this->consumption_ranges > 2 ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_3))) : 0,
            'dealership_cost_tax_4' => $this->consumption_ranges > 3 ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_4))) : 0,
            'dealership_cost_tax_5' => $this->consumption_ranges > 4 ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_5))) : 0,
            'dealership_cost_tax_6' => $this->consumption_ranges > 5 ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost_tax_6))) : 0,
            'dealership_cost' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->dealership_cost))),
            'reading_date' => Carbon::createFromFormat('d/m/Y', $this->reading_date)->format('Y-m-d'),
            'reading_date_next' => Carbon::createFromFormat('d/m/Y', $this->reading_date_next)->format('Y-m-d'),
            'kite_car' => $this->kite_car === 'Sim' ? true : false,
            'kite_car_qtd' => $this->kite_car_qtd ?? 0,
            'kite_car_consumption' => $this->kite_car === 'Sim' ? str_replace(',', '.', str_replace('.', '', $this->kite_car_consumption)) : 0,
            'kite_car_tax' => $this->kite_car === 'Sim' ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->kite_car_tax))) : 0,
            'value_per_kite_car' => $this->kite_car === 'Sim' ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->value_per_kite_car))) : 0,
            'kite_car_total' => $this->kite_car === 'Sim' ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->kite_car_total))) : 0,
            'monthly_consumption' => str_replace(',', '.', str_replace('.', '', $this->monthly_consumption)),
            'total_value' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_value))),
            'consumption_value' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->consumption_value))),
            'sewage_value' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->sewage_value))),
            'kite_car_consumed_units' => $this->kite_car_consumed_units ? str_replace(',', '.', str_replace('.', '', $this->kite_car_consumed_units)) : 0,
            'kite_car_cost_units' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->kite_car_cost_units))),
            'diff_cost' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->diff_cost))),
            'diff_consumption' => $this->diff_consumption ? str_replace(',', '.', str_replace('.', '', $this->diff_consumption)) : 0,
            'previous_billed_consumption' => $this->previous_billed_consumption && $this->previous_billed_consumption != 'Inexistente' ? str_replace(',', '.', str_replace('.', '', $this->previous_billed_consumption)) : 0,
            'previous_monthly_consumption' => $this->previous_monthly_consumption && $this->previous_monthly_consumption != 'Inexistente' ? str_replace(',', '.', str_replace('.', '', $this->previous_monthly_consumption)) : 0,
            'consumption_tax_1' => $this->consumption_tax_1  ? str_replace(',', '.', str_replace('.', '', $this->consumption_tax_1)) : 0,
            'consumption_tax_2' => $this->consumption_tax_2 && $this->consumption_ranges > 1  ? str_replace(',', '.', str_replace('.', '', $this->consumption_tax_2)) : 0,
            'consumption_tax_3' => $this->consumption_tax_3 && $this->consumption_ranges > 2  ? str_replace(',', '.', str_replace('.', '', $this->consumption_tax_3)) : 0,
            'consumption_tax_4' => $this->consumption_tax_4 && $this->consumption_ranges > 3  ? str_replace(',', '.', str_replace('.', '', $this->consumption_tax_4)) : 0,
            'consumption_tax_5' => $this->consumption_tax_5 && $this->consumption_ranges > 4  ? str_replace(',', '.', str_replace('.', '', $this->consumption_tax_5)) : 0,
            'consumption_tax_6' => $this->consumption_tax_6 && $this->consumption_ranges > 5  ? str_replace(',', '.', str_replace('.', '', $this->consumption_tax_6)) : 0,
            'units_inside_tax_2' => $this->units_inside_tax_2 && $this->consumption_ranges > 1  ? $this->units_inside_tax_2 : 0,
            'units_inside_tax_3' => $this->units_inside_tax_3 && $this->consumption_ranges > 2  ? $this->units_inside_tax_3 : 0,
            'units_inside_tax_4' => $this->units_inside_tax_4 && $this->consumption_ranges > 3  ? $this->units_inside_tax_4 : 0,
            'units_inside_tax_5' => $this->units_inside_tax_5 && $this->consumption_ranges > 4  ? $this->units_inside_tax_5 : 0,
            'units_inside_tax_6' => $this->units_inside_tax_6 && $this->consumption_ranges > 5  ? $this->units_inside_tax_6 : 0,
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
            'dealership_consumption_tax_1' => 'nullable|numeric|between:0,999999999.999',
            'dealership_consumption_tax_2' => 'nullable|numeric|between:0,999999999.999',
            'dealership_consumption_tax_3' => 'nullable|numeric|between:0,999999999.999',
            'dealership_consumption_tax_4' => 'nullable|numeric|between:0,999999999.999',
            'dealership_consumption_tax_5' => 'nullable|numeric|between:0,999999999.999',
            'dealership_cost_tax_1' => 'required|numeric|between:0,999999999.999',
            'dealership_cost_tax_2' => 'nullable|numeric|between:0,999999999.999',
            'dealership_cost_tax_3' => 'nullable|numeric|between:0,999999999.999',
            'dealership_cost_tax_4' => 'nullable|numeric|between:0,999999999.999',
            'dealership_cost_tax_5' => 'nullable|numeric|between:0,999999999.999',
            'dealership_cost_tax_6' => 'nullable|numeric|between:0,999999999.999',
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
            'sewage_calc' => 'nullable|in:Igual ao consumo de água,Metade do valor do consumo de água,Sem cobrança|max:191',
            'kite_car' => 'nullable|boolean',
            'kite_car_consumption' => 'nullable|numeric|between:0,999999999.999',
            'kite_car_qtd' => 'nullable|integer|min:0|max:9999',
            'value_per_kite_car' => 'nullable|numeric|between:0,999999999.999',
            'kite_car_total' => 'nullable|numeric|between:0,999999999.999',
            'consumption_ranges' => 'required|integer|min:1|max:6',
            'monthly_consumption' => 'required|numeric|between:0,999999999.999',
            'total_value' => 'nullable|numeric|between:0,999999999.99',
            'consumption_value' => 'nullable|numeric|between:0,999999999.99',
            'sewage_value' => 'nullable|numeric|between:0,999999999.99',
            'kite_car_consumed_units' => 'nullable|numeric|between:0,999999999.99',
            'kite_car_cost_units' => 'nullable|numeric|between:0,999999999.99',
            'diff_cost' => 'nullable|numeric|between:0,999999999.99',
            'diff_consumption' => 'nullable|numeric|between:0,999999999.999',
            'previous_billed_consumption' => 'nullable|numeric|between:0,999999999.999',
            'previous_monthly_consumption' => 'nullable|numeric|between:0,999999999.999',
            'consumption_tax_1' => 'nullable|numeric|between:0,999999999.999',
            'consumption_tax_2' => 'nullable|numeric|between:0,999999999.999',
            'consumption_tax_3' => 'nullable|numeric|between:0,999999999.999',
            'consumption_tax_4' => 'nullable|numeric|between:0,999999999.999',
            'consumption_tax_5' => 'nullable|numeric|between:0,999999999.999',
            'consumption_tax_6' => 'nullable|numeric|between:0,999999999.999',
            'units_inside_tax_1' => 'nullable|integer',
            'units_inside_tax_2' => 'nullable|integer',
            'units_inside_tax_3' => 'nullable|integer',
            'units_inside_tax_4' => 'nullable|integer',
            'units_inside_tax_5' => 'nullable|integer',
            'units_inside_tax_6' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'dealership_consumption.between' => 'O campo leitura deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_1.between' => 'O campo da 2ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_2.between' => 'O campo 3ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_3.between' => 'O campo 4ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_4.between' => 'O campo 5ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_consumption_tax_5.between' => 'O campo 6ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_cost' => 'O campo custo da concessionária deve ser entre 0 e 999.999.999,.',
            'dealership_cost_tax_1.between' => 'O campo custo da 1ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_cost_tax_2.between' => 'O campo custo da 2ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_cost_tax_3.between' => 'O campo custo da 3ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_cost_tax_4.between' => 'O campo custo da 4ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_cost_tax_5.between' => 'O campo custo da 5ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'dealership_cost_tax_6.between' => 'O campo custo da 6ª faixa de consumo deve ser entre 0 e 999.999.999,999.',
            'reading_date.date_format' => 'Formato de data inválido',
            'reading_date_next.date_format' => 'Formato de data inválido',
            'billed_consumption.between' => 'O campo consumo faturado deve ser entre 0 e 999.999.999,999.',
            'minimum_value.between' => 'O campo valor mínimo deve ser entre 0 e 999.999.999,999.',
            'kite_car_consumption.between' => 'O campo m3 do carro pipa deve ser entre 0 e 999.999.999,999.',
            'kite_car_tax.between' => 'O campo valor do m3 do carro pipa deve ser entre 0 e 999.999.999,999.',
            'value_per_kite_car.between' => 'O campo valor por caminhão pipa deve ser entre 0 e 999.999.999,999.',
            'kite_car_total.between' => 'O campo valor total do carro pipa deve ser entre 0 e 999.999.999,999.',
            'monthly_consumption.between' => 'O campo consumo das unidades deve ser entre 0 e 999.999.999,999.',
            'total_value.between' => 'O campo conta total deve ser entre 0 e 999.999.999,99.',
            'consumption_value.between' => 'O campo conta total deve ser entre 0 e 999.999.999,99.',
            'sewage_value.between' => 'O campo conta total deve ser entre 0 e 999.999.999,99.',
            'kite_car_consumed_units.between' => 'O campo consumo do carro pipa das unidades deve ser entre 0 e 999.999.999,99.',
            'kite_car_cost_units.between' => 'O campo valor do carro pipa das unidades deve ser entre 0 e 999.999.999,99.',
            'diff_cost.between' => 'O campo área comum deve ser entre 0 e 999.999.999,99.',
            'diff_consumption.between' => 'O campo diferença entre real e concessionária deve ser entre 0 e 999.999.999,99.',
            'previous_billed_consumption.between' => 'O campo consumo faturado mês anterior deve ser entre 0 e 999.999.999,99.',
            'previous_monthly_consumption.between' => 'O campo consumo real mês anterior deve ser entre 0 e 999.999.999,99.',
            'consumption_tax_1.between' => 'O campo consumo na 1ª faixa deve ser entre 0 e 999.999.999,99.',
            'consumption_tax_2.between' => 'O campo consumo na 2ª faixa deve ser entre 0 e 999.999.999,99.',
            'consumption_tax_3.between' => 'O campo consumo na 3ª faixa deve ser entre 0 e 999.999.999,99.',
            'consumption_tax_4.between' => 'O campo consumo na 4ª faixa deve ser entre 0 e 999.999.999,99.',
            'consumption_tax_5.between' => 'O campo consumo na 5ª faixa deve ser entre 0 e 999.999.999,99.',
            'consumption_tax_6.between' => 'O campo consumo na 6ª faixa deve ser entre 0 e 999.999.999,99.',
        ];
    }
}
