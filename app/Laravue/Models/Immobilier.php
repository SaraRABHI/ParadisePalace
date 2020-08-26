<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Immobilier extends Model
{
    protected $fillable = [
        'title',
        'nameOwner',
        'emailOwner',
        'adresse',
        'description',
    ];
}
