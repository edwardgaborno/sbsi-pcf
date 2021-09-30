<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\DB;

class PCFRequest extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    public function path()
    {
        return url($this->getFirstMediaUrl('pcf_request_file'));
    }

    public function pcfList() 
    {
        return $this->belongsTo(PCFList::class);
    }

    public function pcfInclusion() 
    {
        return $this->belongsTo(PCFInclusion::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function countDistinct($value)
    {
        $counts = DB::table('p_c_f_lists')
                ->select(DB::raw('COUNT(DISTINCT above_standard_price) AS totalDistinct'))
                ->where('p_c_f_request_id', $value)
                ->get();
        
        foreach($counts as $count) {
            return $count->totalDistinct;
        }   
    }

    public function checkColumnValue($value)
    {
        $data = PCFList::select('above_standard_price')->where('p_c_f_request_id', $value)->get();

        foreach($data as $datum) {
            return $datum->above_standard_price;
        }
    }
}
