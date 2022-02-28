<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img class="" src="{{ asset('img/sbsi-logo.png') }}" alt="SBSI Logo" width="90px;">
        </div>
        {{-- <div class="sidebar-brand-text mx-3">PCF Monitoring</div> --}}
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - PCF Request Menu -->
    @can('pcf_request_access')
    <li class="nav-item">
        <a href="#" class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage_pcf_request" aria-expanded="true"
        aria-controls="managePcfRequest">
            <i class="fas fa-file-contract"></i>
            <span>PCF Request</span>
        </a>
        <div id="manage_pcf_request" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('PCF.index') }}">Processing</a>
            </div>
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('PCF.completed_list_index') }}">Completed</a>
            </div>
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('PCF.cancelled_list_index') }}">Cancelled</a>
            </div>
        </div>
    </li>
    @endcan
    @can('user_management_access')
        <!-- Nav Item - Setting user management Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage_users" aria-expanded="true"
                aria-controls="manageUsers">
                <i class="fas fa-users"></i>
                <span>Manage Users</span>
            </a>
            <div id="manage_users" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('users.index') }}">Users</a>
                </div>
                {{-- <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="#">Roles</a>
                </div>
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="#">Permissions</a>
                </div> --}}
            </div>
        </li>
    @endcan
    @can('business_partner_access')
        <!-- Nav Item - Setting user management Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#business_partner" aria-expanded="true"
                aria-controls="manageUsers">
                <i class="fas fa-industry"></i>
                <span>Business Partner</span>
            </a>
            <div id="business_partner" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                @can('supplier_access')
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('business_partners.supplier.index') }}">Supplier</a>
                    </div>
                @endcan
                @can('institution_access')
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('settings.institution.index') }}">Institution</a>
                    </div>
                @endcan
                {{-- <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="#">Roles</a>
                </div>
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="#">Permissions</a>
                </div> --}}
            </div>
        </li>
    @endcan
    <!-- Nav Item - Setting Source Menu -->
    @can('settings_access')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settings" aria-expanded="true"
                aria-controls="settings">
                <i class="fas fa-cogs"></i>
                <span>Settings</span>
            </a>
            <div id="settings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                @can('source_access')
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('settings.source.index') }}">Source</a>
                    </div>
                @endcan
                {{-- @can('department_access')
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('settings.department.index') }}">Department</a>
                    </div>
                @endcan --}}
                @can('price_management_access')
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('settings.profitability_percentage.index') }}">Profitability Percentage</a>
                    </div>
                @endcan
                @can('mandatory_peripherals_access')
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('settings.mandatory_peripheral.index') }}">Mandatory Peripheral</a>
                    </div>
                @endcan
            </div>
        </li>
    @endcan
</ul>
<!-- End of Sidebar -->
