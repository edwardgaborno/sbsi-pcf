<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceMandatoryPeripheral extends Model
{
    use HasFactory;

    public function mandatoryPeripherals()
    {
        return $this->belongsTo(MandatoryPeripheral::class, 'mandatory_peripheral_id', 'id');
    }
}
