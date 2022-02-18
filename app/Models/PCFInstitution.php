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

    public function addresses()
    {
        return $this->belongsToMany(PCFAddress::class, 'p_c_f_institution_addresses', 'institution_id', 'address_id')->withTimestamps();
    }
}
