<?php

namespace App\Models;

use App\Models\Settings\TypeMeter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reading extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'meter_id',
        'reading',
        'month_ref',
        'year_ref',
        'reading_date',
        'reading_date_next',
        'cover',
        'editor',
        'cover_base64',
        'url_cover'
    ];

    protected $appends = [
        'volume_consumed',
        'previous_volume_consumed',
        'comparative_percentage',
        'clear_comparative_percentage'
    ];

    /** Relationships */

    public function meter()
    {
        return $this->belongsTo(Meter::class)->withDefault([
            'register' => 'excluído do sistema',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'editor')->withDefault([
            'name' => 'usário não informado',
        ]);
    }

    /**  Accessor */
    public function getReadingAttribute($value)
    {
        return number_format($value, 13, ",", ".");
    }

    public function getReadingDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    public function getReadingDateNextAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

    /** Aux functions */
    public function getRoundedReading()
    {
        $value = str_replace(',', '.', str_replace('.', '', $this->reading));
        return number_format($value, 2, ",", ".");
    }

    /** Appends */
    public function getVolumeConsumedAttribute()
    {
        $datePrevious = $this->getPreviousDateRef($this->month_ref, $this->year_ref);
        $previous = Reading::where('month_ref', $datePrevious[0])
            ->where('year_ref', $datePrevious[1])
            ->where('meter_id', $this->meter_id)->first();

        if ($previous) {
            if ($this->meter->rotation == 'Crescente') {
                $volume = $this->convertToFloat($this->reading) - $this->convertToFloat($previous->reading);
            } elseif ($this->meter->rotation == 'Decrescente') {
                $volume = $this->convertToFloat($previous->reading) - $this->convertToFloat($this->reading);
            } else {
                $volume = $this->convertToFloat($this->reading) - $this->convertToFloat($previous->reading);
            }
        } else {
            $typeMeterWater = TypeMeter::where('name', 'Água')->first();
            $mether = Meter::where('id', $this->meter_id)->where('type_meter_id', $typeMeterWater->id)->first();
            if ($mether) {
                if ($this->meter->rotation == 'Crescente') {
                    $volume = $this->convertToFloat($this->reading) - $this->convertToFloat($mether->initial_reading);
                } elseif ($this->meter->rotation == 'Decrescente') {
                    $volume = $this->convertToFloat($mether->initial_reading) - $this->convertToFloat($this->reading);
                } else {
                    $volume = $this->convertToFloat($this->reading) - $this->convertToFloat($mether->initial_reading);
                }
            } else {
                $volume = $this->convertToFloat($this->reading);
            }
        }
        return number_format($volume, 13, ",", ".");
    }

    public function getPreviousVolumeConsumedAttribute()
    {
        $datePrevious = $this->getPreviousDateRef($this->month_ref, $this->year_ref);
        $previous = Reading::where('month_ref', $datePrevious[0])
            ->where('year_ref', $datePrevious[1])
            ->where('meter_id', $this->meter_id)->first();
        $datePrePrevious = $this->getPrePreviousDateRef($this->month_ref, $this->year_ref);
        $pre_previous = Reading::where('month_ref', $datePrePrevious[0])
            ->where('year_ref', $datePrePrevious[1])
            ->where('meter_id', $this->meter_id)->first();

        if ($previous && $pre_previous) {
            $volume = $this->convertToFloat($previous->reading) - $this->convertToFloat($pre_previous->reading);
        } elseif ($previous) {
            $typeMeterWater = TypeMeter::where('name', 'Água')->first();
            $mether = Meter::where('id', $this->meter_id)->where('type_meter_id', $typeMeterWater->id)->first();
            if ($mether) {
                $volume = $this->convertToFloat($previous->reading) - $this->convertToFloat($mether->initial_reading);
            } else {
                return "Inexistente";
            }
        } else {
            return "Inexistente";
        }
        return number_format($volume, 13, ",", ".");
    }

    public function getComparativePercentageAttribute()
    {
        $actual = $this->convertToFloat($this->volume_consumed);
        $previous = $this->convertToFloat($this->previous_volume_consumed);
        if (is_numeric($actual) && is_numeric($previous)) {
            if ($previous != 0) {
                return number_format(((($actual * 100) / $previous) - 100), 2, ",", ".") . "%";
            } else {
                return number_format(($actual * 100), 2, ",", ".") . "%";
            }
        }
        return "Inexistente";
    }

    public function getClearComparativePercentageAttribute()
    {
        $actual = $this->convertToFloat($this->volume_consumed);
        $previous = $this->convertToFloat($this->previous_volume_consumed);
        if (is_numeric($actual) && is_numeric($previous) && $previous != 0) {
            return (($actual * 100) / $previous) - 100;
        }
        return 0;
    }

    /** Aux function */
    private function convertToFloat($number)
    {
        return str_replace(',', '.', str_replace('.', '', $number));
    }

    private function getPreviousDateRef($month, $year)
    {
        switch ($month) {
            case 'Janeiro':
                return array('Dezembro', (int)$year - 1);
                break;
            case 'Fevereiro':
                return array('Janeiro', $year);
                break;
            case 'Março':
                return array('Fevereiro', $year);
                break;
            case 'Abril':
                return array('Março', $year);
                break;
            case 'Maio':
                return array('Abril', $year);
                break;
            case 'Junho':
                return array('Maio', $year);
                break;
            case 'Julho':
                return array('Junho', $year);
                break;
            case 'Agosto':
                return array('Julho', $year);
                break;
            case 'Setembro':
                return array('Agosto', $year);
                break;
            case 'Outubro':
                return array('Setembro', $year);
                break;
            case 'Novembro':
                return array('Outubro', $year);
                break;
            case 'Dezembro':
                return array('Novembro', $year);
                break;
            default:
                return array(null, null);
        }
    }

    private function getPrePreviousDateRef($month, $year)
    {
        switch ($month) {
            case 'Janeiro':
                return array('Novembro', (int)$year - 1);
                break;
            case 'Fevereiro':
                return array('Dezembro', (int)$year - 1);
                break;
            case 'Março':
                return array('Janeiro', $year);
                break;
            case 'Abril':
                return array('Fevereiro', $year);
                break;
            case 'Maio':
                return array('Março', $year);
                break;
            case 'Junho':
                return array('Abril', $year);
                break;
            case 'Julho':
                return array('Maio', $year);
                break;
            case 'Agosto':
                return array('Junho', $year);
                break;
            case 'Setembro':
                return array('Julho', $year);
                break;
            case 'Outubro':
                return array('Agosto', $year);
                break;
            case 'Novembro':
                return array('Setembro', $year);
                break;
            case 'Dezembro':
                return array('Outubro', $year);
                break;
            default:
                return array(null, null);
        }
    }
}
