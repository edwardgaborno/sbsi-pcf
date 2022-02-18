<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCFList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function source() 
    {
        return $this->belongsTo(Source::class);
    }

    public function pcfRequests() 
    {
        return $this->hasMany(PCFRequest::class);
    }

    public function sources()
    {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }
}
