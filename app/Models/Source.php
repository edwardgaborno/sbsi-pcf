<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $guarded = [];

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
        return $this->belongsTo(ItemCategory::class, 'id', 'item_category_id');
    }

    public function segments()
    {
        return $this->belongsTo(Segments::class, 'id', 'segment_id');
    }

    public function unitOfMeasurements()
    {
        return $this->belongsTo(UnitOfMeasurement::class, 'id', 'uom_id');
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'id', 'supplier_id');
    }

    public function sourceMandatoryPeripherals() { 
        return $this->hasMany(SourceMandatoryPeripheral::class, 'source_id', 'id');
    }
}
