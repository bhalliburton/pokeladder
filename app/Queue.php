<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Match;

class Queue extends Model
{
    use HasFactory;

    public function match()
    {
        return $this->belongsTo(Match::class);
    }

}
