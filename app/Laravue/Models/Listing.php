<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'title',
        'nameOwner',
        'emailOwner',
        'description',
    ];
}
