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

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_create',
            'institution_store',
            'institution_edit',
            'institution_update',
            'institution_show',

            'department_access',
            'department_create',
            'department_store',
            'department_edit',
            'department_update',
            'department_show',

            'price_management_access',
            'price_management_create',
            'price_management_store',
            'price_management_edit',
            'price_management_update',
            'price_management_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_store',
            'supplier_update',
            'supplier_edit',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_store',
            'mandatory_peripherals_edit',
            'mandatory_peripherals_update',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_store',
            'profitability_percentages_update',
            'profitability_percentages_show',
            'profitability_percentages_edit',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $superAdmin = Role::create(['name' => 'Super Administrator']);
        $superAdmin->givePermissionTo([
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
            'download_pcf',
            'view_pcf',
            'upload_pcf',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_create',
            'institution_store',
            'institution_edit',
            'institution_update',
            'institution_show',

            'department_access',
            'department_create',
            'department_store',
            'department_edit',
            'department_update',
            'department_show',

            'price_management_access',
            'price_management_create',
            'price_management_store',
            'price_management_edit',
            'price_management_update',
            'price_management_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_store',
            'supplier_update',
            'supplier_edit',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_store',
            'mandatory_peripherals_edit',
            'mandatory_peripherals_update',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_store',
            'profitability_percentages_update',
            'profitability_percentages_show',
            'profitability_percentages_edit',
        ]);

        $psrRole = Role::create(['name' => 'PSR']);
        $psrRole->givePermissionTo([
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $mkt_mgrRole = Role::create(['name' => 'Marketing']);
        $mkt_mgrRole->givePermissionTo([
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $acctRole = Role::create(['name' => 'Accounting']);
        $acctRole->givePermissionTo([
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $nsmRole = Role::create(['name' => 'National Sales Manager']);
        $nsmRole->givePermissionTo([
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $accountingTeamLeader = Role::create(['name' => 'Accounting Team Leader']);
        $accountingTeamLeader->givePermissionTo([
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $accountingManager = Role::create(['name' => 'Accounting Manager']);
        $accountingManager->givePermissionTo([
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);


        $cfoRole = Role::create(['name' => 'Chief Finance Officer']);
        $cfoRole->givePermissionTo([
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $salesAssistRole = Role::create(['name' => 'Sales Assistant']);
        $salesAssistRole->givePermissionTo([
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $apm = Role::create(['name' => 'Associate Product Manager']);
        $apm->givePermissionTo([
        
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $asr = Role::create(['name' => 'Area Sales Manager']);
        $asr->givePermissionTo([
        
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $ssr = Role::create(['name' => 'Senior Sales Representative']);
        $ssr->givePermissionTo([
        
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $rsm = Role::create(['name' => 'Regional Sales Manager']);
        $rsm->givePermissionTo([
        
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

        $fsem = Role::create(['name' => 'Field Service Eng. Manager']);
        $fsem->givePermissionTo([
        
            'user_show',
            'user_access',

            'source_create',
            'source_show',
            'source_access',

            'pcf_request_create',
            'pcf_request_store',
            'pcf_request_edit',
            'pcf_request_update',
            'pcf_request_show',
            'pcf_request_delete',
            'pcf_request_access',
            'pcf_source_access',

            'view_pcf',
            'download_pcf',
            'upload_pcf',
            'view_approved_pcf',

            'view_quotation',
            'download_quotation',
            'view_approved_quotation',

            'institution_access',
            'institution_show',

            'settings_access',
            'business_partner_access',

            'supplier_access',
            'supplier_show',

            'mandatory_peripherals_access',
            'mandatory_peripherals_show',

            'profitability_percentages_access',
            'profitability_percentages_show',
        ]);

    }
}
