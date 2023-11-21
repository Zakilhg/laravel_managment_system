<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

//    public function vents()
//    {
//        return $this->hasMany(Vent::class);
//    }
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
