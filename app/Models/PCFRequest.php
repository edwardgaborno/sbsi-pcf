<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PCFRequest extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function path()
    {
        return url($this->getFirstMediaUrl('pcf_request_file'));
    }

    public function pcfLists() 
    {
        return $this->hasMany(PCFList::class);
    }

    public function pcfInclusions() 
    {
        return $this->hasMany(PCFInclusion::class);
    }
}
