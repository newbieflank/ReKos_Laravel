<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - RE-KOST</title>
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

        .separator {
            text-align: center;
            margin: 20px 0;
        }

        .separator span {
            background: #fff;
            padding: 0 10px;
            color: #6c757d;
        }

        .separator::before {
            content: "";
            display: block;
            height: 1px;
            background: #dee2e6;
            position: relative;
            top: 12px;
            z-index: -1;
        }

        .showPass {
            cursor: pointer;
            width: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid vh-100">
        <div class="row shadow-lg login-card w-100 h-100 m-0 g-0">

            <div class="col-lg-6 p-5 bg-white">
                <img src="{{ asset('images/logo.svg') }}" class="logo mb-3" alt="Logo">

                <h4 class="fw-bold">Selamat Datang</h4>
                <p class="text-muted mb-5">
                    Selamat Datang di laman Re-kost! Tempat terbaik untuk mencari rekomendasi kost
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

                <form method="post" action="{{ route('login.auth') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="example@gmail.com"
                            value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>

                        <div class="position-relative">
                            <input type="password" name="password" id="password" class="form-control pe-5"
                                placeholder="Masukan Password" required>

                            <img src="{{ asset('images/EyeLogin.svg') }}"
                                class="position-absolute top-50 end-0 translate-middle-y me-3 showPass"
                                onclick="togglePassword()">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <input type="checkbox" name="remember">
                            <label>Remember Me</label>
                        </div>
                        <a href="{{ route('login') }}" class="small">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn w-100 py-3 text-white fw-bold"
                        style="background:#3f7ae0; border-radius:10px;">
                        Login
                    </button>
                </form>

                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1">
                    <span class="mx-3 text-muted">Or Sign In With</span>
                    <hr class="flex-grow-1">
                </div>

                <a href="#" class="btn w-100 py-3 d-flex align-items-center justify-content-center gap-2"
                    style="border-radius:10px; border:2px solid #3f7ae0;">
                    <img src="{{ asset('images/GoogleLogo.svg') }}" width="20">
                    <span class="fw-semibold text-dark">Sign In With Google</span>
                </a>

                <div class="mt-auto pt-4">
                    <p class="text-muted mb-0 text-center">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="fw-semibold text-decoration-none"
                            style="color:#3f7ae0;">
                            Register
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block login-image p-0 bg-white">
                <img src="{{ asset('images/ImageLogin.svg') }}" class="w-100 h-100 object-fit-cover" alt="">
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        }

        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>

</body>

</html>
