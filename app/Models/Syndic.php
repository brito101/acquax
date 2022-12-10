<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Syndic extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'status',
        'complex_id',
        'editor',
    ];

    /** Accessors */
    public function getFirstAccessAttribute($value)
    {
        $value = ($value === 1 || $value === true) ? 'Sim' : 'Não';
        return $value;
    }

    /** Relationships */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Inexistente',
        ]);
    }

    public function complex()
    {
        return $this->belongsTo(Complex::class)->withDefault([
            'alias_name' => 'Inexistente',
        ]);
    }

    /** Aux */
    public function editorName()
    {
        $editor = User::find($this->editor);
        if ($editor) {
            return $editor;
        } else {
            return ['name' => 'usário não informado'];
        }
    }
}
