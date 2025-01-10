<div class="sidebar-brand">
    <a href="{{ route('panel') }}" class="brand-link"> <img src="{{ asset('panels/img/AdminLTELogo.png') }}"
            alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
        <span class="brand-text fw-light">AdminLTE 4</span>
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
                    <i class="nav-icon bi bi-tree-fill"></i>
                    <p>
                        Layanan 1
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('layanan1') }}" class="nav-link {{ request()->is('layanan1') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Order Baru</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('layanan1.history') }}"
                            class="nav-link {{ request()->is('layanan1/history') ? 'active' : '' }}"> <i
                                class="nav-icon bi bi-circle"></i>
                            <p>Riwayat Order</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('transaksi') }}" class="nav-link {{ request()->is('transaksi') || request()->is('transaksi') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>Semua Transaksi</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('topup') }}" class="nav-link {{ request()->is('topup') || request()->is('topup/transaksi/*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>TopuUp</p>
                </a>
            </li>

            <li class="nav-item">
                <a type="button" id="logout-tombol" class="nav-link {{ request()->is('logout') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>Logout</p>
                </a>
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                </form>
            </li>


            @if (Auth::user()->role->name == 'superadmin')
                <li class="nav-header">Admin</li>
                <li class="nav-item">
                    <a href="{{ route('website') }}" class="nav-link {{ request()->is('website') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-globe"></i>
                        <p>Website Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.manage') }}" class="nav-link {{ request()->is('users.manage') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-globe"></i>
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
