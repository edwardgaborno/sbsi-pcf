<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            'password' => Hash::make('admin'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        //create default user permission
        $user->assignRole('Super Administrator');
        //permissions will be set on authservice provider Boot function

        //for testing purposes accts;
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'test0@user.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        $admin->assignRole('Administrator');

        //for testing purposes accts;
        $admin = User::create([
            'name' => 'PSR',
            'email' => 'test1@user.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        $admin->assignRole('PSR');

        //for testing purposes accts;
        $psr_mgr = User::create([
            'name' => 'PSR Manager',
            'email' => 'test2@user.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        $psr_mgr->assignRole('PSR Manager');

        //for testing purposes accts;
        $mktg = User::create([
            'name' => 'Marketing',
            'email' => 'test3@user.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        $mktg->assignRole('Marketing');

        //for testing purposes accts;
        $acct = User::create([
            'name' => 'Accounting',
            'email' => 'test4@user.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        $acct->assignRole('Accounting');

        //for testing purposes accts;
        $nsm = User::create([
            'name' => 'National Sales Manager',
            'email' => 'test5@user.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        $nsm->assignRole('National Sales Manager');

        //for testing purposes accts;
        $cfo = User::create([
            'name' => 'Chief Finance Officer',
            'email' => 'test6@user.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        $cfo->assignRole('Chief Finance Officer');

        //for testing purposes accts;
        $sales_asst = User::create([
            'name' => 'Sales Assistant',
            'email' => 'test7@user.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'email_verified_at' => Carbon::now()
        ]);

        $sales_asst->assignRole('Sales Assistant');
    }
}
