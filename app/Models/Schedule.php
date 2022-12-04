<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'description', 'start', 'end', 'user_id'];

    /** Relationships */
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
