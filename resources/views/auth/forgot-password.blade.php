<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Re-Kost</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }

        .login-card {
            border-radius: 15px;
            overflow: hidden;
        }

        .login-image {
            background-color: #e8f5e9;
        }

        .login-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo {
            width: 80px;
        }
    </style>
</head>

<body>
    <div class="container-fluid vh-100">
        <div class="row shadow-lg login-card w-100 h-100 m-0 g-0">

            <div class="col-lg-6 p-5 bg-white">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.svg') }}" class="logo mb-3" alt="Logo">
                </a>

                <h4 class="fw-bold">Lupa Password?</h4>
                <p class="text-muted mb-5">
                    Masukkan email Anda yang terdaftar. Kami akan mengirimkan kode verifikasi OTP untuk menyetel ulang kata sandi Anda.
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="post" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" name="email" class="form-control py-2" placeholder="example@gmail.com"
                            value="{{ old('email') }}" required>
                    </div>

                    <button type="submit" class="btn w-100 py-3 text-white fw-bold mb-3"
                        style="background:#3f7ae0; border-radius:10px;">
                        Kirim Kode OTP
                    </button>
                    
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 py-3 fw-bold"
                        style="border-radius:10px;">
                        Kembali ke Login
                    </a>
                </form>
            </div>

            <div class="col-lg-6 d-none d-lg-block login-image p-0 bg-white">
                <img src="{{ asset('images/ImageLogin.svg') }}" class="w-100 h-100 object-fit-cover" alt="">
            </div>

        </div>
    </div>
</body>
</html>
