@extends('layouts.app')

@section('content')
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #EEF2F8;
            color: #1a1a2e;
        }

        .page-wrapper {
            min-height: 100vh;
            background: #EEF2F8;
        }

        .stepper-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 0 28px;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .step-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            border: 2px solid #ccc;
            background: #fff;
            color: #aaa;
        }

        .step-circle.done {
            background: #1E3A8A;
            border-color: #1E3A8A;
            color: #fff;
        }

        .step-circle.active {
            background: #1E3A8A;
            border-color: #1E3A8A;
            color: #fff;
        }

        .step-label {
            font-size: 12px;
            margin-top: 6px;
            color: #aaa;
            font-weight: 500;
        }

        .step-label.done {
            color: #1E3A8A;
        }

        .step-label.active {
            color: #1E3A8A;
            font-weight: 700;
        }

        .step-line {
            width: 120px;
            height: 2px;
            background: #ccc;
            margin-bottom: 20px;
        }

        .step-line.done {
            background: #1E3A8A;
        }

        .main-layout {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px 60px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 28px;
            align-items: start;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #EFF6FF;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #1E3A8A;
        }

        .edit-link {
            font-size: 13px;
            color: #1E3A8A;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .edit-link:hover {
            text-decoration: underline;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 28px;
        }

        .field-group {}

        .field-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 4px;
        }

        .field-value {
            font-size: 14px;
            color: #1a1a2e;
            font-weight: 500;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .room-detail-box {
            background: #F8FAFC;
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .room-number-badge {
            background: #1E3A8A;
            color: #fff;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 12px;
            font-weight: 800;
            min-width: 56px;
            text-align: center;
            flex-shrink: 0;
            line-height: 1.3;
        }

        .room-detail-info .room-lbl {
            font-size: 10px;
            color: #999;
            font-weight: 600;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .room-detail-info .room-name {
            font-size: 15px;
            font-weight: 700;
            color: #1E3A8A;
        }

        .summary-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 20px;
        }

        .invoice-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #888;
            text-align: right;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .summary-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #444;
            margin-bottom: 10px;
        }

        .summary-divider {
            border: none;
            border-top: 1.5px dashed #E2E8F0;
            margin: 14px 0;
        }

        .summary-total-block {
            margin-bottom: 6px;
        }

        .summary-total-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 4px;
        }

        .summary-total-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .summary-total-amount {
            font-size: 24px;
            font-weight: 800;
            color: #1E3A8A;
        }

        .badge-lunas {
            background: #D1FAE5;
            color: #065F46;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .paid-date {
            font-size: 11px;
            color: #999;
            text-align: right;
            margin-top: 4px;
        }

        .confirm-box {
            background: #F8FAFC;
            border-radius: 10px;
            padding: 14px 16px;
            margin: 18px 0;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: #555;
            line-height: 1.5;
        }

        .confirm-box input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-top: 2px;
            flex-shrink: 0;
            accent-color: #1E3A8A;
            cursor: pointer;
        }

        .btn-primary {
            width: 100%;
            background: #1E3A8A;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .btn-primary:hover {
            background: #1e40af;
            transform: translateY(-1px);
        }

        .btn-secondary {
            width: 100%;
            background: #F1F5F9;
            color: #444;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-secondary:hover {
            background: #E2E8F0;
        }
    </style>

    <div class="page-wrapper">


        <div class="stepper-wrapper">
            <div class="step-item">
                <div class="step-circle done">✓</div>
                <div class="step-label done">Informasi</div>
            </div>
            <div class="step-line done"></div>
            <div class="step-item">
                <div class="step-circle done">✓</div>
                <div class="step-label done">Pembayaran</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle active">3</div>
                <div class="step-label active">Konfirmasi</div>
            </div>
        </div>

        <div class="main-layout">
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="card-title">Profil Penyewa</div>
                        </div>
                    </div>
                    <div class="profile-grid">
                        <div class="field-group">
                            <div class="field-label">Nama Lengkap</div>
                            <div class="field-value">{{ $user->name }}</div>
                        </div>
                        <div class="field-group">
                            <div class="field-label">Jenis Kelamin</div>
                            <div class="field-value">{{ $user->userDetail->gender }}</div>
                        </div>
                        <div class="field-group">
                            <div class="field-label">Nomor Telepon</div>
                            <div class="field-value">{{ $user->userDetail->phone }}</div>
                        </div>
                        <div class="field-group">
                            <div class="field-label">Pekerjaan</div>
                            <div class="field-value">{{ $user->userDetail->occupation ?? '-' }}</div>
                        </div>
                        <div class="field-group field-full">
                            <div class="field-label">Alamat Asal</div>
                            <div class="field-value">{{ $user->userDetail->address ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon">
                                <i class="bi bi-house"></i>
                            </div>
                            <div class="card-title">Detail Sewa</div>
                        </div>
                    </div>

                    <div class="room-detail-box">
                        <div class="room-number-badge">A101</div>
                        <div class="room-detail-info">
                            <div class="room-lbl">Nomor Kamar</div>
                            <div class="room-name">{{ $kos->boardingHouse->boarding_house_name }} - {{ $kos->room_name }}
                            </div>
                        </div>
                        <div style="margin-left:auto;">
                            <div class="field-label">Tipe Sewa</div>
                            <span
                                style="background:#EFF6FF;color:#1D4ED8;font-size:12px;font-weight:700;padding:4px 12px;border-radius:20px;">{{ $detail['duration_type'] }}</span>
                        </div>
                    </div>

                    <div class="profile-grid">
                        <div class="field-group">
                            <div class="field-label">Tanggal Masuk</div>
                            <div class="field-value">
                                {{ \Carbon\Carbon::parse($detail['start_date'])->translatedFormat('d F Y') }}
                            </div>
                        </div>
                        <div class="field-group">
                            <div class="field-label">Durasi Sewa</div>
                            <div class="field-value">
                                @php
                                    $start = \Carbon\Carbon::parse($detail['start_date']);
                                    $end = \Carbon\Carbon::parse($detail['end_date']);

                                    $diffInDays = $start->diffInDays($end);
                                    $diffInWeeks = $start->diffInWeeks($end);
                                    $diffInMonths = $start->diffInMonths($end);

                                    if ($detail['duration_type'] === 'bulanan' && $diffInMonths >= 1) {
                                        $label = $diffInMonths . ' Bulan';
                                    } elseif ($detail['duration_type'] === 'mingguan' && $diffInWeeks >= 1) {
                                        $label = $diffInWeeks . ' Minggu';
                                    } else {
                                        $label = $diffInDays . ' Hari';
                                    }
                                @endphp
                                {{ $label }}
                            </div>
                        </div>
                    </div>

                </div>
                @php
                    $bookingData = session('booking_data');
                    $midtrans = $bookingData['midtrans_response'] ?? null;
                @endphp

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Instruksi Pembayaran</h5>

                        <div class="payment-box p-3 border rounded bg-light mb-3 text-center">
                            <div class="text-muted small mb-2">Metode: {{ $bookingData['payment_method'] }}</div>

                            @if (isset($midtrans['va_numbers']))
                                <div class="d-flex align-items-center justify-content-between">
                                    <h3 class="mb-0 fw-bold text-primary" id="paymentNumber">
                                        {{ $midtrans['va_numbers'][0]['va_number'] }}
                                    </h3>
                                    <button class="btn btn-outline-primary btn-sm" onclick="copyToClipboard()">
                                        <i class="bi bi-clipboard"></i> Salin
                                    </button>
                                </div>
                            @elseif(isset($midtrans['actions']))
                                @php
                                    $qrAction = collect($midtrans['actions'])
                                        ->where('name', 'generate-qr-code')
                                        ->first();
                                @endphp

                                @if ($qrAction)
                                    <div class="qr-wrapper mb-3">
                                        <img src="{{ $qrAction['url'] }}" alt="QR Code GoPay"
                                            style="width: 200px; height: 200px;">
                                    </div>
                                    <div class="small text-muted">Scan QR Code di atas melalui aplikasi Gojek Anda</div>
                                    <a href="{{ collect($midtrans['actions'])->where('name', 'deeplink-redirect')->first()['url'] }}"
                                        class="btn btn-sm btn-primary mt-2">Buka Aplikasi Gojek</a>
                                @endif
                            @endif
                        </div>

                        <div class="alert alert-info py-2 small">
                            <i class="bi bi-info-circle me-2"></i>
                            Silahkan Melakukan Pembayaran Sebelum: <br>
                            <strong>{{ \Carbon\Carbon::parse($midtrans['expiry_time'])->format('d M Y, H:i') }}
                                WIB</strong>
                        </div>

                        <div class="small text-muted">
                            *Segera lakukan pembayaran agar pesanan tidak otomatis dibatalkan.
                        </div>
                    </div>
                </div>
            </div>

            <div class="summary-card">
                <div class="invoice-label">Invoice #8821</div>
                <div class="summary-title">Ringkasan Pembayaran</div>

                <div class="summary-row">
                    <span>Sewa Kamar ( {{ $detail['duration_type'] }} )</span>
                    <span>Rp {{ number_format($detail['total_price'], 0, ',', '.') }}</span>
                </div>
                <hr class="summary-divider">

                <div class="summary-total-block">
                    <div class="summary-total-label">Total Billing</div>
                    <div class="summary-total-row">
                        <div class="summary-total-amount">Rp {{ number_format($detail['total_price'], 0, ',', '.') }}</div>
                    </div>
                </div>

                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    @php
                        $detail = session('booking_data');
                        $methodType = str_contains($detail['payment_method'], 'Virtual') ? 'va' : 'e-wallet';
                    @endphp

                    <input type="hidden" name="tenant_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="amount" value="{{ $detail['total_price'] }}">
                    <input type="hidden" name="payment_date" value="{{ now() }}">
                    <input type="hidden" name="payment_method" value="{{ $methodType }}">

                    <div class="confirm-box">
                        <input type="checkbox" name="confirm" id="confirm-check" required>
                        <label for="confirm-check">
                            Saya mengonfirmasi bahwa sudah melakukan pembayaran sesuai instruksi.
                        </label>
                    </div>

                    <button type="submit" class="btn-primary">
                        Simpan & Selesaikan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function handleSubmit() {
            const checked = document.getElementById('confirm-check').checked;

            if (!checked) {
                alert('Mohon centang konfirmasi terlebih dahulu sebelum melanjutkan.');
                return;
            }

            window.location.href = "{{ route('payments.success') }}";
        }

        function copyToClipboard() {
            const num = document.getElementById('paymentNumber').innerText;
            navigator.clipboard.writeText(num).then(() => {
                alert('Nomor pembayaran berhasil disalin!');
            });
        }
    </script>
@endsection
