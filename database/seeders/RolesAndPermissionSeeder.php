<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'user_management_access',
            'permission_create',
            'permission_edit',
            'permission_show',
            'permission_delete',
            'permission_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'role_access',
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access',
            'approve_user',
            'enable_user',
            'disable_user',
            'psr_create',
            'psr_edit',
            'psr_show',
            'psr_delete',
            'psr_access',
            'psr_download_pcf',
            'psr_upload_pcf',
            'psr_view_pcf',
            'source_create',
            'source_edit',
            'source_show',
            'source_delete',
            'source_access',
            // 'accounting_create',
            // 'accounting_edit',
            // 'accounting_show',
            // 'accounting_delete',
            'accounting_access',
            'accounting_approve_pcf',
            'accounting_reject_pcf',
            // 'accounting_manager_create',
            // 'accounting_manager_edit',
            // 'accounting_manager_show',
            // 'accounting_manager_delete',
            'accounting_manager_access',
            'accounting_manager_approve_pcf',
            'accounting_manager_reject_pcf',
            // 'national_sales_manager_create',
            // 'national_sales_manager_edit',
            // 'national_sales_manager_show',
            // 'national_sales_manager_delete',
            'national_sales_manager_access',
            'national_sales_manager_approve_pcf',
            'national_sales_manager_reject_pcf',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $psrRole = Role::create(['name' => 'PSR']);
        $psrRole->givePermissionTo([
            'psr_create',
            'psr_edit',
            'psr_show',
            'psr_delete',
            'psr_access',
            'psr_download_pcf',
            'psr_upload_pcf',
        ]);

        $acctRole = Role::create(['name' => 'Accounting']);
        $acctRole->givePermissionTo([
            'psr_access',
            'psr_view_pcf',
            'accounting_access',
            'accounting_approve_pcf',
            'accounting_reject_pcf',
        ]);

        $acct_mgrRole = Role::create(['name' => 'Accounting Manager']);
        $acct_mgrRole->givePermissionTo([
            'psr_access',
            'psr_view_pcf',
            'accounting_manager_access',
            'accounting_manager_approve_pcf',
            'accounting_manager_reject_pcf',
        ]);

        $nsmRole = Role::create(['name' => 'National Sales Manager']);
        $nsmRole->givePermissionTo([
            'psr_access',
            'psr_view_pcf',
            'national_sales_manager_access',
            'national_sales_manager_approve_pcf',
            'national_sales_manager_reject_pcf',
        ]);

        $userRole = Role::create(['name' => 'User']);
        $userRole->givePermissionTo([
            'source_create',
            'source_edit',
            'source_show',
            'source_delete',
            'source_access',
        ]);

        $adminRole = Role::create(['name' => 'Administrator']);
        // remove permission::all() if administrator won't access all the permissions;
        $adminRole->givePermissionTo(Permission::all());

        Role::create(['name' => 'Super Administrator']);
    }
}
