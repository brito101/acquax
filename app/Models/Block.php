<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'status',
        'user_id',
        'complex_id'
    ];

    protected $appends = ['complex_name'];

    /** Relationships */

    public function complex()
    {
        return $this->belongsTo(Complex::class);
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'usário não informado',
        ]);
    }

    // Mutator
    public function getComplexNameAttribute()
    {
        $complex = Complex::where('id', $this->complex_id)->first();
        return $complex['alias_name'] ?? '';
    }
}
