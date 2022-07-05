<?php

namespace App\Imports;

use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Resident;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ResidentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $complex = Complex::where('alias_name', $row['condominio'])->first();
        $blocks = Block::where('complex_id', $complex->id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->get();
        foreach ($apartments as $ap) {
            $email = Str::slug($ap->complex_name . $ap->block_name . $ap->name) . '@acquax.com.br';
            $user = User::where('email', $email)->first();
            if (empty($user->id)) {
                $newUser = User::create([
                    'name'      => $ap->complex_name . '-' . $ap->block_name . '-' . $ap->name,
                    'email'     => $email,
                    'document_person' => '000.000.000-00',
                    'password'  => bcrypt($email),
                    'created_at' => new DateTime('now')
                ]);

                $newUser->save();
                $newUser->syncRoles('Usuário');
                $user = $newUser;
            }

            $resident  = Resident::where('user_id', $user->id)
                ->where('apartment_id', $ap->id)->first();
            if (empty($resident->id)) {
                $newResident = Resident::create([
                    'user_id' => $user->id,
                    'apartment_id' => $ap->id,
                    'status' => 'Ativo',
                    'editor' => Auth::user()->id,
                    'created_at' => new DateTime('now')
                ]);
                $newResident->save();
            }
        }
    }
}
