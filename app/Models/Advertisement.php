<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'cover', 'link', 'status', 'editor', 'views'];

    /** Relationships */
    public function user()
    {
        return $this->belongsTo(User::class, 'editor')->withDefault([
            'name' => 'usuário não informado',
        ]);
    }
}
