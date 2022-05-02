<?php

namespace App\Models;

use Facade\FlareClient\Api;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

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
        'editor'
    ];

    protected $appends = [
        'monthly_consumption',
        'diff_consumption',
        'previous_monthly_consumption',
        'consumption_tax_1',
        'total_cost_tax_1',
        'consumption_tax_2',
        'total_cost_tax_2',
        'real_cost',
        'diff_cost',
        'units_inside_tax_1',
        'units_above_tax_1'
    ];

    /** Relationships */

    public function complex()
    {
        return $this->belongsTo(Complex::class);
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

    public function getMonthlyConsumptionAttribute()
    {
        $volume_consumed = 0;
        foreach ($this->getApartmentReadings() as $reading) {
            $volume_consumed += ($this->convertToFloat($reading->volume_consumed));
        }

        return number_format($volume_consumed, 3, ",", ".");
    }

    public function getDiffConsumptionAttribute()
    {
        $total = 0;
        $volume_consumed = 0;
        foreach ($this->getApartmentReadings() as $reading) {
            $volume_consumed += ($this->convertToFloat($reading->volume_consumed));
        }

        $total = $volume_consumed - $this->convertToFloat($this->dealership_consumption);

        return number_format($total, 3, ",", ".");
    }

    public function getPreviousMonthlyConsumptionAttribute()
    {
        $previous_volume_consumed = 0;
        foreach ($this->getApartmentReadings() as $reading) {
            if ($reading->previous_volume_consumed != "Inexistente") {
                $previous_volume_consumed += ($this->convertToFloat($reading->previous_volume_consumed));
            }
        }

        return number_format($previous_volume_consumed, 3, ",", ".");
    }

    public function getConsumptionTax1Attribute()
    {
        $volume_consumed = 0;
        $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($value > $tax_1) {
                $volume_consumed += $tax_1;
            } else {
                $volume_consumed += $value;
            }
        }

        return number_format($volume_consumed, 3, ",", ".");
    }


    public function getTotalCostTax1Attribute()
    {
        $tax = $this->convertToFloat($this->dealership_consumption_tax_1);
        $cost = $this->convertToFloat(str_replace('R$ ', '', $this->dealership_cost_tax_1));
        $readings = count($this->getApartmentReadings());
        $total = $tax * $cost * $readings;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getConsumptionTax2Attribute()
    {
        $volume_consumed = 0;
        $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);
        $tax_2 = $this->convertToFloat($this->dealership_consumption_tax_2);
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($value >= $tax_2) {
                $volume_consumed += $value - $tax_1;
            }
        }

        return number_format($volume_consumed, 3, ",", ".");
    }

    public function getTotalCostTax2Attribute()
    {
        $tax_1 = $this->convertToFloat($this->dealership_consumption_tax_1);
        $tax_2 = $this->convertToFloat($this->dealership_consumption_tax_2);
        $cost = $this->convertToFloat(str_replace('R$ ', '', $this->dealership_cost_tax_2));
        $total = 0;
        foreach ($this->getApartmentReadings() as $reading) {
            $value = $this->convertToFloat($reading->volume_consumed);
            if ($value >= $tax_2) {
                $total += ($value - $tax_1) * $cost;
            }
        }

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getRealCostAttribute()
    {
        $cost_tax_1 = $this->convertToFloat(str_replace('R$ ', '', $this->total_cost_tax_1));
        $cost_tax_2 = $this->convertToFloat(str_replace('R$ ', '', $this->total_cost_tax_2));

        $total = ($cost_tax_1 + $cost_tax_2) * 2;

        return 'R$ ' . number_format($total, 2, ",", ".");
    }

    public function getDiffCostAttribute()
    {
        $real_cost = $this->convertToFloat(str_replace('R$ ', '', $this->real_cost));
        $dealership_cost = $this->convertToFloat(str_replace('R$ ', '', $this->dealership_cost));

        $total = $real_cost - $dealership_cost;

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
            $readings = Reading::whereIn('meter_id', $meters)->where('month_ref', $this->month_ref)->get();
            $total_consumed = 0;
            foreach ($readings as $reading) {
                $total_consumed += $this->convertToFloat($reading->volume_consumed);
            }
            if ($total_consumed <= $this->convertToFloat($this->dealership_consumption_tax_1)) {
                $units++;
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
            $readings = Reading::whereIn('meter_id', $meters)->where('month_ref', $this->month_ref)->get();
            $total_consumed = 0;
            foreach ($readings as $reading) {
                $total_consumed += $this->convertToFloat($reading->volume_consumed);
            }
            if ($total_consumed > $this->convertToFloat($this->dealership_consumption_tax_1)) {
                $units++;
            }
        }

        return $units;
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
        $readings = Reading::whereIn('meter_id', $meters)->where('month_ref', $this->month_ref)->get();
        return $readings;
    }

    private function convertToFloat($number)
    {
        return str_replace(',', '.', str_replace('.', '', $number));
    }
}
