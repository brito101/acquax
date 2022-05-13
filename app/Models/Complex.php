<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complex extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'social_name',
        'alias_name',
        'document_company',
        'document_company_secondary',
        'email',
        'telephone',
        'cell',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
        'photo',
        'facebook',
        'instagram',
        'twitter',
        'user_id',
        'apportionment'
    ];

    /** Relationships */

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

    public function apartments()
    {
        return $this->hasManyThrough(Apartment::class, Block::class);
    }

    /** Aux */
    public function lastReading()
    {
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
        $reading = null;
        foreach ($months as $month) {
            $readingMonth = DealershipReading::where('complex_id', $this->id)->where('month_ref', $month)->where('year_ref', date('Y'))->first();
            if ($readingMonth) {
                $reading = $readingMonth;
            }
        }

        if ($reading == null) {
            foreach ($months as $month) {
                $readingMonth = DealershipReading::where('complex_id', $this->id)->where('month_ref', $month)->where('year_ref', (date('Y') - 1))->first();
                if ($readingMonth) {
                    $reading = $readingMonth;
                }
            }
        }

        return $reading;
    }
}
