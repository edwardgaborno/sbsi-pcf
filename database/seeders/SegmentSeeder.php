<?php

namespace Database\Seeders;

use App\Models\Segment;
use Illuminate\Database\Seeder;

class SegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $segments = [
            'CHEM',
            'COAG',
            'HEMA',
            'HEMA AND CHEM',
            'IMMUNO',
            'INDUSTRIAL MICRO',
            'MOLECULAR',
            'SPECIAL LINES',
            'NONE',
        ];

        foreach ($segments as $segment) {
            Segment::create([
                'segment' => $segment
            ]);
        }
    }
}
