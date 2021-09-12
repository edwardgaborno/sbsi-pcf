<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create array of arrays
        $roles = [
            ['name' => 'psr'],
            ['name' => 'nsm'],
            ['name' => 'accounting'],
            ['name' => 'accounting manager'],
            ['name' => 'administrator'],
        ]; 

        //create method only accept single array so you have to looop the first array 
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
