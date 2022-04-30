<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'meter_id',
        'reading',
        'month_ref',
        'reading_date',
        'reading_date_next',
        'cover',
        'editor',
        'cover_base64',
        'url_cover'
    ];

    protected $appends = ['volume_consumed', 'previous_volume_consumed'];

    /** Relationships */

    public function meter()
    {
        return $this->belongsTo(Meter::class);
    }

    /**  Accessor */
    public function getReadingAttribute($value)
    {
        return number_format($value, 13, ",", ".");
    }

    public function getReadingDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getReadingDateNextAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    /** Aux functions */
    public function getRoundedReading()
    {
        $value = str_replace(',', '.', str_replace('.', '', $this->reading));
        return number_format($value, 2, ",", ".");
    }

    /** Appends */
    public function getVolumeConsumedAttribute()
    {
        $previous = Reading::where('id', '<', $this->id)->where('meter_id', $this->meter_id)->first();
        if ($previous) {
            $volume = $this->converToFloat($this->reading) - $this->converToFloat($previous->reading);
        } else {
            $mether = Meter::where('id', $this->meter_id)->first();
            $volume = $this->converToFloat($this->reading) - $this->converToFloat($mether->initial_reading);
        }
        return number_format($volume, 13, ",", ".");
    }

    public function getPreviousVolumeConsumedAttribute()
    {
        $previous = Reading::where('id', '<', $this->id)->where('meter_id', $this->meter_id)->first();
        $pre_previous = Reading::where('id', '<', $this->id)->where('meter_id', $this->meter_id)->offset(1)->first();

        if ($previous && $pre_previous) {
            $volume = $this->converToFloat($previous->reading) - $this->converToFloat($pre_previous->reading);
        } elseif ($previous) {
            $mether = Meter::where('id', $this->meter_id)->first();
            $volume = $this->converToFloat($previous->reading) - $this->converToFloat($mether->initial_reading);
        } else {
            return "Inexistente";
        }
        return number_format($volume, 13, ",", ".");
    }

    /** Aux function */
    private function converToFloat($number)
    {
        return str_replace(',', '.', str_replace('.', '', $number));
    }
}
