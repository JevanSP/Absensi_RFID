<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudayaPositif extends Model
{
    protected $table = 'budaya_positif';

    protected $fillable = [
        'budaya_positif',
        'poin',
    ];
}
