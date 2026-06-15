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

                <li class="nav-item">
                    <a href="{{ route('console.user-activity.index') }}"
                        class="nav-link {{ Request::is('console/user-activity*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>User Activity</p>
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

                <!-- Penarikan Saldo -->
                <li class="nav-item">
                    <a href="{{ route('console.withdrawal.index') }}"
                       class="nav-link {{ Request::is('console/withdrawal*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            Penarikan Saldo
                            @php
                                $withdrawalPending = \App\Models\Withdrawal::where('status', 'pending')->count();
                            @endphp
                            @if ($withdrawalPending > 0)
                                <span class="badge badge-danger right">{{ $withdrawalPending }}</span>
                            @endif
                        </p>
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

                <li class="nav-item">
                    <a href="{{ route('console.tryout-source.index') }}"
                    class="nav-link {{ request()->routeIs('console.tryout-source.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>Tryout Source</p>
                    </a>
                </li>

                <!-- Question -->
                <li class="nav-item">
                    <a href="{{ route('console.question.index') }}"
                       class="nav-link {{ Request::is('console/question', 'console/question/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Question Bank</p>
                    </a>
                </li>

                <!-- Materi -->
                <li class="nav-item">
                    <a href="{{ route('console.material.index') }}"
                       class="nav-link {{ Request::is('console/material', 'console/material/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p>Materi</p>
                    </a>
                </li>

                <!-- Database Backup -->
                <li class="nav-item">
                    <a href="{{ route('console.backup.index') }}"
                    class="nav-link {{ Request::is('console/backup*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Database Backup</p>
                    </a>
                </li>

                <!-- Question Report -->
                <li class="nav-item">
                    <a href="{{ route('console.question-report.index') }}"
                    class="nav-link {{ Request::is('console/question-report*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-flag"></i>
                        <p>
                            Laporan Soal
                            @php
                                $reportBaru = \App\Models\QuestionReport::where('status', 'baru')->count();
                            @endphp
                            @if ($reportBaru > 0)
                                <span class="badge badge-danger right">{{ $reportBaru }}</span>
                            @endif
                        </p>
                    </a>
                </li>

                <!-- Komisi Referral -->
                <li class="nav-item">
                    <a href="{{ route('console.commission.index') }}"
                    class="nav-link {{ Request::is('console/commission*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>Komisi Referral</p>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a href="{{ route('console.setting.index') }}"
                    class="nav-link {{ Request::is('console/setting*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>