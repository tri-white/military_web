<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Proposition;
use App\Models\PostAsk;
use App\Models\PostBid;
use App\Models\PostMoney;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Billable, Notifiable;
    public function propositions()
    {
        return $this->hasMany(Proposition::class);
    }

    public function postAsks()
    {
        return $this->hasMany(PostAsk::class);
    }

    public function postBids()
    {
        return $this->hasMany(PostBid::class);
    }

    public function postMoneys()
    {
        return $this->hasMany(PostMoney::class);
    }
   
}
