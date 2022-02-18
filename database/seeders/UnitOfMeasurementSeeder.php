<?php

namespace Database\Seeders;

use App\Models\UnitOfMeasurement;
use Illuminate\Database\Seeder;

class UnitOfMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitOfMeasurements = [
            'SET',
            'UN',
            'PK',
            'PACK',
            'PC',
            'KIT',
            'UNIT'
        ];

        foreach ($unitOfMeasurements as $uom) {
            UnitOfMeasurement::create([
                'uom' => $uom
            ]);
        }
    }
}
