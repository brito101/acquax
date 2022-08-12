<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentReport extends Model
{
    use HasFactory;

    protected $table = 'apartment_reports_view';

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
        return 'R$ ' . number_format($value, 2, ',', '.');
    }


    /** Aux */
    private function convertToMoney($number)
    {
        return 'R$ ' . number_format($number, 2, ',', '.');
    }
}
