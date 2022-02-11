<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandatoryPeripheral extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mandatoryPeripheralCategories()
    {
        return $this->hasOne(MandatoryPeripheralCategory::class, 'id', 'peripherals_category_id');
    }

}
