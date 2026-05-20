<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 40px;
            text-align: center;
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #3f7ae0;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }
        .title {
            font-size: 22px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
        }
        .description {
            font-size: 15px;
            color: #718096;
            line-height: 1.5;
            margin-bottom: 30px;
        }
        .otp-container {
            background-color: #f7fafc;
            border: 1px dashed #e2e8f0;
            border-radius: 8px;
            padding: 15px 30px;
            display: inline-block;
            margin-bottom: 30px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 6px;
            color: #3f7ae0;
            margin: 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #a0aec0;
            line-height: 1.5;
        }
        .warning {
            font-size: 13px;
            color: #e53e3e;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">Re-Kost</div>
            <h1 class="title">Reset Password Anda</h1>
            <p class="description">Kami menerima permintaan untuk melakukan reset password akun Re-Kost Anda. Gunakan kode OTP di bawah ini untuk memverifikasi identitas Anda:</p>
            
            <div class="otp-container">
                <h2 class="otp-code">{{ $otp }}</h2>
            </div>
            
            <p class="warning"><strong>PENTING:</strong> Kode OTP ini hanya berlaku selama 10 menit. Jangan berikan kode ini kepada siapapun demi keamanan akun Anda.</p>
            
            <hr style="border: 0; border-top: 1px solid #edf2f7; margin: 30px 0;">
            
            <div class="footer">
                <p>Jika Anda tidak merasa mengajukan permintaan ini, silakan abaikan email ini.</p>
                <p>&copy; {{ date('Y') }} Re-Kost. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
