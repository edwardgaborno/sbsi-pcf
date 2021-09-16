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

            'source_create',
            'source_store',
            'source_edit',
            'source_update',
            'source_show',
            'source_delete',
            'source_access',

            'approve_user',
            'enable_user',
            'disable_user',

            'psr_request_create',
            'psr_request_store',
            'psr_request_edit',
            'psr_request_update',
            'psr_request_show',
            'psr_request_delete',
            'psr_request_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',

            'view_quotation',
            'download_quotation',

            'psr_manager_approve_cf',
            'psr_manager_reject_cf',

            'marketing_approve_pcf',
            'marketing_reject_pcf',

            'accounting_approve_pcf',
            'accounting_reject_pcf',

            'national_sales_manager_approve_pcf',
            'national_sales_manager_reject_pcf',

            'cfo_approve_pcf',
            'cfo_reject_pcf',
            'cfo_approve_quotation',
            'cfo_manager_quotation',

            'sales_asst_approve_pcf',
            'sales_asst_reject_pcf',
            'sales_asst_approve_quotation',
            'sales_asst_reject_quotation',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $psrRole = Role::create(['name' => 'PSR']);
        $psrRole->givePermissionTo([
            'psr_request_create',
            'psr_request_store',
            'psr_request_edit',
            'psr_request_update',
            'psr_request_show',
            'psr_request_delete',
            'psr_request_access',
            'download_pcf',
            'upload_pcf',
            'source_access',
        ]);

        $psrMgrRole = Role::create(['name' => 'PSR Manager']);
        $psrMgrRole->givePermissionTo([
            'psr_request_access',
            'psr_manager_approve_cf',
            'psr_manager_reject_cf',
        ]);

        $mkt_mgrRole = Role::create(['name' => 'Marketing']);
        $mkt_mgrRole->givePermissionTo([
            'psr_request_access',
            'view_pcf',
            'marketing_approve_pcf',
            'marketing_reject_pcf',
        ]);

        $acctRole = Role::create(['name' => 'Accounting']);
        $acctRole->givePermissionTo([
            'psr_request_access',
            'view_pcf',
            'accounting_approve_pcf',
            'accounting_reject_pcf',
        ]);

        $nsmRole = Role::create(['name' => 'National Sales Manager']);
        $nsmRole->givePermissionTo([
            'psr_request_access',
            'view_pcf',
            'download_pcf',
            'download_pcf',
            'view_quotation',
            'download_quotation',
            'national_sales_manager_approve_pcf',
            'national_sales_manager_reject_pcf',
        ]);

        $cfoRole = Role::create(['name' => 'Chief Finance Officer']);
        $cfoRole->givePermissionTo([
            'psr_request_access',
            'view_pcf',
            'download_pcf',
            'view_quotation',
            'download_quotation',
            'cfo_approve_pcf',
            'cfo_reject_pcf',
            'cfo_approve_quotation',
            'cfo_manager_quotation',
        ]);

        $cfoRole = Role::create(['name' => 'Sales Assistant']);
        $cfoRole->givePermissionTo([
            'psr_request_access',
            'view_pcf',
            'download_pcf',
            'view_quotation',
            'download_quotation',
            'sales_asst_approve_pcf',
            'sales_asst_reject_pcf',
            'sales_asst_approve_quotation',
            'sales_asst_reject_quotation',
        ]);

        $adminRole = Role::create(['name' => 'Administrator']);
        $adminRole->givePermissionTo([
            'psr_request_create',
            'psr_request_store',
            'psr_request_edit',
            'psr_request_update',
            'psr_request_show',
            'psr_request_delete',
            'psr_request_access',
            'download_pcf',
            'upload_pcf',
            'source_create',
            'source_store',
            'source_edit',
            'source_update',
            'source_show',
            'source_delete',
            'source_access',
        ]);

        Role::create(['name' => 'Super Administrator']);
    }
}
