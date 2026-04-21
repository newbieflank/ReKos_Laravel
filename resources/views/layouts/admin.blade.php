<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Re-Kost</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .nav-link-custom {
            color: #6c757d;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .nav-link-custom:hover {
            background-color: #f1f5f9;
            color: #0d6efd;
        }

        .nav-link-custom.active {
            background-color: #0d6efd;
            color: #fff !important;
        }

        .rotate-icon {
            transition: transform 0.3s ease-in-out;
        }

        .nav-link-custom[aria-expanded="true"] .rotate-icon {
            transform: rotate(180deg);
        }

        .hover-primary:hover {
            color: #0d6efd !important;
        }

        #sidebar {
            transition: all 0.3s ease;
        }

        #main-wrapper {
            transition: all 0.3s ease;
            margin-left: 260px;
        }

        #navbar {
            transition: all 0.3s ease;
            width: calc(100% - 260px);
            left: 260px;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -260px;
            }

            #sidebar.show-mobile {
                margin-left: 0;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2) !important;
            }

            #main-wrapper {
                margin-left: 0;
            }

            #navbar {
                width: 100%;
                left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div id="sidebar">
        @include('partials.admin.sidebar')
    </div>

    <div id="main-wrapper">

        <div id="navbar">
            @include('partials.admin.navbar')
        </div>

        <main class="p-4 p-md-5" style="margin-top: 64px; min-height: calc(100vh - 64px);"> @yield('content')
        </main>
    </div>

    <div id="sidebarOverlay" class="d-none"
        style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 1025;">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("mobileToggle");
            const closeBtn = document.getElementById("closeSidebar");
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebarOverlay");

            if (toggleBtn) {
                toggleBtn.addEventListener("click", function() {
                    sidebar.classList.add("show-mobile");
                    overlay.classList.remove("d-none");
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener("click", function() {
                    sidebar.classList.remove("show-mobile");
                    overlay.classList.add("d-none");
                });
            }

            if (overlay) {
                overlay.addEventListener("click", function() {
                    sidebar.classList.remove("show-mobile");
                    overlay.classList.add("d-none");
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
