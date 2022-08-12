<?php

namespace App\Imports;

use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApartmentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Apartment([
            'name' => $row['nome'],
            'status' => 'Ativo',
            'user_id' => Auth::user()->id,
            'block_id' => Block::where('name', $row['bloco'])->where('complex_id', Complex::where('alias_name', $row['condominio'])->first()->id)->first()->id,
            'fraction' => $row['fracao'] ?? 0,
        ]);
    }
}
