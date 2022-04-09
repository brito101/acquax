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
        'block_id'
    ];

    protected $appends = ['complex_name', 'block_name'];

    /** Relationships */

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    // Mutator
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
}
