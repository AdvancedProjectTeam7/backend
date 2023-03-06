<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['title', 'description', 'category_id', 'currency_id', "amount", "date", 'recurring_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function recurring()
    {
        return $this->belongsTo(Recurring::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
