<?php

namespace App\Imports;

use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Resident;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $userCheck = User::withTrashed()->where('email', $row['e_mail'])->first();

        if (empty($userCheck->email)) {

            $complex = Complex::where('alias_name', $row['condominio'])->first();
            $block = Block::where('complex_id', $complex->id)->where('name', $row['bloco'])->first();
            $apartment = Apartment::where('block_id', $block->id)->where('name', $row['apartamento'])->first();

            $resident = Resident::where('apartment_id', $apartment->id)->first();
            if (!empty($resident->id)) {
                $user = User::where('id', $resident->user_id)->first();
                if (!empty($user->id)) {
                    $user->email = $row['e_mail'];
                    $user->update();
                }
            } else {
                $newUser = User::create([
                    'name'      => $row['e_mail'],
                    'email'     => $row['e_mail'],
                    'document_person' => '000.000.000-00',
                    'password'  => bcrypt($row['e_mail']),
                    'created_at' => new DateTime('now')
                ]);

                $newUser->save();
                $newUser->syncRoles('Usuário');
                $user = $newUser;

                $newResident = Resident::create([
                    'user_id' => $user->id,
                    'apartment_id' => $apartment->id,
                    'status' => 'Ativo',
                    'editor' => Auth::user()->id,
                    'created_at' => new DateTime('now')
                ]);
                $newResident->save();
            }
        } else {
            $userCheck->restore();
            $userCheck->email = $row['e_mail'];
            $userCheck->update();
        }
    }
}
