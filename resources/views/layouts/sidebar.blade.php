<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img class="ml-2" src="{{ asset('img/sbsi-logo.png') }}" alt="SBSI Logo" width="100px;">
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
    @can('psr_request_access')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('PCF.index') }}">
            <i class="fas fa-list"></i>
            <span>PCF Request</span></a>
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
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="#">Roles</a>
                </div>
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="#">Permissions</a>
                </div>
            </div>
        </li>
    @endcan
    <!-- Nav Item - Setting Source Menu -->
    @can('source_access')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settings" aria-expanded="true"
                aria-controls="settings">
                <i class="fas fa-cogs"></i>
                <span>Settings</span>
            </a>
            <div id="settings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('settings.source.index') }}">Source</a>
                </div>
            </div>
        </li>
    @endcan
</ul>
<!-- End of Sidebar -->
