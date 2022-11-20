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

class DealershipReadingV1 extends Model
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
        'dealership_consumption_tax_3',
        'dealership_consumption_tax_4',
        'dealership_consumption_tax_5',
        'dealership_cost_tax_1',
        'dealership_cost_tax_2',
        'dealership_cost_tax_3',
        'dealership_cost_tax_4',
        'dealership_cost_tax_5',
        'dealership_cost_tax_6',
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
        'consumption_ranges',
        'consumption_tax_1',
        'consumption_tax_2',
        'consumption_tax_3',
        'consumption_tax_4',
        'consumption_tax_5',
        'consumption_tax_6',
        'units_inside_tax_1',
        'units_inside_tax_2',
        'units_inside_tax_3',
        'units_inside_tax_4',
        'units_inside_tax_5',
        'units_inside_tax_6',
        /** Kite Car Calc*/
        'kite_car',
        'kite_car_consumption',
        'kite_car_tax',
        'kite_car_total',
        'kite_car_qtd',
        'value_per_kite_car',
        'kite_car_consumed_units',
        'kite_car_cost_units',
        'average',
    ];

    protected $appends = [
        'total_cost_tax_1',
        'total_cost_tax_2',
        'total_cost_tax_3',
        'total_cost_tax_4',
        'total_cost_tax_5',
        'total_cost_tax_6',
    ];

    /**
     * Relationships
     * */
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

    /**
     * Kite Car
     * */
    // Accessors
    public function getKiteCarAttribute($value)
    {
        return $value == true ? 'Sim' : 'Não';
    }

    public function getKiteCarConsumptionAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getKiteCarTaxAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getKiteCarTotalAttribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    public function getValuePerKiteCarAttribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    // Mutators
    public function setKiteCarTotalAttribute($value)
    {
        $tax = $this->moneyConvertToFloat($this->kite_car_tax);
        $volume = $this->convertToFloat($this->kite_car_consumption);
        $this->attributes['kite_car_total'] = $tax * $volume;
    }

    public function setValuePerKiteCarAttribute($value)
    {
        $value = $this->moneyConvertToFloat($this->kite_car_total);
        $this->attributes['value_per_kite_car'] = $this->kite_car_qtd > 0 ? $value / $this->kite_car_qtd : 0;
    }

    /**
     * Dealership
     */
    // Accessors
    public function getDealershipConsumptionTax1Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getDealershipConsumptionTax2Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getDealershipConsumptionTax3Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getDealershipConsumptionTax4Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getDealershipConsumptionTax5Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getDealershipCostTax1Attribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    public function getDealershipCostTax2Attribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    public function getDealershipCostTax3Attribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    public function getDealershipCostTax4Attribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    public function getDealershipCostTax5Attribute($value)
    {
        return 'R$ ' . number_format($value, 3, ",", ".");
    }

    public function getDealershipCostTax6Attribute($value)
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

    public function getMonthlyConsumptionAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getDiffConsumptionAttribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getPreviousBilledConsumptionAttribute($value)
    {
        return $value == 0 ? "Inexistente" : number_format($value, 3, ",", ".");
    }

    public function getPreviousMonthlyConsumptionAttribute($value)
    {
        return $value == 0 ? "Inexistente" : number_format($value, 3, ",", ".");
    }

    public function getConsumptionValueAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    public function getSewageValueAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    public function getTotalValueAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }

    public function getDiffCostAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    public function getConsumptionTax1Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getConsumptionTax2Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getConsumptionTax3Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getConsumptionTax4Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getConsumptionTax5Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getConsumptionTax6Attribute($value)
    {
        return number_format($value, 3, ",", ".");
    }

    public function getTotalCostTax1Attribute()
    {
        $tax = $this->convertToFloat($this->consumption_tax_1);
        $cost = $this->moneyConvertToFloat($this->dealership_cost_tax_1);
        $total = $tax * $cost;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getTotalCostTax2Attribute()
    {
        $tax = $this->convertToFloat($this->consumption_tax_2);
        $cost = $this->moneyConvertToFloat($this->dealership_cost_tax_2);
        $total = $tax * $cost;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getTotalCostTax3Attribute()
    {
        $tax = $this->convertToFloat($this->consumption_tax_3);
        $cost = $this->moneyConvertToFloat($this->dealership_cost_tax_3);
        $total = $tax * $cost;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getTotalCostTax4Attribute()
    {
        $tax = $this->convertToFloat($this->consumption_tax_4);
        $cost = $this->moneyConvertToFloat($this->dealership_cost_tax_4);
        $total = $tax * $cost;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getTotalCostTax5Attribute()
    {
        $tax = $this->convertToFloat($this->consumption_tax_5);
        $cost = $this->moneyConvertToFloat($this->dealership_cost_tax_5);
        $total = $tax * $cost;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getTotalCostTax6Attribute()
    {
        $tax = $this->convertToFloat($this->consumption_tax_6);
        $cost = $this->moneyConvertToFloat($this->dealership_cost_tax_6);
        $total = $tax * $cost;

        return 'R$ ' . number_format($total, 2, ",", ".");
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

    public function getKiteCarConsumedUnitsAttribute($value)
    {
        return number_format($value, 2, ",", ".");
    }

    public function getKiteCarCostUnitsAttribute($value)
    {
        return 'R$ ' . number_format($value, 2, ",", ".");
    }

    //Mutators
    /** Real Consumed (m3) */
    public function setMonthlyConsumptionAttribute($value)
    {
        $volume_consumed = 0;
        foreach ($this->getApartmentReadings() as $reading) {
            $volume_consumed += ($this->convertToFloat($reading->volume_consumed));
        }

        $this->attributes['monthly_consumption'] = $volume_consumed;
    }

    public function setTotalValueAttribute($value)
    {
        $total =  $this->moneyConvertToFloat($this->dealership_cost) + $this->moneyConvertToFloat($this->kite_car_total);

        $this->attributes['total_value'] = $total;
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

    public function setPreviousMonthlyConsumptionAttribute($value)
    {
        $datePrevious = $this->getPreviousDateRef($this->month_ref, $this->year_ref);
        $previous = DealershipReading::where('month_ref', $datePrevious[0])
            ->where('year_ref', $datePrevious[1])
            ->where('complex_id', $this->complex_id)->first();
        if ($previous) {
            $this->attributes['previous_monthly_consumption'] = $this->convertToFloat($previous->monthly_consumption);
        } else {
            $this->attributes['previous_monthly_consumption'] = 0;
        }
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
                $total_consumed  = $this->kiteCarCalc($total_consumed);
                if ($this->consumption_ranges == 1) {
                    $units++;
                }
                if ($this->consumption_ranges > 1) {
                    if ($total_consumed <= $this->convertToFloat($this->dealership_consumption_tax_1)) {
                        $units++;
                    }
                }
            }
        }
        $this->attributes['units_inside_tax_1'] = $units;
    }

    public function setUnitsInsideTax2Attribute($value)
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $units = 0;
        if ($this->consumption_ranges > 1) {
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
                    $total_consumed  = $this->kiteCarCalc($total_consumed);
                    if ($this->consumption_ranges == 2) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_1)) {
                            $units++;
                        }
                    }
                    if ($this->consumption_ranges > 2) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_1) && $total_consumed <= $this->convertToFloat($this->dealership_consumption_tax_2)) {
                            $units++;
                        }
                    }
                }
            }
        }

        $this->attributes['units_inside_tax_2'] = $units;
    }

    public function setUnitsInsideTax3Attribute($value)
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $units = 0;
        if ($this->consumption_ranges > 2) {
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
                    $total_consumed  = $this->kiteCarCalc($total_consumed);
                    if ($this->consumption_ranges == 3) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_2)) {
                            $units++;
                        }
                    }
                    if ($this->consumption_ranges > 3) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_2) && $total_consumed <= $this->convertToFloat($this->dealership_consumption_tax_3)) {
                            $units++;
                        }
                    }
                }
            }
        }

        $this->attributes['units_inside_tax_3'] = $units;
    }

    public function setUnitsInsideTax4Attribute($value)
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $units = 0;
        if ($this->consumption_ranges > 3) {
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
                    $total_consumed  = $this->kiteCarCalc($total_consumed);
                    if ($this->consumption_ranges == 4) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_3)) {
                            $units++;
                        }
                    }
                    if ($this->consumption_ranges > 4) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_3) && $total_consumed <= $this->convertToFloat($this->dealership_consumption_tax_4)) {
                            $units++;
                        }
                    }
                }
            }
        }

        $this->attributes['units_inside_tax_4'] = $units;
    }

    public function setUnitsInsideTax5Attribute($value)
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $units = 0;
        if ($this->consumption_ranges > 4) {
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
                    $total_consumed  = $this->kiteCarCalc($total_consumed);
                    if ($this->consumption_ranges == 5) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_4)) {
                            $units++;
                        }
                    }
                    if ($this->consumption_ranges > 5) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_4) && $total_consumed <= $this->convertToFloat($this->dealership_consumption_tax_5)) {
                            $units++;
                        }
                    }
                }
            }
        }

        $this->attributes['units_inside_tax_5'] = $units;
    }

    public function setUnitsInsideTax6Attribute($value)
    {
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $units = 0;
        if ($this->consumption_ranges > 5) {
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
                    $total_consumed  = $this->kiteCarCalc($total_consumed);
                    if ($this->consumption_ranges == 6) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_5)) {
                            $units++;
                        }
                    }
                    if ($this->consumption_ranges > 6) {
                        if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_5) && $total_consumed <= $this->convertToFloat($this->dealership_consumption_tax_6)) {
                            $units++;
                        }
                    }
                }
            }
        }

        $this->attributes['units_inside_tax_6'] = $units;
    }

    public function setConsumptionTax1Attribute($value)
    {
        $volume_consumed = 0;
        $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);

        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            $value = $this->kiteCarCalc($value);
            if ($value <= $tax_1) {
                $volume_consumed += $value;
            }
        }

        $this->attributes['consumption_tax_1'] =  $volume_consumed;
    }

    public function setConsumptionTax2Attribute($value)
    {
        $volume_consumed = 0;
        $tax = $this->convertToFloat($this->dealership_consumption_tax_1);
        $limit = $this->convertToFloat($this->dealership_consumption_tax_2);
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($this->consumption_ranges == 2) {
                if ($value > $tax) {
                    $volume_consumed += $value;
                }
            } else {
                if ($value > $tax && $value <= $limit) {
                    $volume_consumed += $value;
                }
            }
        }

        $this->attributes['consumption_tax_2'] =  $volume_consumed;
    }

    public function setConsumptionTax3Attribute($value)
    {
        $volume_consumed = 0;
        $tax = $this->convertToFloat($this->dealership_consumption_tax_2);
        $limit = $this->convertToFloat($this->dealership_consumption_tax_3);
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($this->consumption_ranges == 3) {
                if ($value > $tax) {
                    $volume_consumed += $value;
                }
            } else {
                if ($value > $tax && $value <= $limit) {
                    $volume_consumed += $value;
                }
            }
        }

        $this->attributes['consumption_tax_3'] =  $volume_consumed;
    }

    public function setConsumptionTax4Attribute($value)
    {
        $volume_consumed = 0;
        $tax = $this->convertToFloat($this->dealership_consumption_tax_3);
        $limit = $this->convertToFloat($this->dealership_consumption_tax_4);
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($this->consumption_ranges == 4) {
                if ($value > $tax) {
                    $volume_consumed += $value;
                }
            } else {
                if ($value > $tax && $value <= $limit) {
                    $volume_consumed += $value;
                }
            }
        }

        $this->attributes['consumption_tax_4'] =  $volume_consumed;
    }

    public function setConsumptionTax5Attribute($value)
    {
        $volume_consumed = 0;
        $tax = $this->convertToFloat($this->dealership_consumption_tax_4);
        $limit = $this->convertToFloat($this->dealership_consumption_tax_5);
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($this->consumption_ranges == 5) {
                if ($value > $tax) {
                    $volume_consumed += $value;
                }
            } else {
                if ($value > $tax && $value <= $limit) {
                    $volume_consumed += $value;
                }
            }
        }

        $this->attributes['consumption_tax_5'] =  $volume_consumed;
    }

    public function setConsumptionTax6Attribute($value)
    {
        $volume_consumed = 0;
        $tax = $this->convertToFloat($this->dealership_consumption_tax_5);
        $limit = $this->convertToFloat($this->dealership_consumption_tax_6);
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($this->consumption_ranges == 6) {
                if ($value > $tax) {
                    $volume_consumed += $value;
                }
            } else {
                if ($value > $tax && $value <= $limit) {
                    $volume_consumed += $value;
                }
            }
        }

        $this->attributes['consumption_tax_6'] =  $volume_consumed;
    }

    public function setAverageAttribute($value)
    {
        $total = 0;
        $units = $this->totalApartments();
        if ($units > 0) {
            $total = $this->convertToFloat($this->monthly_consumption) / $units;
        }

        $this->attributes['average'] = $total;
    }

    /**
     * Aux function
     * */
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

    public function calcTotalConsumed()
    {
        $reports = $this->apartmentReports;
        $water = 0;
        $sewage = 0;
        $kite_car_consumed_units = 0;
        $kite_car_cost_units = 0;
        $diff_cost = 0;

        foreach ($reports as $report) {
            $water += $this->moneyConvertToFloat($report->consumed_cost);
            $sewage += $this->moneyConvertToFloat($report->sewage_cost);
            $kite_car_consumed_units += $this->convertToFloat($report->kite_car_consumed);
            $kite_car_cost_units += $this->moneyConvertToFloat($report->kite_car_cost);
        };

        $diff_cost = $this->moneyConvertToFloat($this->total_value) - ($water + $sewage + $kite_car_cost_units);

        return array(
            'water' => $water,
            'sewage' => $sewage,
            'kite_car_consumed_units' => $kite_car_consumed_units,
            'kite_car_cost_units' => $kite_car_cost_units,
            'diff_cost' => $diff_cost,
        );
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
                    'dealership_reading_id' => $this->id,
                    'readings' => $result['readings'],
                    'apartment_id' => $apartment->id,
                    'month_ref' => $this->month_ref,
                    'year_ref' => $this->year_ref,
                    /** Kite Car */
                    'kite_car_consumed' => $result['kite_car_consumed'],
                    'kite_car_cost' => $result['kite_car_cost'],
                    'total_consumed' => $result['total_consumed']
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
        $meters = Meter::where('apartment_id', $apartment->id)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)
            ->where('year_ref', $this->year_ref)
            ->where('month_ref', $this->month_ref)
            ->get();
        if (count($readings)) {
            $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);
            $tax_2 = $this->convertToFloat($this->dealership_consumption_tax_2);
            $tax_3 = $this->convertToFloat($this->dealership_consumption_tax_3);
            $tax_4 = $this->convertToFloat($this->dealership_consumption_tax_4);
            $tax_5 = $this->convertToFloat($this->dealership_consumption_tax_5);
            $cost_1 = $this->moneyConvertToFloat($this->dealership_cost_tax_1);
            $cost_2 = $this->moneyConvertToFloat($this->dealership_cost_tax_2);
            $cost_3 = $this->moneyConvertToFloat($this->dealership_cost_tax_3);
            $cost_4 = $this->moneyConvertToFloat($this->dealership_cost_tax_4);
            $cost_5 = $this->moneyConvertToFloat($this->dealership_cost_tax_5);
            $cost_6 = $this->moneyConvertToFloat($this->dealership_cost_tax_6);

            $total_consumed = 0;
            $consumed_cost = 0;
            $sewage_cost = 0;
            $kite_car_consumed = 0;
            $dealership_consumption = 0;
            foreach ($readings as $reading) {
                $dealership_consumption += $this->convertToFloat($reading->volume_consumed);
            }

            /** Kite Car Calc */
            $total_consumed  = $this->kiteCarCalc($dealership_consumption);
            $kite_car_consumed = $dealership_consumption - $total_consumed;
            $kite_car_cost = $kite_car_consumed * $this->moneyConvertToFloat($this->kite_car_tax);

            /** Calc Rules */
            /* Dealership Consumed */
            switch ($this->consumption_ranges) {
                case 1:
                    if ($this->consumption_calculation == 'Consumo com Mínimo') {
                        $consumed_cost += $this->moneyConvertToFloat($this->minimum_value);
                    } else {
                        $consumed_cost += ($total_consumed *  $cost_1);
                    }
                    break;
                case 2:
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
                    break;
                case 3:
                    if ($total_consumed <= $tax_1) {
                        if ($this->consumption_calculation == 'Consumo com Mínimo') {
                            $consumed_cost += $this->moneyConvertToFloat($this->minimum_value);
                        } else {
                            $consumed_cost += ($total_consumed *  $cost_1);
                        }
                    }

                    if ($total_consumed > $tax_1 && $total_consumed <= $tax_2) {
                        $consumed_cost += ($tax_1 * $cost_1 + ($total_consumed - $tax_1) * $cost_2);
                    }

                    if ($total_consumed > $tax_2) {
                        $consumed_cost += ($tax_2 * $cost_2 + ($total_consumed - $tax_2) * $cost_3);
                    }

                    break;
                case 4:
                    if ($total_consumed <= $tax_1) {
                        if ($this->consumption_calculation == 'Consumo com Mínimo') {
                            $consumed_cost += $this->moneyConvertToFloat($this->minimum_value);
                        } else {
                            $consumed_cost += ($total_consumed *  $cost_1);
                        }
                    }

                    if ($total_consumed > $tax_1 && $total_consumed <= $tax_2) {
                        $consumed_cost += ($tax_1 * $cost_1 + ($total_consumed - $tax_1) * $cost_2);
                    }

                    if ($total_consumed > $tax_2 && $total_consumed <= $tax_3) {
                        $consumed_cost += ($tax_2 * $cost_2 + ($total_consumed - $tax_2) * $cost_3);
                    }

                    if ($total_consumed > $tax_3) {
                        $consumed_cost += ($tax_3 * $cost_3 + ($total_consumed - $tax_3) * $cost_4);
                    }
                    break;
                case 5:
                    if ($total_consumed <= $tax_1) {
                        if ($this->consumption_calculation == 'Consumo com Mínimo') {
                            $consumed_cost += $this->moneyConvertToFloat($this->minimum_value);
                        } else {
                            $consumed_cost += ($total_consumed *  $cost_1);
                        }
                    }

                    if ($total_consumed > $tax_1 && $total_consumed <= $tax_2) {
                        $consumed_cost += ($tax_1 * $cost_1 + ($total_consumed - $tax_1) * $cost_2);
                    }

                    if ($total_consumed > $tax_2 && $total_consumed <= $tax_3) {
                        $consumed_cost += ($tax_2 * $cost_2 + ($total_consumed - $tax_2) * $cost_3);
                    }

                    if ($total_consumed > $tax_3 && $total_consumed <= $tax_4) {
                        $consumed_cost += ($tax_3 * $cost_3 + ($total_consumed - $tax_3) * $cost_4);
                    }

                    if ($total_consumed > $tax_4) {
                        $consumed_cost += ($tax_4 * $cost_4 + ($total_consumed - $tax_4) * $cost_5);
                    }
                    break;
                case 6:
                    if ($total_consumed <= $tax_1) {
                        if ($this->consumption_calculation == 'Consumo com Mínimo') {
                            $consumed_cost += $this->moneyConvertToFloat($this->minimum_value);
                        } else {
                            $consumed_cost += ($total_consumed *  $cost_1);
                        }
                    }

                    if ($total_consumed > $tax_1 && $total_consumed <= $tax_2) {
                        $consumed_cost += ($tax_1 * $cost_1 + ($total_consumed - $tax_1) * $cost_2);
                    }

                    if ($total_consumed > $tax_2 && $total_consumed <= $tax_3) {
                        $consumed_cost += ($tax_2 * $cost_2 + ($total_consumed - $tax_2) * $cost_3);
                    }

                    if ($total_consumed > $tax_3 && $total_consumed <= $tax_4) {
                        $consumed_cost += ($tax_3 * $cost_3 + ($total_consumed - $tax_3) * $cost_4);
                    }

                    if ($total_consumed > $tax_4 && $total_consumed <= $tax_5) {
                        $consumed_cost += ($tax_4 * $cost_4 + ($total_consumed - $tax_4) * $cost_5);
                    }

                    if ($total_consumed > $tax_5) {
                        $consumed_cost += ($tax_5 * $cost_5 + ($total_consumed - $tax_5) * $cost_6);
                    }
                    break;
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

            $total = $total_consumed + $kite_car_consumed;

            /** Notification */
            if ($total > $this->average) {
                $data['message'] = "Consumo acima da média do condomínio {$this->complex['alias_name']} em {$this->month_ref}/{$this->year_ref}";
                $data['apartment_id'] = $apartment->id;
                $data['dealership_reading_id'] = $this->id;
                $notification = Notification::where('dealership_reading_id', $this->id)
                    ->where('apartment_id', $apartment->id)
                    ->first();
                if ($notification) {
                    $notification->update($data);
                } else {
                    Notification::create($data);
                }
            }

            return [
                'volume_consumed' => $total_consumed, // dealership
                'consumed_cost' => $consumed_cost,
                'sewage_cost' => $sewage_cost,
                'readings' => $readings->pluck('id'),
                'kite_car_consumed' => $kite_car_consumed,
                'kite_car_cost' => $kite_car_cost,
                'total_consumed' => $total
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

            $total_unit = $this->moneyConvertToFloat($report->consumed_cost) + $this->moneyConvertToFloat($report->sewage_cost) +  $this->moneyConvertToFloat($report->kite_car_cost) + $common_area;

            $report->update([
                'total_unit' => $total_unit,
                'partial' => $common_area,
            ]);
        }
    }

    public function kiteCarCalc($value)
    {
        if ($this->kite_car == 'Sim') {
            $dealership_consumption = $this->convertToFloat($this->dealership_consumption);
            $total_complex_consumption = $dealership_consumption + $this->convertToFloat($this->kite_car_consumption);
            $value = $value * ($dealership_consumption / $total_complex_consumption);
        }
        return $value;
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
