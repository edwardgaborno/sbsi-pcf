<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PCFApprover extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pcfRequests() 
    {
        return $this->belongsTo(PCFRequest::class, 'id', 'p_c_f_request_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'done_by', 'id');
    }
}
