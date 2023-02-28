<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
      //  'isDeleted',
     //   'isSuper',
    ];

    public function profitgoal(){
        return $this->hasOne(Profitgoal::class);
    }

    public function fixed(){
        return $this->hasMany(Fixed::class);
    }

    public function recurring(){
        return $this->hasMany(Recurring::class);
    }

}
