<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealershipReadingGas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dealership_readings_gas';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'complex_id',
        'month_ref',
        'year_ref',
        'dealership_id',
        'reading_date',
        'reading_date_next',
        'total_days',
        'billed_consumption',
        'dealership_consumption',
        'dealership_cost',
        'monthly_consumption',
        'total_value',
        'consumption_value',
        'editor',
    ];

    /**
     * Relationships
     * */
    public function complex()
    {
        return $this->belongsTo(Complex::class);
    }

    public function dealership()
    {
        return $this->belongsTo(Dealership::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'editor')->withDefault([
            'name' => 'usário não informado',
        ]);
    }
}
