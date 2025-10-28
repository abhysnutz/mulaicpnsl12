<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('console.dashboard.index') }}" class="brand-link">
        <img src="{{ asset('assets/backend/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Console</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/backend/img/user2-160x160.jpg') }}"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('console.dashboard.index') }}"
                       class="nav-link {{ Request::is('console/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- User -->
                <li class="nav-item">
                    <a href="{{ route('console.user.index') }}"
                       class="nav-link {{ Request::is('console/user*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User</p>
                    </a>
                </li>

                <!-- Payment -->
                <li class="nav-item">
                    <a href="{{ route('console.payment.index') }}"
                       class="nav-link {{ Request::is('console/payment*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>Payment</p>
                    </a>
                </li>

                <!-- Tryout -->
                <li class="nav-item">
                    <a href="{{ route('console.tryout.index') }}"
                       class="nav-link {{ Request::is('console/tryout*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Tryout</p>
                    </a>
                </li>

                <!-- Question -->
                <li class="nav-item">
                    <a href="{{ route('console.question.index') }}"
                       class="nav-link {{ Request::is('console/question*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Question Bank</p>
                    </a>
                </li>

                <!-- Calendar -->
                <li class="nav-item">
                    <a href="../calendar.html" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Calendar
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                </li>

                <!-- Settings (optional) -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
