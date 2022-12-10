<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'status',
        'apartment_id',
        'editor',
    ];

    /** Relationships */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Inexistente',
        ]);
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class)->withDefault([
            'name' => 'Inexistente',
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
