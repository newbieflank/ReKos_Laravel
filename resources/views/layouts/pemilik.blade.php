<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RE-KOST')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --navbar-height: 64px;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #6c757d;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover {
            background-color: #f3f4f6;
            color: #0d6efd;
        }

        .nav-link-custom.active {
            background-color: #4a85f6;
            color: white;
            font-weight: 500;
        }

        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            transition: transform 0.3s ease-in-out;
            background-color: #fff;
        }

        #navbar {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--navbar-height);
            z-index: 1030;
            transition: left 0.3s ease-in-out;
            background-color: #fff;
        }

        #main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 24px;
            min-height: calc(100vh - var(--navbar-height));
            transition: margin-left 0.3s ease-in-out;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }

        .card-bg-icon {
            position: absolute;
            bottom: -15px;
            right: -15px;
            font-size: 100px;
            opacity: 0.1;
        }

        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1035;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        @media (max-width: 991.98px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #navbar {
                left: 0;
            }

            #main-content {
                margin-left: 0;
                padding: 16px;
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    <div id="sidebar-overlay"></div>

    @include('partials.pemilik.sidebar')

    @include('partials.pemilik.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const btnOpen = document.getElementById('mobileToggle');
        const btnClose = document.getElementById('closeSidebar');

        btnOpen.addEventListener('click', function() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
        });

        function closeMenu() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }

        btnClose.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);
    </script>

    @stack('scripts')

</body>

</html>
