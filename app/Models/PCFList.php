<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCFList extends Model
{
    use HasFactory;

    protected $fillable = [
        'pcf_no',
        'item_code',
        'description',
        'quantity',
        'sales',
        'total_sales'
    ];
}
