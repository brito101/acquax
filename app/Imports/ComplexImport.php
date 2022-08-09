<?php

namespace App\Imports;

use App\Models\Complex;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ComplexImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Complex([
            'social_name' => $row['nome'],
            'alias_name' => $row['nome_fantasia'],
            'document_company' => $row['cnpj'],
            'document_company_secondary' => $row['inscricao_estadual'],
            'email' => $row['e_mail'],
            'telephone' => $row['telefone'],
            'cell' => $row['celular'],
            'zipcode' => $row['cep'],
            'street' => $row['rua'],
            'number' => $row['numero'],
            'complement' => $row['complemento'],
            'neighborhood' => $row['bairro'],
            'state' => $row['estado'],
            'city' => $row['cidade'],
            'user_id' => Auth::user()->id,
            'status' => $row['status'] ?? 'Ativo'
        ]);
    }
}
