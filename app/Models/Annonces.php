<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonces extends Model
{
    protected $fillable = ['title', 'message', 'classes'];
}
