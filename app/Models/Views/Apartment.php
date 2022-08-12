<?php

namespace App\Models\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    public $table = 'apartments_record_view';

    /** Accessor */
    public function getFractionAttribute($value)
    {
        return number_format($value, 8, ",", ".");
    }
}
