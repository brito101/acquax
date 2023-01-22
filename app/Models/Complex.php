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
        'status'
    ];

    protected $appends = [
        'total_blocks',
        'total_apartments',
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

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'usário não informado',
        ]);
    }

    public function getTotalBlocksAttribute($values)
    {
        return $this->blocks->count();
    }

    public function getTotalApartmentsAttribute($values)
    {
        return $this->hasManyThrough(Apartment::class, Block::class)->count();
    }

    /** Aux */
    public function lastReading()
    {
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
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
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        $values = [];
        foreach ($months as $month) {
            $dealershipReading = DealershipReading::where('complex_id', $this->id)->where('month_ref', $month)->where('year_ref', date('Y'))->first();
            $monthly_consumption = $this->convertToFloat($dealershipReading['dealership_consumption'] ?? 0);
            $commonArea = $this->convertToFloat($dealershipReading['diff_consumption'] ?? 0);
            $real_cost = $this->moneyConvertToFloat($dealershipReading['dealership_cost'] ?? 0);

            $values[] = array($monthly_consumption, $commonArea, $real_cost);
        }
        return ($values);
    }

    public function getAverageConsume()
    {
        $readings = DealershipReading::where('complex_id', $this->id)->where('year_ref', date('Y'))->get();
        $units = 0;
        $consumed = 0;
        foreach ($readings as $reading) {
            $units++;
            $consumed += $this->convertToFloat($reading->dealership_consumption);
        }
        if ($units > 0) {
            return $consumed / $units;
        } else {
            return 0;
        }
    }

    public function getTotalConsume()
    {
        $readings = DealershipReading::where('complex_id', $this->id)->where('year_ref', date('Y'))->get();
        $consumed = 0;
        foreach ($readings as $reading) {
            $consumed += $this->convertToFloat($reading->dealership_consumption);
        }

        return $consumed;
    }

    public function getAverageCost()
    {
        $readings = DealershipReading::where('complex_id', $this->id)->where('year_ref', date('Y'))->get();
        $units = 0;
        $cost = 0;
        foreach ($readings as $reading) {
            $units++;
            $cost += $this->moneyConvertToFloat($reading->dealership_cost);
        }
        if ($units > 0) {
            return $cost / $units;
        } else {
            return 0;
        }
    }

    public function getAverageCommonArea()
    {
        $readings = DealershipReading::where('complex_id', $this->id)->where('year_ref', date('Y'))->get();
        $units = 0;
        $cost = 0;
        foreach ($readings as $reading) {
            $units++;
            $cost += $this->moneyConvertToFloat($reading->diff_consumption);
        }
        if ($units > 0) {
            return $cost / $units;
        } else {
            return 0;
        }
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
