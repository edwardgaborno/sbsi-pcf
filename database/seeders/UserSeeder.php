<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create default user
        $user = User::create([
            'name' => 'Ardison Pagulayan',
            'email' => 'ardi.pagulayan@sbsi.com.ph',
            'password' => \Hash::make('admin'),
            'user_type' => 'administrator',
            'is_approve' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        //create default user permission
        $user->assignRole('administrator');
        //permissions will be set on authservice provider Boot function
    }
}
