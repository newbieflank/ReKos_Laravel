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

        .otp-wrapper {
            display: flex;
            justify-content: center;
            gap: 10px;
            width: 100%;
        }

        .otp-input {
            width: 50px;
            height: 60px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .otp-input:focus {
            border-color: #3f7ae0;
            outline: none;
            box-shadow: 0 0 5px rgba(63, 122, 224, 0.3);
        }

        @media (max-width: 576px) {
            .otp-wrapper {
                gap: 6px;
            }
            .otp-input {
                width: 40px;
                height: 50px;
                font-size: 20px;
            }
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

                <h4 class="fw-bold">Verifikasi Kode OTP</h4>
                <p class="text-muted mb-5">
                    Kami telah mengirimkan 6 digit kode OTP ke email <strong>{{ session('reset_email') }}</strong>. Masukkan kode tersebut di bawah ini.
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

                <form method="post" action="{{ route('password.verify_otp') }}">
                    @csrf

                    <div class="otp-wrapper mb-4">
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" required autocomplete="off">
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" required autocomplete="off">
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" required autocomplete="off">
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" required autocomplete="off">
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" required autocomplete="off">
                        <input type="text" name="otp[]" class="otp-input" maxlength="1" pattern="[0-9]" required autocomplete="off">
                    </div>

                    <button type="submit" class="btn w-100 py-3 text-white fw-bold mb-3"
                        style="background:#3f7ae0; border-radius:10px;">
                        Verifikasi OTP
                    </button>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <form method="post" action="{{ route('password.email') }}" class="m-0">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('reset_email') }}">
                        <button type="submit" class="btn btn-link p-0 text-decoration-none small" style="color:#3f7ae0;">
                            Kirim Ulang Kode
                        </button>
                    </form>
                    <a href="{{ route('password.request') }}" class="small text-muted text-decoration-none">
                        Ubah Email
                    </a>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block login-image p-0 bg-white">
                <img src="{{ asset('images/ImageLogin.svg') }}" class="w-100 h-100 object-fit-cover" alt="">
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    if (!/^\d$/.test(this.value)) {
                        this.value = '';
                        return;
                    }
                    
                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        if (this.value === '' && index > 0) {
                            inputs[index - 1].focus();
                            inputs[index - 1].value = '';
                        } else {
                            this.value = '';
                        }
                        e.preventDefault();
                    }
                });
                
                input.addEventListener('paste', function(e) {
                    const pasteData = e.clipboardData.getData('text').trim();
                    if (/^\d{6}$/.test(pasteData)) {
                        inputs.forEach((input, i) => {
                            input.value = pasteData[i];
                        });
                        inputs[5].focus();
                        e.preventDefault();
                    }
                });
            });
            
            inputs[0].focus();
        });
    </script>
</body>
</html>
