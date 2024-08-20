<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function serviceImages()
    {
        return $this->hasMany(ServiceImage::class,'services_id');
    }
}
