<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use App\Models\ProfitabilityPercentage;
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
            'MACHINES',
            'PIPETORS',
            'SPAREPARTS',
            'REAGENTS',
            'OTHERS'
        ];
        foreach ($itemCategories as $itemCategory) {
            $saveItemCategory = ItemCategory::create([
                'category_name' => $itemCategory
            ]);
            ProfitabilityPercentage::create([
                'item_category_id' => $saveItemCategory->id,
                'percentage' => ($itemCategory == 'MACHINES' ? '30.00' : '50.00')
            ]);
        }
    }
}
