<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Illuminate\Database\Seeder;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemCategories = [
            'ACCESSORIES',
            'CONSUMABLES',
            'MACHINE',
            'PIPETORS',
            'SPAREPARTS',
            'REAGENTS',
            'OTHERS'
        ];

        foreach ($itemCategories as $itemCategory) {
            ItemCategory::create([
                'category_name' => $itemCategory
            ]);
        }
    }
}
