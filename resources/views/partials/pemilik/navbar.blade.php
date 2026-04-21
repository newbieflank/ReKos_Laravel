<header id="navbar" class="d-flex align-items-center justify-content-between px-4 shadow-sm border-bottom">
    <div class="d-flex align-items-center gap-3">
        <button id="mobileToggle" class="btn btn-light d-lg-none border-0 text-secondary p-2">
            <i class="fa-solid fa-bars fs-5"></i>
        </button>

        <div class="text-muted small d-none d-sm-block">
            Menu / <span class="text-dark fw-medium">Pemilik Kost</span>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 gap-md-4">
        <button class="btn btn-link text-secondary position-relative p-0 border-0">
            <i class="fa-solid fa-bell fs-5" style="color: #6c757d;"></i>
            <span
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white"
                style="font-size: 0.65rem;">
                6
            </span>
        </button>

        <div class="vr d-none d-md-block" style="height: 24px;"></div>

        <div class="dropdown">
            <button class="btn p-0 border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-circle-user text-primary" style="font-size: 32px;"></i>
                <span class="text-dark small fw-medium d-none d-md-block">Bapak/Ibu Kost</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li><a class="dropdown-item py-2" href="#"><i class="fa-solid fa-user me-2"></i> Profil</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item py-2 text-danger" href="#"><i
                            class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</header>
