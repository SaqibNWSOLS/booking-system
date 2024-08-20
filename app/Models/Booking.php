<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function userDetail(){

        return $this->belongsTo(User::class,'users_id');
    }

     public function serviceDetail(){

        return $this->belongsTo(Service::class,'services_id');
    }
}
