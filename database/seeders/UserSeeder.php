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
        //Administrator User
        $super_admin = User::create([
            'name' => 'Ardison Pagulayan',
            'email' => 'ardi.pagulayan@sbsi.com.ph',
            'password' => Hash::make('admin'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 4,
            'email_verified_at' => Carbon::now()
        ]);
        $super_admin->assignRole('Super Administrator');
        
        //SALES 
        $psr = User::create([
            'name' => 'PSR',
            'email' => 'psr@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
            'email_verified_at' => Carbon::now()
        ]);
        $psr->assignRole('PSR');

        $psr_mgr = User::create([
            'name' => 'PSR Manager',
            'email' => 'psr.manager@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
            'email_verified_at' => Carbon::now()
        ]);
        $psr_mgr->assignRole('PSR Manager');

        $nsm = User::create([
            'name' => 'National Sales Manager',
            'email' => 'nsm@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
            'email_verified_at' => Carbon::now()
        ]);
        $nsm->assignRole('National Sales Manager');

        $sales_asst = User::create([
            'name' => 'Sales Assistant',
            'email' => 'sales.assistant@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
            'email_verified_at' => Carbon::now()
        ]);

        $sales_asst->assignRole('Sales Assistant');

        //Marketing
        $mktg = User::create([
            'name' => 'Marketing1',
            'email' => 'marketing1@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 2,
            'email_verified_at' => Carbon::now()
        ]);
        $mktg->assignRole('Marketing');

        $mktg = User::create([
            'name' => 'Marketing2',
            'email' => 'marketing2@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 2,
            'email_verified_at' => Carbon::now()
        ]);

        $mktg->assignRole('Marketing');

        //Accounting
        $acct = User::create([
            'name' => 'Accounting1',
            'email' => 'accounting1@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 3,
            'email_verified_at' => Carbon::now()
        ]);

        $acct->assignRole('Accounting');

        $acct = User::create([
            'name' => 'Accounting2',
            'email' => 'accounting2@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 3,
            'email_verified_at' => Carbon::now()
        ]);
        $acct->assignRole('Accounting');

        $cfo = User::create([
            'name' => 'Chief Finance Officer',
            'email' => 'cfo@email.com',
            'password' => Hash::make('12345'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 3,
            'email_verified_at' => Carbon::now()
        ]);
        $cfo->assignRole('Chief Finance Officer');
    }
}
