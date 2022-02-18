<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Sales',
            'Marketing',
            'Accounting',
            'IT',
            'Service'
        ];

        foreach ($departments as $department) {
            Department::create([
                'department' => $department,
            ]);
        }
    }
}
