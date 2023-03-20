<?php

namespace App\Imports;

use App\Models\Apartment;
use App\Models\ApartmentReport;
use App\Models\Block;
use App\Models\Complex;
use App\Models\DealershipReading;
use App\Models\Meter;
use App\Models\Reading;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApartmentReportImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $complex = null;
        $block = null;
        $apartment  = null;
        $dealershipReading = null;
        $meter_readings = [];

        $complex = Complex::where('alias_name', $row['condominio'])->first();
        if ($complex) {
            $block = Block::where('complex_id', $complex->id)->where('name', $row['bloco'])->first();
            $dealershipReading = DealershipReading::where('complex_id', $complex->id)->where('month_ref', $row['mes_ref'])->where('year_ref', $row['ano_ref'])->first();
        }
        if ($block) {
            $apartment = Apartment::where('block_id', $block->id)->where('name', $row['apartamento'])->first();
        }

        if ($apartment) {
            $meters = Meter::where('apartment_id', $apartment->id)->pluck('id');
            $readings = Reading::whereIn('meter_id', $meters)
                ->where('year_ref', $dealershipReading->month_ref)
                ->where('month_ref', $dealershipReading->year_ref)
                ->pluck('id');
            $meter_readings = $readings->toArray();
        }

        if ($apartment && $dealershipReading) {
            $old = ApartmentReport::where('apartment_id', $apartment->id)
                ->where('year_ref', $dealershipReading->year_ref)
                ->where('month_ref', $dealershipReading->month_ref)
                ->delete();

            return new ApartmentReport([
                'apartment_id' =>  $apartment ? $apartment->id : -1,
                'dealership_reading_id' =>  $dealershipReading ? $dealershipReading->id : -1,
                'month_ref' => $row['mes_ref'],
                'year_ref' => $row['ano_ref'],
                'consumed' => $row['consumo_agua_m3'] ? str_replace(',', '.', $row['consumo_agua_m3']) : 0,
                'consumed_cost' => $row['valor_consumo_agua'] ? str_replace(',', '.', $row['valor_consumo_agua']) : 0,
                'sewage_cost' => $row['valor_esgoto'] ? str_replace(',', '.', $row['valor_esgoto']) : 0,
                'partial' => $row['rateio_agua'] ? str_replace(',', '.', $row['rateio_agua']) : 0,
                'kite_car_consumed' => $row['consumo_pipa_m3'] ? str_replace(',', '.', $row['consumo_pipa_m3']) : 0,
                'kite_car_cost' => $row['custo_pipa'] ? str_replace(',', '.', $row['custo_pipa']) : 0,
                'total_consumed' => $row['consumo_total_agua_m3'] ? str_replace(',', '.', $row['consumo_total_agua_m3']) : 0,
                'total_unit' => $row['valor_total_agua_unidade'] ? str_replace(',', '.', $row['valor_total_agua_unidade']) : 0,
                'readings' => $meter_readings,
                'consumption_gas_value' => $row['consumo_gas_m3'] ? str_replace(',', '.', $row['consumo_gas_m3']) : null,
                'total_gas_value' => $row['valor_consumo_gas'] ? str_replace(',', '.', $row['valor_consumo_gas']) : null,
                'editor' => Auth::user()->id,
            ]);
        } else {
            return;
        }
    }
}
