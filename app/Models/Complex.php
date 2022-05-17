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

    public function dealershipReading()
    {
        return $this->hasMany(DealershipReading::class);
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

    public function getValuesChart()
    {
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        $values = [];
        foreach ($months as $month) {
            $dealershipReading = DealershipReading::where('complex_id', $this->id)->where('month_ref', $month)->where('year_ref', date('Y'))->first();
            $monthly_consumption = $this->convertToFloat($dealershipReading['monthly_consumption'] ?? 0);
            $commonArea = $this->convertToFloat($dealershipReading['diff_consumption'] ?? 0);
            $real_cost = $this->moneyConvertToFloat($dealershipReading['real_cost'] ?? 0);

            $values[] = array($monthly_consumption, $commonArea, $real_cost);
        }
        return ($values);
    }

    private function convertToFloat($number)
    {
        return (float)str_replace(',', '.', str_replace('.', '', $number));
    }

    private function moneyConvertToFloat($number)
    {
        return (float)str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $number)));
    }
}
