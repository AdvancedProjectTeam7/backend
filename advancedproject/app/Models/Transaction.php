<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function category(){
        return $this->belongTo(Category::class);
    }

    public function recurring(){
        return $this->belongTo(Recurring::class);
    }
}
