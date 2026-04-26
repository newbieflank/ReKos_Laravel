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
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ url('/#kostan') }}">Kost-an</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ url('/#service') }}">Service</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ url('/#contact') }}">Contact</a>
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
                            @if (auth()->user()->role === 'owner')
                                <li><a class="dropdown-item" href="{{ route('pemilik.dashboard') }}">Manajemen Kost</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Riwayat</a></li>
                            @endif

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
