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

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',

            'view_quotation',
            'download_quotation',

            'psr_mgr_approve_pcf',
            'psr_mgr_reject_pcf',

            'mktg_approve_pcf',
            'mktg_reject_pcf',

            'acct_approve_pcf',
            'acct_reject_pcf',

            'nsm_approve_pcf',
            'nsm_reject_pcf',

            'cfo_approve_pcf',
            'cfo_reject_pcf',
            'cfo_approve_quotation',
            'cfo_reject_quotation',

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
            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'download_pcf',
            'upload_pcf',
            'view_pcf',
            'source_access',
        ]);

        $psrMgrRole = Role::create(['name' => 'PSR Manager']);
        $psrMgrRole->givePermissionTo([
            'pcf_request_access',
            'view_pcf',
            'psr_mgr_approve_pcf',
            'psr_mgr_reject_pcf',
        ]);

        $mkt_mgrRole = Role::create(['name' => 'Marketing']);
        $mkt_mgrRole->givePermissionTo([
            'pcf_request_access',
            'view_pcf',
            'mktg_approve_pcf',
            'mktg_reject_pcf',
        ]);

        $acctRole = Role::create(['name' => 'Accounting']);
        $acctRole->givePermissionTo([
            'pcf_request_access',
            'view_pcf',
            'acct_approve_pcf',
            'acct_reject_pcf',
        ]);

        $nsmRole = Role::create(['name' => 'National Sales Manager']);
        $nsmRole->givePermissionTo([
            'pcf_request_access',
            'view_pcf',
            'download_pcf',
            'view_quotation',
            'download_quotation',
            'nsm_approve_pcf',
            'nsm_reject_pcf',
        ]);

        $cfoRole = Role::create(['name' => 'Chief Finance Officer']);
        $cfoRole->givePermissionTo([
            'pcf_request_access',
            'view_pcf',
            'download_pcf',
            'view_quotation',
            'download_quotation',
            'cfo_approve_pcf',
            'cfo_reject_pcf',
            'cfo_approve_quotation',
            'cfo_reject_quotation',
        ]);

        $cfoRole = Role::create(['name' => 'Sales Assistant']);
        $cfoRole->givePermissionTo([
            'pcf_request_access',
            'view_pcf',
            'download_pcf',
            'view_quotation',
            'download_quotation',
        ]);

        $adminRole = Role::create(['name' => 'Administrator']);
        $adminRole->givePermissionTo([
            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'download_pcf',
            'upload_pcf',
            'view_pcf',
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
