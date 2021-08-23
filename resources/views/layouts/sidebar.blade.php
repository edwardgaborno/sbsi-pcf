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
    <li class="nav-item">
        <a class="nav-link" href="{{ route('PCF') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>PCF Request</span></a>
    </li>
    <!-- Nav Item - Setting Source Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-file-invoice"></i>
            <span>Settings</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('settings.source') }}">Source</a>
            </div>
        </div>
    </li>
</ul>
<!-- End of Sidebar -->
