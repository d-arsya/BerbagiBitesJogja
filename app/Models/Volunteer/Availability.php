<?php

namespace App\Models\Volunteer;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
