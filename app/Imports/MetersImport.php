<?php

namespace App\Imports;

use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Meter;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MetersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Meter([
            'register' => $row['chassi'],
            'status' => 'Ativo',
            'apartment_id' => Apartment::where('name', $row['apartamento'])->where('block_id', Block::where('name', $row['bloco'])->where('complex_id', Complex::where('alias_name', $row['condominio'])->first()->id)->first()->id)->first()->id,
            'type_meter_id' => $row['tipo'] == 'Gás' || $row['tipo'] == 'Gas' || $row['tipo'] == 'gas' || $row['tipo'] == 'gás' ? 2 : 1,
            'user_id' => Auth::user()->id,
            'location' => $row['localizacao'] ?? null,
            'initial_reading' => $row['leitura_inicial'] ? str_replace(',', '.', $row['leitura_inicial']) : 0,
            'year_manufacture' => $row['ano_fabricacao'] ?? null,
            'main' =>  $row['principal'] == 'Não' ? false : true,
            'rotation' => $row['rotacao'] ?? 'Crescente'
        ]);
    }
}
