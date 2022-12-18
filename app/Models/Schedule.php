<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'description', 'start', 'end', 'user_id', 'color', 'type', 'complex_id'];

    protected $appends = ['author', 'complex', 'visualized_by', 'executed_by', 'start_br', 'end_br'];

    /** Relationships */
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Inexistente'
        ]);
    }

    public function complex()
    {
        return $this->belongsTo(Complex::class)->withDefault([
            'alias_name' => 'Inexistente'
        ]);
    }


    /** Appends */
    public function getAuthorAttribute()
    {
        return User::find($this->user_id)->name ?? 'Inexistente';
    }

    public function getComplexAttribute()
    {
        return Complex::find($this->complex_id)->alias_name ?? 'Inexistente';
    }

    public function getVisualizedByAttribute()
    {
        $guests = Guest::where('schedule_id', $this->id)->where('visualized', true)->pluck('user_id');
        $users = [];
        foreach ($guests as $guest) {
            $user = User::find($guest);
            if ($user) {
                $users[] = $user->name;
            }
        }

        return join(", ", $users);
    }

    public function getExecutedByAttribute()
    {
        $guests = Guest::where('schedule_id', $this->id)->where('executed', true)->pluck('user_id');
        $users = [];
        foreach ($guests as $guest) {
            $user = User::find($guest);
            if ($user) {
                $users[] = $user->name;
            }
        }

        return join(", ", $users);
    }

    public function getStartBrAttribute($value)
    {
        return date('d/m/Y H:i', strtotime($this->start));
    }

    public function getEndBrAttribute($value)
    {
        return date('d/m/Y H:i', strtotime($this->end));
    }
}
