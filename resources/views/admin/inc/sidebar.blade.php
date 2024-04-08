<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .main-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 250px;
        background-color: #2d4059;
    }

    .brand-link {
        background-color: #1f2a3a;
        text-decoration: none;
        /* font-weight: bold; */
        height: 63px;
    }

    .brand-text {
        margin-left: 10px;
        font-size: 20px;
        color: #007bff;

    }

    .sidebar {
        padding-top: 15px;
    }


    .nav-sidebar .nav-link {
        color: #ffffff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-sidebar .nav-link:hover {
        background-color: #3d526f;
    }

    .nav-sidebar .nav-treeview {
        padding-left: 15px;
    }

    .nav-sidebar .nav-treeview .nav-link {
        padding-left: 20px;
        color: #ffffff;
    }

    .nav-sidebar .nav-treeview .nav-link:hover {
        background-color: #3d526f;
    }

    .nav-sidebar .nav-header {
        color: #ffffff;
        padding: 10px 15px;
    }

    .nav-sidebar .active .nav-link {
        background-color: #3d526f;
    }

    .d-block {
        font-size: 20px;
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ asset('/') }}index3.html" class="brand-link">
        <img src="{{ asset('/') }}dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text ">Master Payroll</span>
    </a>

    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/') }}dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                {{-- <a href="#" class="d-block">{{ auth()->user()->name }}</a> --}}

                @auth
                    <a class="d-block">{{ auth()->user()->name }}</a>
                @endauth
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->


                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="bi bi-fingerprint"></i>
                        <p>
                            Roles & permissions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('permissions.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>permissions</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>users</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">EXAMPLES</li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.instances') }}"
                        class="nav-link @if (Request::segment(2) == 'instances') active @endif">
                        <i class="bi bi-globe2"></i>
                        <p>
                            Instances

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.elements') }}"
                        class="nav-link @if (Request::segment(2) == 'elements') active @endif">
                        <i class="bi bi-globe2"></i>
                        <p>
                            Elements
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.reports') }}"
                        class="nav-link @if (Request::segment(2) == 'reports') active @endif">
                        <i class="bi bi-globe2"></i>
                        <p>
                            Reports
                        </p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
