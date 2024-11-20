<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function donation(){
        return $this->belongsTo(Donation::class,'donation','id')->first();
    }
    public function faculty(){
        return $this->belongsTo(Donation::class,'fakultas','id')->first();
    }
}
