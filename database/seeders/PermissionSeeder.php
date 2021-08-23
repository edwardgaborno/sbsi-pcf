<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create array of arrays
        $permissions = [
            ['name' => 'add'],
            ['name' => 'view'],
            ['name' => 'edit'],
            ['name' => 'update'],
            ['name' => 'delete'],
            ['name' => 'enable'],
            ['name' => 'disable'],
            ['name' => 'approve'],
            ['name' => 'disapprove'],
        ]; 

        //create method only accept single array so you have to looop the first array 
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
