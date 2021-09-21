<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'Processing',
            ],
            [
                'name' => 'PSR Manager approved',
            ],
            [
                'name' => 'PSR Manager disapproved',
            ],
            [
                'name' => 'Marketing approved',
            ],
            [
                'name' => 'Marketing disapproved',
            ],
            [
                'name' => 'Accounting approved',
            ],
            [
                'name' => 'Accounting disapproved',
            ],
            [
                'name' => 'National Sales Manager approve',
            ],
            [
                'name' => 'National Sales Manager disapprove',
            ],
            [
                'name' => 'Chief Finance Officer approve',
            ],
            [
                'name' => 'Chief Finance Officer disapprove',
            ],
            [
                'name' => 'Sales Assistant approve',
            ],
            [
                'name' => 'Sales Assistant disapprove',
            ],
            [
                'name' => 'For Review',
            ],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
