<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'mandatory_peripherals_ids' => 'array'
    ];

    public function pcfLists() 
    {
        return $this->hasMany(PCFList::class);
    }

    public function pcfInclusions() 
    {
        return $this->hasMany(PCFInclusion::class);
    }

    public function itemCategories()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id', 'id');
    }

    public function segments()
    {
        return $this->belongsTo(Segment::class, 'segment_id', 'id');
    }

    public function unitOfMeasurements()
    {
        return $this->belongsTo(UnitOfMeasurement::class, 'uom_id', 'id');
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function sourceMandatoryPeripherals() { 
        return $this->hasMany(SourceMandatoryPeripheral::class, 'source_id', 'id');
    }
}
