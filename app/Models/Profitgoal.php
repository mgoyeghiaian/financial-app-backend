<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profitgoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'netprofit',
        'isdeleted'
    ];

    public function admin(){
        return $this->belongsToMany(Admin::class);
    }

}
