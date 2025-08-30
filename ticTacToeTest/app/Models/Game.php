<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
      use HasFactory;

    protected $fillable = ['winner']; // On remplit uniquement la colonne 'winner'
}
