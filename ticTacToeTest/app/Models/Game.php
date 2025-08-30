<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

protected $fillable = [
'board','current_player','status','winner','started_at','finished_at'
];


protected $casts = [
'started_at' => 'datetime',
'finished_at' => 'datetime',
];


public function isFinished(): bool
{
return $this->status !== 'IN_PROGRESS';
}


public function boardArray(): array
{
return str_split($this->board);
}

 public function getCleanStatusAttribute(): string
{
    return match ($this->status) {
        'DRAW'        => 'Match nul',
        'X_WON'       => 'Joueur X a gagné',
        'O_WON'       => 'Joueur O a gagné',
        default       => ucfirst(strtolower($this->status)),
    };
}
}

