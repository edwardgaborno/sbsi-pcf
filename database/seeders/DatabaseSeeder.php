<?php

namespace Database\Seeders;

use App\Models\Segment;
use App\Models\Supplier;
use App\Models\UnitOfMeasurement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RolesAndPermissionSeeder::class,
            UserSeeder::class,
            ItemCategorySeeder::class,
            MandatoryPeripheralsCategorySeeder::class,
            SegmentSeeder::class,
            UnitOfMeasurementSeeder::class,
            SupplierSeeder::class,
        ]);
    }
}
