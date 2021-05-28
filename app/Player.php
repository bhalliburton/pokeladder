<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ptcgo_name', 'queue_format'
    ];

	protected $attributes = [
        'ptcgo_name' => 1500,
        'rating' => 1500,
        'rating_deviation' => 350,
        'rating_volatility' => 0.06,
        'temp_rating' => 1500,
        'queued' => 0,
        'queue_format' => 0,
        'queue_Bo' => 0,
        'gamed' => 0,
        'banned' => 0,
        'banned_comment' => ""
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
