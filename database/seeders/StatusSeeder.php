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
                'name' => 'Approved by PSR Manager',
            ],
            [
                'name' => 'Approved by Marketing',
            ],
            [
                'name' => 'Approved by National Sales Manager',
            ],
            [
                'name' => 'Approved by Accounting',
            ],
            [
                'name' => 'Approved',
            ],
            [
                'name' => 'For revision',
            ],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
