<?php

namespace App\Models;

use App\Models\Settings\TypeMeter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meter extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'register',
        'status',
        'apartment_id',
        'type_meter_id',
        'user_id',
        'location',
        'initial_reading',
    ];

    /** Relationships */

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function typeMeter()
    {
        return $this->belongsTo(TypeMeter::class);
    }

    public function reading()
    {
        return $this->hasMany(Reading::class);
    }

    /**  Accessor */
    public function getInitialReadingAttribute($value)
    {
        return number_format($value, 13, ",", ".");
    }

    /** Aux */
    public function lastReading()
    {
        $reading = Reading::where('meter_id', $this->id)->orderBy('created_at', 'desc')->first();
        return $reading;
    }
}
