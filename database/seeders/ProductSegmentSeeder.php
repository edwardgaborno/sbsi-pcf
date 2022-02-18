<?php

namespace Database\Seeders;

use App\Models\ProductSegment;
use Illuminate\Database\Seeder;

class ProductSegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productSegments = [
            'SBU1',
            'SBU2',
            'SBU3',
            'SBU4',
            'SBU5',
        ];

        foreach ($productSegments as $productSegment) {
            ProductSegment::create([
                'product_segment' => $productSegment,
            ]);
        }
    }
}
