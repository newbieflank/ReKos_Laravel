<aside class="bg-white shadow-sm d-flex flex-column border-end position-fixed top-0 start-0"
    style="width: 260px; height: 100vh; z-index: 1030;">

    <div class="d-flex align-items-center justify-content-between px-4 flex-shrink-0"
        style="height: 64px; border-bottom: 1px solid #f3f4f6;">
        <div class="d-flex align-items-center gap-2 text-primary fw-bold fs-5">
            <img src="{{ asset('images/logo.svg') }}" alt="RE-KOST Logo" style="width: 32px; height: 32px;">
            <span class="text-dark fs-6" style="letter-spacing: 2px;">RE-KOST</span>
        </div>

        <button id="closeSidebar" class="btn btn-link text-secondary p-0 border-0 d-md-none">
            <i class="fa-solid fa-xmark fs-4"></i>
        </button>
    </div>

    <nav class="flex-grow-1 px-3 py-4 overflow-auto">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high" style="width: 20px;"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.persetujuan') }}"
            class="nav-link-custom {{ request()->routeIs('admin.persetujuan') ? 'active' : '' }}">
            <i class="fa-solid fa-users" style="width: 20px;"></i>
            <span>Persetujuan Kost</span>
        </a>

        <div class="mt-2">
            @php
                $isPenggunaActive = request()->routeIs('admin.pencari-kos') || request()->routeIs('admin.pemilik-kos');
            @endphp

            <div class="nav-link-custom d-flex justify-content-between align-items-center w-100 {{ $isPenggunaActive ? '' : 'text-secondary' }}"
                data-bs-toggle="collapse" data-bs-target="#collapsePengguna"
                aria-expanded="{{ $isPenggunaActive ? 'true' : 'false' }}" aria-controls="collapsePengguna"
                style="cursor: pointer;">

                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-list-ul" style="width: 20px;"></i>
                    <span class="fw-medium">Daftar Pengguna</span>
                </div>
                <i class="fa-solid fa-chevron-down rotate-icon" style="font-size: 12px;"></i>
            </div>

            <div class="collapse {{ $isPenggunaActive ? 'show' : '' }} mt-1" id="collapsePengguna">
                <div class="d-flex flex-column" style="margin-left: 44px;">
                    <a href="{{ route('admin.pencari-kos') }}"
                        class="py-2 text-decoration-none small {{ request()->routeIs('admin.pencari-kos') ? 'text-primary fw-bold' : 'text-secondary' }} hover-primary">
                        Pencari Kost
                    </a>
                    <a href="{{ route('admin.pemilik-kos') }}"
                        class="py-2 text-decoration-none small {{ request()->routeIs('admin.pemilik-kos') ? 'text-primary fw-bold' : 'text-secondary' }} hover-primary">
                        Pemilik Kost
                    </a>
                </div>
            </div>
        </div>

    </nav>
</aside>
