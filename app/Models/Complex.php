<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complex extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'social_name',
        'alias_name',
        'document_company',
        'document_company_secondary',
        'email',
        'telephone',
        'cell',
        'zipcode',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
        'photo',
        'facebook',
        'instagram',
        'twitter',
        'user_id'
    ];

    /** Relationships */
}
