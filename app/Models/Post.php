<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'slug',
        'headline',
        'content',
        'status',
        'editor',
        'views',
        'cover'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'editor')->withDefault([
            'name' => env('APP_NAME'),
        ]);
    }
}
