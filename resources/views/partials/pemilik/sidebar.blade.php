<aside id="sidebar" class="bg-white d-flex flex-column border-end position-fixed h-100"
    style="width: var(--sidebar-width); top: 0; left: 0; z-index: 1040; transition: transform 0.3s ease-in-out;">
    <div class="d-flex align-items-center justify-content-between px-4 flex-shrink-0"
        style="height: 64px; border-bottom: 1px solid #f3f4f6;">
        <div class="d-flex align-items-center gap-2 text-primary fw-bold fs-5">
            <i class="fa-solid fa-hurricane"></i>
            <span class="text-dark fs-6" style="letter-spacing: 2px;">RE-KOST</span>
        </div>

        <button id="closeSidebar" class="btn btn-link text-secondary p-0 border-0 d-lg-none">
            <i class="fa-solid fa-xmark fs-4"></i>
        </button>
    </div>

    <nav class="flex-grow-1 px-3 py-4 overflow-auto">
        <a href="{{ route('pemilik.dashboard') }}"
            class="nav-link-custom {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high" style="width: 20px;"></i>
            <span>Dashboard</span>
        </a>

        <div class="mt-2">
            @php
                $isManajemenActive = request()->routeIs('pemilik.kost') || request()->routeIs('pemilik.kamar');
            @endphp

            <div class="nav-link-custom d-flex justify-content-between align-items-center w-100 {{ $isManajemenActive ? 'text-primary' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#collapseManajemen"
                aria-expanded="{{ $isManajemenActive ? 'true' : 'false' }}"
                style="cursor: pointer; {{ $isManajemenActive ? 'background-color: #f8f9fa;' : '' }}">

                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-building" style="width: 20px;"></i>
                    <span class="{{ $isManajemenActive ? 'fw-medium' : '' }}">Manajemen kost</span>
                </div>
                <i class="fa-solid fa-chevron-down" style="font-size: 12px; transition: transform 0.3s;"></i>
            </div>

            <div class="collapse {{ $isManajemenActive ? 'show' : '' }} mt-1" id="collapseManajemen">
                <div class="d-flex flex-column" style="margin-left: 44px;">
                    <a href="{{ route('pemilik.kost') }}"
                        class="py-2 text-decoration-none small {{ request()->routeIs('pemilik.kost') ? 'text-primary fw-bold' : 'text-secondary' }} hover-primary">
                        Data Kost
                    </a>
                    <a href="{{ route('pemilik.kamar') }}"
                        class="py-2 text-decoration-none small {{ request()->routeIs('pemilik.kamar') ? 'text-primary fw-bold' : 'text-secondary' }} hover-primary">
                        Kamar Kost
                    </a>
                </div>
            </div>
        </div>

        <a href="{{ route('pemilik.penyewa') }}"
            class="nav-link-custom {{ request()->routeIs('pemilik.penyewa') ? 'active' : '' }} mt-2">
            <i class="fa-solid fa-users" style="width: 20px;"></i>
            <span>Penyewa</span>
        </a>
    </nav>
</aside>

<style>
    .hover-primary:hover {
        color: #0d6efd !important;
    }

    .nav-link-custom[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
    }
</style>
