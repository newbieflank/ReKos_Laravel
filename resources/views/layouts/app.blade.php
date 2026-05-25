<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Re-Kost</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fbff;
        }

        .btn-primary {
            background-color: #59A1FF !important;
            border-color: #59A1FF !important;
            border-radius: 50px;
            font-weight: 600;
            padding: 8px 24px;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #488ce6 !important;
            border-color: #488ce6 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(89, 161, 255, 0.15);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-primary {
            color: #59A1FF !important;
            border-color: #59A1FF !important;
            border-radius: 50px;
            font-weight: 600;
            padding: 8px 24px;
            transition: all 0.2s ease-in-out;
        }

        .btn-outline-primary:hover {
            background-color: #59A1FF !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(89, 161, 255, 0.15);
        }

        .btn-outline-primary:active {
            transform: translateY(0);
        }

        .border-primary {
            border-color: #59A1FF !important;
        }

        .text-primary {
            color: #59A1FF !important;
        }

        .section-biru {
            background-color: #59A1FF;
            color: white;
        }

        .card-kost {
            transition: transform 0.3s ease;
        }

        .card-kost:hover {
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .display-5 {
                font-size: 2rem !important;
            }

            .container[style*="margin-bottom: -50px"] {
                margin-bottom: 20px !important;
            }

            .section-biru {
                padding-top: 50px !important;
                padding-bottom: 40px !important;
            }

            .p-md-5 {
                padding: 1.5rem !important;
            }

            .w-100[style*="max-width: 180px"] {
                max-width: 100% !important;
                margin-top: 10px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <div style="position: fixed; bottom: 10px; right: 10px; background: rgba(0,0,0,0.8); color: #00ff00; padding: 5px 10px; border-radius: 5px; font-family: monospace; z-index: 9999; font-size: 12px; font-weight: bold; box-shadow: 0 2px 10px rgba(0,0,0,0.5); backdrop-filter: blur(4px); border: 1px solid rgba(0, 255, 0, 0.3);">
        Server: {{ env('SERVER_NODE', gethostname()) }}
    </div>
</body>

</html>
