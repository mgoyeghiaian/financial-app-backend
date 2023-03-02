<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurring extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'isdeleted',
        'title',
        'amount',
        'startdate',
        'enddate',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
