<?php

namespace App\Models;

use App\Models\Settings\Dealership;
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
    ];

    protected $appends = [
        'units_inside_tax_1',
        'units_above_tax_1',
        'fraction',
        'apartments_report'
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

    public function setConsumptionValueAttribute($value)
    {
        $complex = $this->complex;
        $blocks = Block::where('complex_id', $this->complex->id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);
        $tax_2 = $this->convertToFloat($this->dealership_consumption_tax_2);
        $cost_tax_1 = $this->moneyConvertToFloat($this->dealership_cost_tax_1);
        $cost_tax_2 = $this->moneyConvertToFloat($this->dealership_cost_tax_2);
        $total_consumed = 0;

        foreach ($apartments as $apartment) {
            $meters = Meter::where('apartment_id', $apartment)->pluck('id');
            $readings = Reading::whereIn('meter_id', $meters)
                ->where('year_ref', $this->year_ref)
                ->where('month_ref', $this->month_ref)->get();

            foreach ($readings as $reading) {
                $volume_consumed = $reading->volume_consumed;
                if ($volume_consumed > 0  && $volume_consumed <= $tax_1) {
                    if ($this->consumption_calculation == 'Consumo com Mínimo') {
                        $total_consumed += $this->moneyConvertToFloat($this->minimum_value);
                    } else {
                        $total_consumed += ($this->convertToFloat($reading->volume_consumed) *  $cost_tax_1);
                    }
                }

                if ($volume_consumed > $tax_1) {
                    $total_consumed += ($tax_1 * $cost_tax_1 + ($this->convertToFloat($reading->volume_consumed) - $tax_1) * $cost_tax_2);
                }
            }
        }

        $this->attributes['consumption_value'] = $total_consumed;
    }

    public function getConsumptionValueAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    public function setSewageValueAttribute($value)
    {
        $this->attributes['sewage_value'] = $this->moneyConvertToFloat($this->consumption_value);
    }

    public function getSewageValueAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    public function setTotalValueAttribute($value)
    {
        $this->attributes['total_value'] =  ($this->moneyConvertToFloat($this->consumption_value) * 2);
    }

    public function getTotalValueAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }

    public function setDiffCostAttribute($value)
    {
        $real_cost = ($this->moneyConvertToFloat($this->consumption_value)) * 2;
        $dealership_cost = $this->moneyConvertToFloat($this->dealership_cost);

        $this->attributes['diff_cost'] = $dealership_cost - $real_cost;
    }

    public function getDiffCostAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
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

    public function getUnitsInsideTax1Attribute()
    {
        $complex = $this->complex;
        $blocks = Block::where('complex_id', $this->complex->id)->pluck('id');
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

        return $units;
    }

    public function getUnitsAboveTax1Attribute()
    {
        $complex = $this->complex;
        $blocks = Block::where('complex_id', $this->complex->id)->pluck('id');
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

        return $units;
    }

    //** Apartments Calc Engine! */
    public function getApartmentsReportAttribute()
    {
        $complex = $this->complex;
        $blocks = Block::where('complex_id', $this->complex->id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->get();
        $units = $this->totalApartments();
        $reports = [];
        $diff_cost = $this->moneyConvertToFloat($this->diff_cost);

        foreach ($apartments as $apartment) {
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
                $total_cost = 0;
                foreach ($readings as $reading) {
                    $total_consumed += $this->convertToFloat($reading->volume_consumed);
                }

                /** Calc Rules */
                /* Total Consumed */
                if ($total_consumed <= $tax_1) {
                    if ($this->consumption_calculation == 'Consumo com Mínimo') {
                        $total_cost += $this->moneyConvertToFloat($this->minimum_value) * 2;
                    } else {
                        $total_cost += ($total_consumed *  $cost_1) * 2;
                    }
                }

                if ($total_consumed > $tax_1) {
                    $total_cost += ($tax_1 * $cost_1 + ($total_consumed - $tax_1) * $cost_2) * 2;
                }

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
                        $common_area = $diff_cost * $this->convertToFloat($apartment->fraction);
                        break;
                }

                $total_unit = $total_cost +  $common_area;
                $reports[] = $apartment
                    ->setAttribute('total', $this->convertToMoney($total_cost))
                    ->setAttribute('consumed', number_format($this->convertToFloat($reading->volume_consumed), 3, ',', '.'))
                    ->setAttribute('common_area', $this->convertToMoney($common_area))
                    ->setAttribute('total_unit', $this->convertToMoney($total_unit));
            }
        }

        return $reports;
    }

    public function getReadingDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getReadingDateNextAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getWaterValueConsumptionAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
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
        $complex = $this->complex;
        $blocks = Block::where('complex_id', $this->complex->id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $meters = Meter::whereIn('apartment_id', $apartments)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)
            ->where('year_ref', $this->year_ref)
            ->where('month_ref', $this->month_ref)
            ->get();
        return $readings;
    }

    public function getApartmentReport(Apartment $apartment)
    {
        $complex = $this->complex;
        $units = $this->totalApartments();
        $reports = [];
        $diff_cost = $this->moneyConvertToFloat($this->diff_cost);

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
            $total_cost = 0;
            foreach ($readings as $reading) {
                $total_consumed += $this->convertToFloat($reading->volume_consumed);
            }

            if ($total_consumed <= $tax_1) {
                if ($this->consumption_calculation == 'Consumo com Mínimo') {
                    $total_cost += $this->moneyConvertToFloat($this->minimum_value) * 2;
                } else {
                    $total_cost += ($total_consumed *  $cost_1) * 2;
                }
            }

            if ($total_consumed > $tax_1) {
                $total_cost += ($tax_1 * $cost_1 + ($total_consumed - $tax_1) * $cost_2) * 2;
            }

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
                    $common_area = $diff_cost * $this->convertToFloat($apartment->fraction);
                    break;
            }

            $total_unit = $total_cost +  $common_area;

            $reports = array(
                'total' => $this->convertToMoney($total_cost),
                'partial' => $this->convertToMoney($common_area),
                'total_unit' => $this->convertToMoney($total_unit),
                'apartment' => $apartment->id,
                'totalConsumed' => $total_consumed,
                'readings' => $readings
            );
        } else {
            $reports = null;
        }

        return $reports;
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
        $complex = $this->complex;
        $blocks = Block::where('complex_id', $this->complex->id)->pluck('id');
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
