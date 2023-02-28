<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profitgoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'netProfit',
        'isDeleted'
    ];

    public function admin(){
        return $this->belongsToMany(Admin::class);
    }

}
