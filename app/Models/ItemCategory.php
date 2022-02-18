<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profitabilityPercentage() 
    {
        return $this->hasOne(ProfitabilityPercentage::class);
    }

}
