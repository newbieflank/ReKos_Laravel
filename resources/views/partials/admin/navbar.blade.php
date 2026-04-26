<header id="navbar"
    class="bg-white d-flex align-items-center justify-content-between px-4 position-fixed top-0 shadow-sm"
    style="height: 64px; z-index: 1020;">

    <div class="d-flex align-items-center gap-3">
        <button id="mobileToggle" class="btn btn-light d-md-none border-0 text-secondary p-2">
            <i class="fa-solid fa-bars fs-5"></i>
        </button>

        <div class="text-muted small d-none d-sm-block">
            Menu / <span class="text-dark fw-medium">Admin</span>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 gap-md-4">

        <button class="btn btn-link text-secondary position-relative p-0 border-0">
            <i class="fa-regular fa-bell fs-5"></i>
            <span
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white"
                style="font-size: 0.65rem;">
                6
            </span>
        </button>

        <div class="vr d-none d-md-block" style="height: 24px;"></div>

        <div class="dropdown">
            <button class="btn p-0 border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name=Admin&background=0d6efd&color=fff" alt="User"
                    class="rounded-circle" width="32" height="32">
                <span class="text-dark small fw-medium d-none d-md-block">Administrator</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li>
                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

    </div>
</header>
