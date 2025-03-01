<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fpgrowth extends Model
{
    protected $table = 'fpgrowths';

    protected $fillable = [
        'support',
        'confidance',
    ];
}
