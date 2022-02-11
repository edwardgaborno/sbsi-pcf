<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitabilityPercentage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id', 'id');
    }
}
