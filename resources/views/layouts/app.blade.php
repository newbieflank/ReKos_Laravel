<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Re-Kost - Cari Kost Terbaik</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>

        body {
            font-family: 'Inter', sans-serif; 
            background-color: #f8fbff; 
        }
        
        .btn-primary {
            background-color: #59A1FF !important;
            border-color: #59A1FF !important;
            border-radius: 50px; 
        }
        .btn-primary:hover {
            background-color: #488ce6 !important; 
        }

        .btn-outline-primary {
            color: #59A1FF !important;
            border-color: #59A1FF !important;
        }
        .btn-outline-primary:hover {
            background-color: #59A1FF !important;
            color: white !important;
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
</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>