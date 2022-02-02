<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCFInstitution extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pcfRequests()
    {
        $this->hasMany(PCFRequest::class);
    }
}
