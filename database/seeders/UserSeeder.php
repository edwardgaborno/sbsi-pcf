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
        //
        User::create([
            'name' => 'Ardison Pagulayan',
            'email' => 'ardi.pagulayan@sbsi.com.ph',
            'username' => 'ardi.pagulayan@sbsi.com.ph',
            'password' => \Hash::make('admin'),
            'user_type' => 'administrator',
            'email_verified_at' => Carbon::now()
        ]);
    }
}
