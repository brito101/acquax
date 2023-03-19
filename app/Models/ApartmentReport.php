<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApartmentReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'apartment_reports';

    protected $casts = [
        'readings' => 'array',
    ];

    protected $fillable = [
        'consumed', 'consumed_cost', 'sewage_cost', 'total_unit', 'partial',
        'dealership_reading_id', 'readings', 'apartment_id', 'month_ref',
        'year_ref', 'kite_car_consumed', 'kite_car_cost', 'total_consumed', 'editor',
        'consumption_gas_value', 'total_gas_value'
    ];

    /** Relationships */
    public function apartment()
    {
        return $this->belongsTo(Apartment::class)->withDefault([
            'name' => 'Excluído',
            'block_name' => 'Excluído',
        ]);;
    }

    public function dealershipReading()
    {
        return $this->belongsTo(DealershipReading::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'editor')->withDefault([
            'name' => 'usário não informado',
        ]);
    }

    /** Accessors */
    public function getConsumedAttribute($value)
    {
        return number_format($value, 3, ',', '.');
    }

    public function getConsumedCostAttribute($value)
    {
        return $this->convertToMoney($value);
    }

    public function getSewageCostAttribute($value)
    {
        return $this->convertToMoney($value);
    }

    public function getTotalUnitAttribute($value)
    {
        return $this->convertToMoney($value);
    }

    public function getPartialAttribute($value)
    {
        return $this->convertToMoney($value);
    }

    public function getKiteCarConsumedAttribute($value)
    {
        return number_format($value, 3, ',', '.');
    }

    public function getKiteCarCostAttribute($value)
    {
        return 'R$ ' . number_format($value, 3, ',', '.');
    }

    public function getTotalConsumedAttribute($value)
    {
        return number_format($value, 3, ',', '.');
    }

    public function getConsumptionGasValueAttribute($value)
    {
        if ($value) {
            return number_format($value, 3, ',', '.');
        } else {
            return null;
        }
    }


    public function getTotalGasValueAttribute($value)
    {
        if ($value) {
            return 'R$ ' . number_format($value, 2, ',', '.');
        } else {
            return null;
        }
    }


    /** Aux */
    private function convertToMoney($number)
    {
        return 'R$ ' . number_format($number, 3, ',', '.');
    }
}
