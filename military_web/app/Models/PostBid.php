<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bid;

class PostBid extends Model
{
    use HasFactory;
    protected $table = "post_bid";
    protected $casts = [
        'expiration_datetime' => 'datetime', // This will cast the attribute to a Carbon instance
    ];
    public function bids()
    {
        return $this->hasMany(Bid::class, 'post_id');
    }
}
