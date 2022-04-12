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
        'user_id'
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
}
