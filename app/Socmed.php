<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socmed extends Model
{
    protected $guarded  = ['id'];

    public function account()
    {
        return $this->hasMany(Account::class);
    }
}
