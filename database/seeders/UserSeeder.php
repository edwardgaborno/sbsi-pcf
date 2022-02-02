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
        $super_admin = User::create([
            'name' => 'Ardison Pagulayan',
            'email' => 'ardi.pagulayan@sbsi.com.ph',
            'password' => Hash::make('admin'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Admin',
            'email_verified_at' => Carbon::now()
        ]);

        //create default user permission
        $super_admin->assignRole('Super Administrator');
        //permissions will be set on authservice provider Boot function

        //for testing purposes accts;
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Admin',
            'email_verified_at' => Carbon::now()
        ]);

        $admin->assignRole('Administrator');

        //for testing purposes accts;
        $psr = User::create([
            'name' => 'PSR',
            'email' => 'psr@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Sales',
            'email_verified_at' => Carbon::now()
        ]);

        $psr->assignRole('PSR');

        //for testing purposes accts;
        $psr_mgr = User::create([
            'name' => 'PSR Manager',
            'email' => 'psr.manager@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Sales',
            'email_verified_at' => Carbon::now()
        ]);

        $psr_mgr->assignRole('PSR Manager');

        //for testing purposes accts;
        $mktg = User::create([
            'name' => 'Marketing1',
            'email' => 'marketing1@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Marketing',
            'email_verified_at' => Carbon::now()
        ]);

        $mktg->assignRole('Marketing');

        $mktg = User::create([
            'name' => 'Marketing2',
            'email' => 'marketing2@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Marketing',
            'email_verified_at' => Carbon::now()
        ]);

        $mktg->assignRole('Marketing');

        //for testing purposes accts;
        $acct = User::create([
            'name' => 'Accounting1',
            'email' => 'accounting1@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Accounting',
            'email_verified_at' => Carbon::now()
        ]);

        $acct->assignRole('Accounting');

        $acct = User::create([
            'name' => 'Accounting2',
            'email' => 'accounting2@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Accounting',
            'email_verified_at' => Carbon::now()
        ]);

        $acct->assignRole('Accounting');

        //for testing purposes accts;
        $nsm = User::create([
            'name' => 'National Sales Manager',
            'email' => 'nsm@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Sales',
            'email_verified_at' => Carbon::now()
        ]);

        $nsm->assignRole('National Sales Manager');

        //for testing purposes accts;
        $cfo = User::create([
            'name' => 'Chief Finance Officer',
            'email' => 'cfo@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Finance',
            'email_verified_at' => Carbon::now()
        ]);

        $cfo->assignRole('Chief Finance Officer');

        //for testing purposes accts;
        $sales_asst = User::create([
            'name' => 'Sales Assistant',
            'email' => 'sales.assistant@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department' => 'Sales',
            'email_verified_at' => Carbon::now()
        ]);

        $sales_asst->assignRole('Sales Assistant');
    }
}
