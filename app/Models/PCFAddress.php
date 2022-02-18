<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCFAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function institution()
    {
        return $this->belongsToMany(PCFInstitution::class, 'p_c_f_institution_addresses', 'address_id', 'institution_id')->withTimestamps();
    }
}
