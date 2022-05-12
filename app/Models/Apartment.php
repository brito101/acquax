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
        'block_id',
        'fraction'
    ];

    protected $appends = ['complex_name', 'block_name'];

    /** Relationships */

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function meter()
    {
        return $this->hasMany(Meter::class);
    }

    /** Accessor */
    public function getFractionAttribute($value)
    {
        return number_format($value, 3, ",", ".") . '%';
    }

    /**  Appends */
    public function getBlockNameAttribute()
    {
        return $this->block['name'];
    }

    public function getComplexNameAttribute()
    {
        return $this->block->complex['alias_name'];
    }

    /** Aux */
    public function getValuesChart()
    {
        $meters = Meter::where('apartment_id', $this->id)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)->where('year_ref', date('Y'))->get();
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        $values = [];
        foreach ($months as $month) {
            $consumed = 0;
            $comparativePercentage = 0;
            $dealershipReading = DealershipReading::where('complex_id', $this->block['complex_id'])->where('month_ref', $month)->where('year_ref', date('Y'))->first();
            $commonArea = $this->convertToFloat($dealershipReading['diff_consumption'] ?? 0);
            $total = 0;
            if ($dealershipReading) {
                $total = $this->moneyConvertToFloat($dealershipReading->getApartmentReport($this)['total_unit'] ?? 0);
            }
            foreach ($readings as $reading) {
                if ($reading->month_ref == $month) {
                    $consumed += $this->convertToFloat($reading->volume_consumed);
                    $comparativePercentage += number_format($reading->clear_comparative_percentage, 2);
                }
            }
            $values[] = array($consumed, $comparativePercentage, $commonArea, $total);
        }
        return ($values);
    }

    public function getTotalConsume()
    {
        $meters = Meter::where('apartment_id', $this->id)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)->where('year_ref', date('Y'))->get();
        $consumed = 0;
        foreach ($readings as $reading) {
            $consumed += $this->convertToFloat($reading->volume_consumed);
        }

        return $consumed;
    }

    public function getAverageConsume()
    {
        $meters = Meter::where('apartment_id', $this->id)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)->where('year_ref', date('Y'))->get();
        $units = 0;
        $consumed = 0;
        foreach ($readings as $reading) {
            $units++;
            $consumed += $this->convertToFloat($reading->volume_consumed);
        }
        if ($units > 0) {
            return $consumed / $units;
        } else {
            return 0;
        }
    }

    public function getMonthlyReport()
    {
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        $values = [];
        foreach ($months as $month) {
            $dealershipReading = DealershipReading::where('complex_id', $this->block['complex_id'])->where('month_ref', $month)->where('year_ref', date('Y'))->first();
            if ($dealershipReading) {
                $values[$month] = $dealershipReading->getApartmentReport($this);
            } else {
                $values[$month] = null;
            }
        }

        return  $values;
    }

    public function getFullReports()
    {
        $dealershipReading = DealershipReading::where('complex_id', $this->block['complex_id'])->orderBy('reading_date', 'desc')->get();
        $values = [];
        foreach ($dealershipReading as $item) {
            $values[] = array($item, $item->getApartmentReport($this));
        }
        return  $values;
    }

    public function getAverageCost()
    {
        $total = 0;
        $units = 0;
        foreach ($this->getMonthlyReport() as $key => $value) {
            if ($value) {
                $units++;
                $total += $this->moneyConvertToFloat($value['total_unit']);
            }
        }

        if ($units > 0) {
            return ($total / $units);
        } else {
            return 0;
        }
    }

    public function getAverageCommonArea()
    {
        $total = 0;
        $units = 0;
        foreach ($this->getMonthlyReport() as $key => $value) {
            if ($value) {
                $units++;
                $total += $this->moneyConvertToFloat($value['partial']);
            }
        }

        if ($units > 0) {
            return ($total / $units);
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
