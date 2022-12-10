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
        'monthly_consumption',
        'total_value',
        'consumption_value',
        'sewage_value',
        'diff_cost',
        'diff_consumption',
        'previous_billed_consumption',
        'previous_monthly_consumption',
        'consumption_ranges',
        'consumption_tax_1',
        'consumption_tax_2',
        'consumption_tax_3',
        'units_inside_tax_1',
        'units_inside_tax_2',
        'units_inside_tax_3',
        /** computed data */
        'consumption_tax_4',
        'consumption_tax_5',
        'consumption_tax_6',
        'units_inside_tax_4',
        'units_inside_tax_5',
        'units_inside_tax_6',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'editor')->withDefault([
            'name' => 'usário não informado',
        ]);
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
    public function setAverageAttribute($value)
    {
        $total = 0;
        $blocks = Block::where('complex_id', $this->complex_id)->pluck('id');
        $units = Apartment::whereIn('block_id', $blocks)->count();

        if ($units > 0) {
            $total = $this->convertToFloat($this->monthly_consumption) / $units;
        }

        $this->attributes['average'] = $total;
    }

    /**
     * Aux function
     * */
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
}
