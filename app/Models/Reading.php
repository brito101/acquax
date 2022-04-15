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
        'cover_base64'
    ];

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
}
