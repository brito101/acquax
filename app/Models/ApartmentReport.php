<?php

namespace App\Models;

use App\Models\Views\Apartment;
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
        'consumed', 'consumed_cost', 'sewage_cost', 'total_unit', 'partial', 'dealership_reading_id', 'readings', 'apartment_id', 'month_ref', 'year_ref'
    ];

    /** Relationships */
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function dealershipReading()
    {
        return $this->belongsTo(DealershipReading::class);
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

    /** Aux */
    private function convertToMoney($number)
    {
        return 'R$ ' . number_format($number, 2, ',', '.');
    }
}
