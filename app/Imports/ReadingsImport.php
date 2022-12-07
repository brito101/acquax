<?php

namespace App\Imports;

use App\Models\Meter;
use App\Models\Reading;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReadingsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (isset($row['chassi'])) {
            return new Reading([
                'meter_id' => Meter::where('register', $row['chassi'])->first()->id,
                'reading' => str_replace(',', '.', $row['leitura']),
                'month_ref' => $row['mes_ref'],
                'year_ref' => $row['ano_ref'],
                'reading_date' => Carbon::createFromFormat('d/m/Y', $row['data_leitura'])->format('Y-m-d'),
                'reading_date_next' => Carbon::createFromFormat('d/m/Y', $row['prox_leitura'])->format('Y-m-d'),
                'url_cover' => $row['foto'],
                'editor' => Auth::user()->id
            ]);
        }
    }
}
