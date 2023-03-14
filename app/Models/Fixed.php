<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixed extends Model
{
    use HasFactory;

    protected $fillable =[
        'type',
        'title',
        'amount',
        'isDeleted',
        'endDate',
        'category',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }



}
