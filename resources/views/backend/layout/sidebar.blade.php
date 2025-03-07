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
          </ul>
      </nav>
  </div>
</aside>