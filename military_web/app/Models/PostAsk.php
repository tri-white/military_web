<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAsk extends Model
{
    use HasFactory;
    protected $table = "post_ask";
    public function propositions()
    {
        return $this->hasMany(Proposition::class, 'post_ask_id');
    }
}
