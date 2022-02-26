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
            'name' => 'Super Admin',
            'email' => 'admin.admin@sbsi.com.ph',
            'password' => Hash::make('admin'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 4,
            'email_verified_at' => Carbon::now()
        ]);
        $super_admin->assignRole('Super Administrator');

        #########################################
        #       SALES                           #
        #########################################
        //NSM
        $nsm = User::create([
            'name' => 'Iryne De Leon',
            'email' => 'iryne.deleon@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
        ]);
        $nsm->assignRole('National Sales Manager');

        //RSM
        $rsm = User::create([
            'name' => 'Rachell Sy',
            'email' => 'rachell.sy@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
        ]);
        $rsm->assignRole('Regional Sales Manager');

        $rsm = User::create([
            'name' => 'Gloria Cutang',
            'email' => 'gloria.cutang@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
        ]);
        $rsm->assignRole('Regional Sales Manager');

        $rsm = User::create([
            'name' => 'Gilbert Gravata',
            'email' => 'gilbert.gravata@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
        ]);
        $rsm->assignRole('Regional Sales Manager');

        $asm = User::create([
            'name' => 'Irene Ueginio',
            'email' => 'irene.ueginio@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
        ]);
        $asm->assignRole('Area Sales Manager');

        $asm = User::create([
            'name' => 'Erwin Repollo',
            'email' => 'erwin.repollo@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
        ]);
        $asm->assignRole('Area Sales Manager');

        $asm = User::create([
            'name' => 'Donna Cuyno',
            'email' => 'donna.cuyno@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
        ]);
        $asm->assignRole('Area Sales Manager');

        //PSR
        $psr = User::create([
            'name' => 'Ardison Pagulayan',
            'email' => 'ardi.pagulayan@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
            'email_verified_at' => Carbon::now()
        ]);
        $psr->assignRole('PSR');

        $psr = User::create([
            'name' => 'Edward Gaborno',
            'email' => 'edward.gaborno@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
            'email_verified_at' => Carbon::now()
        ]);
        $psr->assignRole('PSR');

        $psr = User::create([
            'name' => 'John Andrew',
            'email' => 'john.andrew@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 1,
            'email_verified_at' => Carbon::now()
        ]);
        $psr->assignRole('PSR');

        ############################################## 
        #       MARKETING                            #
        ##############################################
        //APM
        $apm = User::create([
            'name' => 'Allan Anaen',
            'email' => 'allan.anaen@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 2,
            'email_verified_at' => Carbon::now()
        ]);
        $apm->assignRole('Associate Product Manager');

        $apm = User::create([
            'name' => 'Kent',
            'email' => 'kent@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 2,
            'email_verified_at' => Carbon::now()
        ]);
        $apm->assignRole('Associate Product Manager');

        $apm = User::create([
            'name' => 'Allado',
            'email' => 'allado@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 2,
            'email_verified_at' => Carbon::now()
        ]);
        $apm->assignRole('Associate Product Manager');

        $apm = User::create([
            'name' => 'Dyne',
            'email' => 'dyne@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 2,
            'email_verified_at' => Carbon::now()
        ]);
        $apm->assignRole('Associate Product Manager');

        $apm = User::create([
            'name' => 'Maricar',
            'email' => 'maricar@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 2,
            'email_verified_at' => Carbon::now()
        ]);
        $apm->assignRole('Associate Product Manager');

        #########################################
        #       ACCOUNTING                      #
        #########################################

        $apm = User::create([
            'name' => 'Annie',
            'email' => 'annie@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 3,
            'email_verified_at' => Carbon::now()
        ]);
        $apm->assignRole('Accounting Team Leader');

        $apm = User::create([
            'name' => 'Jade',
            'email' => 'jade@sbsi.com.ph',
            'password' => Hash::make('123'),
            'is_approved' => true,
            'status' => true,
            'department_id' => 3,
            'email_verified_at' => Carbon::now()
        ]);
        $apm->assignRole('Accounting Manager');
    }
}
