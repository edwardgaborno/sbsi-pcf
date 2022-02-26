<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCFRequestMandatoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'mandatory_peripheral_id',
        'item_id',
        'pcf_request_id',
        'pcf_no'
    ];

    public function mandatoryPeripheral()
    {
        return $this->belongsTo(MandatoryPeripheral::class, 'mandatory_peripheral_id', 'id');
    }

    public function pcfListItems()
    {
        return $this->belongsTo(PCFList::class, 'item_id', 'id');
    }
}
