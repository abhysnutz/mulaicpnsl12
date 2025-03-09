<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/backend/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Console</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/backend/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
        
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('console.dashboard') }}" class="nav-link {{ Request::is('console/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('console.user.index') }}" class="nav-link {{ Request::is('console/user*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('console.payment.index') }}" class="nav-link {{ Request::is('console/payment*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cash-coin"></i>
                        <p>Payment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('console.tryout.index') }}" class="nav-link {{ Request::is('console/tryout*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-solid fa-book"></i>
                        <p>Tryout</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../calendar.html" class="nav-link">
                      <i class="nav-icon far fa-calendar-alt"></i>
                      <p>
                        Calendar
                        <span class="badge badge-info right">2</span>
                      </p>
                    </a>
                  </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
{{-- 
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="../index.html" class="brand-link">
            <img src="{{ asset('assets/backend/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">AdminLTE 4</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('console.dashboard') }}" class="nav-link {{ Request::is('console/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-house"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('console.user.index') }}" class="nav-link {{ Request::is('console/user*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('console.payment.index') }}" class="nav-link {{ Request::is('console/payment*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cash-coin"></i>
                        <p>Payment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('console.tryout.index') }}" class="nav-link {{ Request::is('console/tryout*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Tryout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside> --}}