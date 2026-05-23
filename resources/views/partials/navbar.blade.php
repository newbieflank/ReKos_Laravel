<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo Re-Kost" height="70">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @php
                $isProfileIncomplete = false;
                if (auth()->check()) {
                    $user = auth()->user();
                    $userDetail = $user->userDetail;
                    if (!$userDetail || 
                        empty(trim((string)$userDetail->phone)) || 
                        empty(trim((string)$userDetail->gender)) || 
                        $userDetail->gender === 'unknown' || 
                        empty(trim((string)$userDetail->birth_date))) {
                        $isProfileIncomplete = true;
                    }
                }
            @endphp

            <ul class="navbar-nav mx-auto fw-medium">
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ $isProfileIncomplete ? 'javascript:void(0)' : route('home') . '#hero' }}"
                        @if($isProfileIncomplete) onclick="alertProfileIncompleteNav()" @endif>Home</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ $isProfileIncomplete ? 'javascript:void(0)' : route('home') . '#rekomendasi' }}"
                        @if($isProfileIncomplete) onclick="alertProfileIncompleteNav()" @endif>Kost-an</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ $isProfileIncomplete ? 'javascript:void(0)' : route('home') . '#rating' }}"
                        @if($isProfileIncomplete) onclick="alertProfileIncompleteNav()" @endif>Rating</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ $isProfileIncomplete ? 'javascript:void(0)' : route('home') . '#contact' }}"
                        @if($isProfileIncomplete) onclick="alertProfileIncompleteNav()" @endif>Contact</a>
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

                            <!-- Menu Admin -->
                            @if (auth()->user()->role === 'admin')
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                                </li>
                                <!-- Menu Owner -->
                            @elseif (auth()->user()->role === 'owner')
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
                                @if (\App\Models\RoleRequest::where('user_id', auth()->id())->where('status', 'pending')->exists())
                                    <li><button class="dropdown-item text-muted" disabled style="background-color: #f8f9fa; cursor: not-allowed;">Dalam proses persetujuan admin</button>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ajukanOwnerModal">Ajukan Jadi Pemilik Kos</a>
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

<div class="modal fade" id="ajukanOwnerModal" tabindex="-1" aria-labelledby="ajukanOwnerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('role.request') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajukanOwnerModalLabel">Ajukan Jadi Owner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Untuk mengajukan diri sebagai pemilik kost, Anda perlu mengunggah foto KTP.</p>
                    <div class="mb-3">
                        <label for="ktp_image" class="form-label">Foto KTP <span class="text-danger">*</span></label>
                        <input class="form-control @error('ktp_image') is-invalid @enderror" type="file" id="ktp_image" name="ktp_image" accept="image/*" required>
                        @error('ktp_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">Maksimal ukuran file 2MB. Format: JPG, JPEG, PNG.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>
            </div>
        </form>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function alertProfileIncompleteNav() {
            Swal.fire({
                title: 'Profil Belum Lengkap!',
                text: 'Harap lengkapi profil Anda terlebih dahulu untuk menelusuri halaman lain.',
                icon: 'warning',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#0d6efd'
            });
        }

        document.querySelectorAll('a.nav-link[href*="#"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === 'javascript:void(0)') return;
                
                const hashIndex = href.indexOf('#');
                if (hashIndex === -1) return;

                const hash = href.substring(hashIndex + 1);
                const target = document.getElementById(hash);

                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    history.replaceState(null, '', window.location.pathname);
                }
            });
        });
    </script>
