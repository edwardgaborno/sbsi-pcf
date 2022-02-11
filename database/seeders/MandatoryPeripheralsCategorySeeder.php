<?php

namespace Database\Seeders;

use App\Models\MandatoryPeripheralCategory;
use Illuminate\Database\Seeder;

class MandatoryPeripheralsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mpCategories = [
            'CLONED',
            'BRANDED',
            '625VA',
            '1KVA',
            '1.5KVA',
            '2KVA',
            '2.2KVA'
        ];

        foreach ($mpCategories as $mpCategory) {
            MandatoryPeripheralCategory::create([
                'mp_category' => $mpCategory
            ]);
        }
    }
}
