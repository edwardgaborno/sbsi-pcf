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
            'pcf_source_access',
            'psr_download_pcf',
            'psr_view_pcf',
            'psr_upload_pcf',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

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

            'institution_access',
            'institution_create',
            'institution_store',
            'institution_edit',
            'institution_update',
            'institution_show',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $psrRole = Role::create(['name' => 'PSR']);
        $psrRole->givePermissionTo([
            'pcf_request_create',
            'pcf_request_delete',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_show',
            'pcf_request_access',
            'pcf_source_access',
            'psr_download_pcf',
            'psr_view_pcf',
            'psr_upload_pcf',
            'source_access',
            'view_pcf',
            'view_approved_pcf',
        ]);

        $psrMgrRole = Role::create(['name' => 'PSR Manager']);
        $psrMgrRole->givePermissionTo([
            'pcf_request_access',
            'pcf_request_store',
            'pcf_request_delete',
            'pcf_request_edit',
            'pcf_request_update',
            'view_pcf',
            'psr_mgr_approve_pcf',
            'psr_mgr_reject_pcf',
            'source_access',
        ]);

        $mkt_mgrRole = Role::create(['name' => 'Marketing']);
        $mkt_mgrRole->givePermissionTo([
            'pcf_request_access',
            'pcf_request_store',
            'pcf_request_delete',
            'pcf_request_edit',
            'pcf_request_update',
            'view_pcf',
            'mktg_approve_pcf',
            'mktg_reject_pcf',
            'source_access',
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
            'pcf_request_store',
            'pcf_request_delete',
            'pcf_request_edit',
            'pcf_request_update',
            'view_pcf',
            'download_pcf',
            'view_quotation',
            'download_quotation',
            'nsm_approve_pcf',
            'nsm_reject_pcf',
            'view_approved_pcf',
            'view_approved_quotation',
            'source_access',
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
            'view_approved_pcf',
            'view_approved_quotation',
        ]);

        $cfoRole = Role::create(['name' => 'Sales Assistant']);
        $cfoRole->givePermissionTo([
            'pcf_request_access',
            'view_pcf',
            'download_pcf',
            'view_quotation',
            'download_quotation',
            'view_approved_pcf',
            'view_approved_quotation',
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
            'pcf_source_access',
            'psr_view_pcf',
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
            'institution_access',
            'institution_create',
            'institution_store',
            'institution_edit',
            'institution_update',
            'institution_show',
        ]);

        Role::create(['name' => 'Super Administrator']);
    }
}
