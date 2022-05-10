<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'status',
        'user_id',
        'block_id',
        'fraction'
    ];

    protected $appends = ['complex_name', 'block_name'];

    /** Relationships */

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function meter()
    {
        return $this->hasMany(Meter::class);
    }

    /** Accessor */
    public function getFractionAttribute($value)
    {
        return number_format($value, 3, ",", ".") . '%';
    }

    /**  Appends */
    public function getBlockNameAttribute()
    {
        $block = Block::where('id', $this->block_id)->first();
        return $block['name'] ?? '';
    }

    public function getComplexNameAttribute()
    {
        $block = Block::where('id', $this->block_id)->first();
        if (!empty($block->id)) {
            $complex = Complex::where('id', $block->complex_id)->first();
        } else {
            $complex = null;
        }
        return $complex['alias_name'] ?? '';
    }

    public function getYarlyConsumtion()
    {
        $meters = Meter::where('apartment_id', $this->id)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)->where('year_ref', date('Y'))->get();
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        $values = [];
        foreach ($months as $month) {
            $consumed = 0;
            foreach ($readings as $reading) {
                if ($reading->month_ref == $month) {
                    $consumed += $this->convertToFloat($reading->volume_consumed);
                }
            }
            $values[] = $consumed;
        }
        return ($values);
    }

    private function convertToFloat($number)
    {
        return (float)str_replace(',', '.', str_replace('.', '', $number));
    }
}
