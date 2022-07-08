<?php

namespace App\Models;

use App\Models\Settings\Dealership;
use App\Models\Views\Apartment;
use Facade\FlareClient\Api;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use stdClass;

class DealershipReading extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'reading_date',
        'reading_date_next',
        'total_days',
        'dealership_consumption',
        'dealership_consumption_tax_1',
        'dealership_consumption_tax_2',
        'dealership_cost_tax_1',
        'dealership_cost_tax_2',
        'dealership_cost',
        'dealership_id',
        'complex_id',
        'month_ref',
        'year_ref',
        'editor',
        'billed_consumption',
        'consumption_calculation',
        'type_minimum_value',
        'minimum_value',
        'fare_type',
        'common_area',
        'sewage_calc',
        /** computed data */
        'monthly_consumption',
        'diff_consumption',
        'previous_monthly_consumption',
        'previous_billed_consumption',
        'consumption_value',
        'sewage_value',
        'total_value',
        'diff_cost',
        'consumption_tax_1',
        'total_cost_tax_1',
        'consumption_tax_2',
        'total_cost_tax_2',
        'units_inside_tax_1',
        'units_above_tax_1',
    ];

    /** Relationships */

    public function complex()
    {
        return $this->belongsTo(Complex::class);
    }

    public function dealership()
    {
        return $this->belongsTo(Dealership::class);
    }

    public function apartmentReports()
    {
        return $this->hasMany(ApartmentReport::class);
    }

    /**  Accessor */
    public function getDealershipConsumptionTax1Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getDealershipCostTax1Attribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    public function getDealershipConsumptionTax2Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getDealershipCostTax2Attribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    public function getDealershipConsumptionAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getBilledConsumptionAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getMinimumValueAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    /** Real Consumed (m3) */
    public function setMonthlyConsumptionAttribute($value)
    {
        $volume_consumed = 0;
        foreach ($this->getApartmentReadings() as $reading) {
            $volume_consumed += ($this->convertToFloat($reading->volume_consumed));
        }

        $this->attributes['monthly_consumption'] = $volume_consumed;
    }

    public function getMonthlyConsumptionAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function setDiffConsumptionAttribute($value)
    {
        $total = 0;
        $volume_consumed = 0;
        foreach ($this->getApartmentReadings() as $reading) {
            $volume_consumed += ($this->convertToFloat($reading->volume_consumed));
        }

        $total = abs($volume_consumed - $this->convertToFloat($this->dealership_consumption));

        $this->attributes['diff_consumption'] = $total;
    }

    public function getDiffConsumptionAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function setPreviousBilledConsumptionAttribute($value)
    {
        $datePrevious = $this->getPreviousDateRef($this->month_ref, $this->year_ref);
        $previous = DealershipReading::where('month_ref', $datePrevious[0])
            ->where('year_ref', $datePrevious[1])
            ->where('complex_id', $this->complex_id)->first();
        if ($previous) {
            $this->attributes['previous_billed_consumption'] = $this->convertToFloat($previous->billed_consumption);
        } else {
            $this->attributes['previous_billed_consumption'] = 0;
        }
    }

    public function getPreviousBilledConsumptionAttribute($value)
    {

        return $value == 0 ? "Inexistente" : number_format($value, 3, ",", ".");
    }

    public function setPreviousMonthlyConsumptionAttribute($value)
    {
        $previous_volume_consumed = 0;
        foreach ($this->getApartmentReadings() as $reading) {
            if ($reading->previous_volume_consumed != "Inexistente") {
                $previous_volume_consumed += ($this->convertToFloat($reading->previous_volume_consumed));
            }
        }
        $this->attributes['previous_monthly_consumption'] = $previous_volume_consumed;
    }

    public function getPreviousMonthlyConsumptionAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getConsumptionValueAttribute($value)
    {
        $reports = $this->apartmentReports;
        $total = 0;
        foreach ($reports as $report) {
            $total += $this->moneyConvertToFloat($report->consumed_cost);
        }
        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getSewageValueAttribute($value)
    {
        $reports = $this->apartmentReports;
        $total = 0;
        foreach ($reports as $report) {
            $total += $this->moneyConvertToFloat($report->sewage_cost);
        }
        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getTotalValueAttribute($value)
    {
        $total =  $this->moneyConvertToFloat($this->consumption_value) + $this->moneyConvertToFloat($this->sewage_value);

        return 'R$ ' . number_format($total, 2, ',', '.');
    }

    public function getDiffCostAttribute($value)
    {
        $dealership_cost = $this->moneyConvertToFloat($this->dealership_cost);
        //AQUI
        $real_cost = ($this->moneyConvertToFloat($this->consumption_value)) + ($this->moneyConvertToFloat($this->sewage_value));


        return 'R$ ' . number_format(($dealership_cost - $real_cost), 2, ",", ".");
    }

    public function getConsumptionTax1Attribute()
    {
        $volume_consumed = 0;
        $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);

        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($value <= $tax_1) {
                $volume_consumed += $value;
            }
        }

        return number_format($volume_consumed, 3, ",", ".");
    }


    public function getTotalCostTax1Attribute()
    {
        $tax = $this->convertToFloat($this->consumption_tax_1);
        $cost = $this->moneyConvertToFloat($this->dealership_cost_tax_1);
        $total = $tax * $cost;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getConsumptionTax2Attribute()
    {
        $volume_consumed = 0;
        $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($value > $tax_1) {
                $volume_consumed += $value;
            }
        }

        return number_format($volume_consumed, 3, ",", ".");
    }

    public function getTotalCostTax2Attribute()
    {
        $tax = $this->convertToFloat($this->consumption_tax_2);
        $cost = $this->moneyConvertToFloat($this->dealership_cost_tax_2);
        $total = $tax * $cost;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function setUnitsInsideTax1Attribute($value)
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $units = 0;
        foreach ($apartments as $apartment) {
            $meters = Meter::where('apartment_id', $apartment)->pluck('id');
            $readings = Reading::whereIn('meter_id', $meters)
                ->where('year_ref', $this->year_ref)
                ->where('month_ref', $this->month_ref)->get();
            $total_consumed = 0;
            foreach ($readings as $reading) {
                $total_consumed += $this->convertToFloat($reading->volume_consumed);
            }
            if (count($readings)) {
                if ($total_consumed <= $this->convertToFloat($this->dealership_consumption_tax_1)) {
                    $units++;
                }
            }
        }

        $this->attributes['units_inside_tax_1'] = $units;
    }

    public function setUnitsAboveTax1Attribute($value)
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $units = 0;
        foreach ($apartments as $apartment) {
            $meters = Meter::where('apartment_id', $apartment)->pluck('id');
            $readings = Reading::whereIn('meter_id', $meters)
                ->where('year_ref', $this->year_ref)
                ->where('month_ref', $this->month_ref)
                ->get();
            $total_consumed = 0;
            foreach ($readings as $reading) {
                $total_consumed += $this->convertToFloat($reading->volume_consumed);
            }
            if (count($readings)) {
                if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_1)) {
                    $units++;
                }
            }
        }

        $this->attributes['units_above_tax_1'] = $units;
    }

    public function getReadingDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getReadingDateNextAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getSewageValueConsumptionAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    public function getRegulationTaxAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    public function getDealershipCostAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    /** Aux function */
    private function getApartmentReadings()
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $meters = Meter::whereIn('apartment_id', $apartments)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)
            ->where('year_ref', $this->year_ref)
            ->where('month_ref', $this->month_ref)
            ->get();
        return $readings;
    }

    public function generateApartmentReport()
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->get();
        $reports = [];

        foreach ($apartments as $apartment) {
            $result = $this->getApartmentReport($apartment);

            if ($result) {
                $report = ApartmentReport::where('dealership_reading_id', $this->id)->where('apartment_id',  $apartment->id)->first();

                $data = [
                    'consumed' => $result['volume_consumed'],
                    'consumed_cost' => $result['consumed_cost'],
                    'sewage_cost' => $result['sewage_cost'],
                    // 'total_unit' => $result['total_unit'],
                    // 'partial' => $result['partial'],
                    'dealership_reading_id' => $this->id,
                    'readings' => $result['readings'],
                    'apartment_id' => $apartment->id,
                    'month_ref' => $this->month_ref,
                    'year_ref' => $this->year_ref
                ];
                if ($report) {
                    $report->update($data);
                } else {
                    ApartmentReport::create($data);
                }
            }
        }
    }

    //** Apartments Calc Engine! */
    public function getApartmentReport($apartment)
    {
        // $diff_cost = $this->moneyConvertToFloat($this->diff_cost);
        // $units = $this->totalApartments();
        $meters = Meter::where('apartment_id', $apartment->id)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)
            ->where('year_ref', $this->year_ref)
            ->where('month_ref', $this->month_ref)
            ->get();
        if (count($readings)) {
            $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);
            $cost_1 = $this->moneyConvertToFloat($this->dealership_cost_tax_1);
            $tax_2 = $this->convertToFloat($this->dealership_consumption_tax_2);
            $cost_2 = $this->moneyConvertToFloat($this->dealership_cost_tax_2);

            $total_consumed = 0;
            $consumed_cost = 0;
            $sewage_cost = 0;
            foreach ($readings as $reading) {
                $total_consumed += $this->convertToFloat($reading->volume_consumed);
            }

            /** Calc Rules */
            /* Total Consumed */
            if ($total_consumed <= $tax_1) {
                if ($this->consumption_calculation == 'Consumo com Mínimo') {
                    $consumed_cost += $this->moneyConvertToFloat($this->minimum_value);
                } else {
                    $consumed_cost += ($total_consumed *  $cost_1);
                }
            }

            if ($total_consumed > $tax_1) {
                $consumed_cost += ($tax_1 * $cost_1 + ($total_consumed - $tax_1) * $cost_2);
            }

            switch ($this->sewage_calc) {
                case 'Igual ao consumo de água':
                    $sewage_cost = $consumed_cost;
                    break;
                case 'Metade do valor do consumo de água':
                    $sewage_cost = $consumed_cost / 2;
                    break;
                case 'Sem cobrança':
                    $sewage_cost = 0;
                    break;
                default:
                    $sewage_cost = $consumed_cost;
                    break;
            }

            // /** Common Area */
            // $common_area = 0;

            // switch ($this->common_area) {
            //     case 'Sem':
            //         $common_area = 0;
            //         break;
            //     case 'Simples':
            //         $common_area = $diff_cost / $units;
            //         break;
            //     case 'Fração':
            //         $common_area = $diff_cost * $this->convertToFloat($apartment->fraction);
            //         break;
            //     default:
            //         $common_area = 0;
            //         break;
            // }

            // $total_unit = $consumed_cost + $sewage_cost +  $common_area;

            return [
                'volume_consumed' => $total_consumed,
                'consumed_cost' => $consumed_cost,
                'sewage_cost' => $sewage_cost,
                // 'total_unit' => $total_unit,
                // 'partial' => $common_area,
                'readings' => $readings->pluck('id'),
            ];
        } else {
            return null;
        }
    }

    public function finalCalc()
    {
        $units = $this->totalApartments();
        $diff_cost = $this->moneyConvertToFloat($this->diff_cost);
        $reports = ApartmentReport::where('dealership_reading_id', $this->id)->get();

        foreach ($reports as $report) {
            /** Common Area */
            $common_area = 0;
            switch ($this->common_area) {
                case 'Sem':
                    $common_area = 0;
                    break;
                case 'Simples':
                    $common_area = $diff_cost / $units;
                    break;
                case 'Fração':
                    $common_area = $diff_cost * $this->convertToFloat($report->apartment->fraction);
                    break;
                default:
                    $common_area = 0;
                    break;
            }

            $total_unit = $this->moneyConvertToFloat($report->consumed_cost) + $this->moneyConvertToFloat($report->sewage_cost) +  $common_area;

            $report->update([
                'total_unit' => $total_unit,
                'partial' => $common_area,
            ]);
        }
    }

    private function convertToFloat($number)
    {
        return (float)str_replace(',', '.', str_replace('.', '', $number));
    }

    private function convertToMoney($number)
    {
        return 'R$ ' . number_format($number, 2, ',', '.');
    }

    private function moneyConvertToFloat($number)
    {
        return (float)str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $number)));
    }

    private function totalApartments()
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->get();
        $units = 0;
        foreach ($apartments as $apartment) {
            $meters = Meter::where('apartment_id', $apartment->id)->pluck('id');
            $readings = Reading::whereIn('meter_id', $meters)
                ->where('year_ref', $this->year_ref)
                ->where('month_ref', $this->month_ref)
                ->get();
            if (count($readings)) {
                $units++;
            }
        }

        return $units;
    }

    private function getPreviousDateRef($month, $year)
    {
        switch ($month) {
            case 'Janeiro':
                return array('Dezembro', (int)$year - 1);
                break;
            case 'Fevereiro':
                return array('Janeiro', $year);
                break;
            case 'Março':
                return array('Fevereiro', $year);
                break;
            case 'Abril':
                return array('Março', $year);
                break;
            case 'Maio':
                return array('Abril', $year);
                break;
            case 'Junho':
                return array('Maio', $year);
                break;
            case 'Julho':
                return array('Junho', $year);
                break;
            case 'Agosto':
                return array('Julho', $year);
                break;
            case 'Setembro':
                return array('Agosto', $year);
                break;
            case 'Outubro':
                return array('Setembro', $year);
                break;
            case 'Novembro':
                return array('Outubro', $year);
                break;
            case 'Dezembro':
                return array('Novembro', $year);
                break;
            default:
                return array(null, null);
        }
    }
}
