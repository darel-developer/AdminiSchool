<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomChart extends Model
{
    protected $fillable = [
        'title', 'type', 'labels', 'datasets'
    ];
}
