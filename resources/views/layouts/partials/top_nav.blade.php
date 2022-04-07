<div class="container-fluid">
    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

        <div class="collapse navbar-collapse" id="topnav-menu-content">
            <ul class="navbar-nav">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle arrow-none" href="{{ route('dashboard') }}"
                        id="topnav-dashboard" role="button">
                        <i data-feather="home"></i><span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle arrow-none" href="{{ route('sales') }}" id="topnav-dashboard"
                        role="button">
                        <i data-feather="shopping-cart"></i><span data-key="t-sales">Penjualan</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle arrow-none" href="{{ route('sales.list') }}" id="topnav-dashboard"
                        role="button">
                        <i data-feather="shopping-bag"></i><span data-key="t-sale-lists">Daftar Penjualan</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                        <i data-feather="file-text"></i><span data-key="t-reports">Laporan</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle arrow-none" href="{{ route('users') }}" id="topnav-dashboard"
                        role="button">
                        <i data-feather="user"></i><span data-key="t-user">User</span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
</div>
