<?php

namespace App\Http\Requests\Admin;

use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\DealershipReading;
use Illuminate\Foundation\Http\FormRequest;

class ApartmentReportRequest extends FormRequest
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

        $apartment  = null;
        $dealershipReading = DealershipReading::find($this->dealership_reading_id);
        if ($dealershipReading) {
            $complex = Complex::find($dealershipReading->complex_id);
        }
        if ($complex) {
            $block = Block::where('name', $this->block)->where('complex_id', $complex->id)->first();
        }
        if ($block) {
            $apartment = Apartment::where('name', $this->apartment)->where('block_id', $block->id)->first();
        }
        $this->merge([
            'consumed' => str_replace(',', '.', str_replace('.', '', $this->consumed)),
            'consumed_cost'  => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->consumed_cost))),
            'sewage_cost'  => $this->sewage_cost ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->sewage_cost))) : 0,
            'partial'  => $this->partial ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->partial))) : 0,
            'kite_car_consumed' => $this->kite_car_consumed ? str_replace(',', '.', str_replace('.', '', $this->kite_car_consumed)) : 0,
            'kite_car_cost' => $this->kite_car_cost ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->kite_car_cost))) : 0,
            'total_consumed' => str_replace(',', '.', str_replace('.', '', $this->total_consumed)),
            'total_unit' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_unit))),
            'block_id' =>  $block ? $block->id : -1,
            'apartment_id' =>  $apartment ? $apartment->id : -1,
            'consumption_gas_value' => $this->consumption_gas_value ? str_replace(',', '.', str_replace('.', '', $this->consumption_gas_value)) : null,
            'total_gas_value' => $this->total_gas_value ? str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $this->total_gas_value))) : null,
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
            'apartment_id' =>  'required|exists:apartments,id',
            'block_id' =>  'required|exists:blocks,id',
            'dealership_reading_id' => 'required|exists:dealership_readings,id',
            'consumed' => 'required|numeric|between:0,999999999.999',
            'consumed_cost' => 'required|numeric|between:0,999999999.999',
            'sewage_cost' => 'nullable|numeric|between:0,999999999.999',
            'partial' => 'nullable|numeric|between:0,999999999.999',
            'kite_car_consumed' => 'nullable|numeric|between:0,999999999.999',
            'kite_car_cost' => 'nullable|numeric|between:0,999999999.999',
            'total_consumed' => 'required|numeric|between:0,999999999.999',
            'total_unit' => 'required|numeric|between:0,999999999.999',
            'consumption_gas_value' => 'nullable|numeric|between:0,999999999.999',
            'total_gas_value' => 'nullable|numeric|between:0,999999999.999',
        ];
    }

    public function messages()
    {
        return [
            'block_id.exists' => 'O bloco informado não existe',
            'apartment_id.exists' => 'O apartamento informado não existe',
            'consumed.between' => 'O campo consumo ser entre 0 e 999.999.999,999.',
            'consumed_cost.between' => 'O campo custo de consumo deve ser entre 0 e 999.999.999,.',
            'sewage_cost.between' => 'O campo custo de esgoto deve ser entre 0 e 999.999.999,.',
            'partial.between' => 'O campo área como deve ser entre 0 e 999.999.999,.',
            'kite_car_consumed.between' => 'O campo consumo de carro pipa deve ser entre 0 e 999.999.999,999.',
            'kite_car_cost.between' => 'O campo custo do carro pipa deve ser entre 0 e 999.999.999,.',
            'total_consumed.between' => 'O campo total consumido deve ser entre 0 e 999.999.999,999.',
            'total_unit' => 'O campo total da unidade deve ser entre 0 e 999.999.999,.',
            'consumption_gas_value.between' => 'O campo consumo de gás deve ser entre 0 e 999.999.999,.',
            'total_gas_value.between' => 'O campo valor do consumo de gás deve ser entre 0 e 999.999.999,999.',
        ];
    }
}
