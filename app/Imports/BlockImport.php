<?php

namespace App\Imports;

use App\Models\Block;
use App\Models\Complex;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BlockImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Block([
            'name' => $row['nome'],
            'status' => 'Ativo',
            'user_id' => Auth::user()->id,
            'complex_id' => Complex::where('alias_name', $row['condominio'])->first()->id,
        ]);
    }
}
