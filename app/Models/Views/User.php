<?php

namespace App\Models\Views;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $table = 'users_view';
}
