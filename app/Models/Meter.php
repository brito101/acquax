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
        'year_manufacture',
        'main',
        'rotation',
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

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'usário não informado',
        ]);
    }

    /**  Accessor */
    public function getInitialReadingAttribute($value)
    {
        return number_format($value, 13, ",", ".");
    }

    public function getMainAttribute($value)
    {
        if ($value == true) {
            return 'Sim';
        } else {
            return 'Não';
        }
    }

    /** Aux */
    public function lastReading()
    {
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        $reading = null;
        foreach ($months as $month) {
            $readingMonth = Reading::where('meter_id', $this->id)->where('month_ref', $month)->where('year_ref', date('Y'))->first();
            if ($readingMonth) {
                $reading = $readingMonth;
            }
        }

        if ($reading == null) {
            foreach ($months as $month) {
                $readingMonth = Reading::where('meter_id', $this->id)->where('month_ref', $month)->where('year_ref', (date('Y') - 1))->first();
                if ($readingMonth) {
                    $reading = $readingMonth;
                }
            }
        }

        return $reading;
    }
}
