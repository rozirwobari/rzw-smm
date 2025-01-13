<div class="sidebar-brand">
    <a href="{{ route('panel') }}" class="brand-link">
        <div class="circle-container" style="width: 35px; height: 35px; border-radius: 0%;">
            <img src="{{ asset($website->logo) }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow circle-image">
        </div>
        <span class="brand-text fw-light">{{ $website->name }}</span>
    </a>
</div>

<div class="sidebar-wrapper">
    <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('panel') }}" class="nav-link {{ request()->is('panel') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item {{ request()->is('layanan1') || request()->is('layanan1/*') ? 'menu-open' : '' }}">
                <a href="javascript:void(0)"
                    class="nav-link {{ request()->is('layanan1') || request()->is('layanan1/*') ? 'active' : '' }}">
                    <i class="nav-icon fa-solid fa-server"></i>
                    <p>
                        Layanan 1
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('layanan1') }}" class="nav-link {{ request()->is('layanan1') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-arrow-right-long"></i>
                            <p>Order Baru</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('layanan1.history') }}"
                            class="nav-link {{ request()->is('layanan1/history') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-arrow-right-long"></i>
                            <p>Riwayat Order</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('transaksi') }}" class="nav-link {{ request()->is('transaksi') || request()->is('transaksi') ? 'active' : '' }}">
                    <i class="nav-icon fa-solid fa-book"></i>
                    <p>Semua Transaksi</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('topup') }}" class="nav-link {{ request()->is('topup') || request()->is('topup/transaksi/*') ? 'active' : '' }}">
                    <i class="nav-icon fa-solid fa-money-bill-transfer"></i>
                    <p>TopuUp</p>
                </a>
            </li>

            @if (Auth::user()->role->name == 'superadmin')
                <li class="nav-header">Admin Listed <i class="fa-solid fa-user-tie"></i></li>
                <li class="nav-item">
                    <a href="{{ route('website') }}" class="nav-link {{ request()->is('website') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-globe"></i>
                        <p>Website Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.manage') }}" class="nav-link {{ (request()->is('users') || request()->is('users/*') || request()->is('users/*/*')) ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>Manage Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('irvankede') }}" class="nav-link {{ request()->is('irvankede') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-fire"></i>
                        <p>API irvankedesmm.co.id</p>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a type="button" id="logout-tombol" class="nav-link {{ request()->is('logout') ? 'active' : '' }}">
                    <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                    <p>Logout</p>
                </a>
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</div>


<script>
    $(document).ready(function() {
        var logoutForm = document.getElementById('logout-form');
        var logoutTombol = document.getElementById('logout-tombol');
        logoutTombol.addEventListener('click', function() {
            logoutForm.submit();
        });
    });
</script>
