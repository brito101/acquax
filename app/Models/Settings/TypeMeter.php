<?php

namespace App\Models\Settings;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeMeter extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'acronym', 'user_id'];

    /** Relationships */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'usuário não informado',
        ]);
    }
}
