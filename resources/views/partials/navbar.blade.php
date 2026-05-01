<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo Re-Kost" height="70">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto fw-medium">
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ route('home') }}#hero">Home</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ route('home') }}#rekomendasi">Kost-an</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ route('home') }}#rating">Rating</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown"
                            role="button" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle me-2" width="35"
                                height="35">
                            <span>{{ Str::limit(auth()->user()->name, 15, '...') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <!-- Profile Link (Semua Role) -->
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>

                            <!-- Menu Owner -->
                            @if (auth()->user()->role === 'owner')
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('pemilik.dashboard') }}">Manajemen Kost</a>
                                </li>
                                <!-- Menu Tenant -->
                            @elseif (auth()->user()->role === 'tenant')
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('user.history') }}">Riwayat</a></li>
                                @if (auth()->user()->roleRequest && auth()->user()->roleRequest->status == 'pending')
                                    <li><button class="dropdown-item text-muted" disabled>Menunggu Persetujuan...</button>
                                    </li>
                                @else
                                    <li>
                                        <form action="{{ route('role.request') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Ajukan Jadi Owner</button>
                                        </form>
                                    </li>
                                @endif
                            @endif

                            <!-- Logout -->
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<script>
    document.querySelectorAll('a.nav-link[href*="#"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const hashIndex = href.indexOf('#');
            if (hashIndex === -1) return;

            const hash = href.substring(hashIndex + 1);
            const target = document.getElementById(hash);

            // Jika section ada di halaman ini, scroll tanpa hash
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Hapus hash dari URL
                history.replaceState(null, '', window.location.pathname);
            }
            // Jika tidak ada (halaman lain), biarkan navigasi biasa terjadi
        });
    });
</script>
