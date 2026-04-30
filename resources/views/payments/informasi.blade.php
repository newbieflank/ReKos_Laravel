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
            padding: 0;
        }

        .stepper-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            padding: 32px 0 28px;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
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
            z-index: 1;
        }

        .step-circle.active {
            background: #1E3A8A;
            border-color: #1E3A8A;
            color: #fff;
        }

        .step-circle.done {
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

        .property-header {
            display: flex;
            gap: 18px;
            align-items: flex-start;
        }

        .property-img {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
            background: #ccc;
            flex-shrink: 0;
        }

        .property-img-placeholder {
            width: 130px;
            height: 90px;
            border-radius: 10px;
            background: linear-gradient(135deg, #b0b8c8 0%, #8a95a5 100%);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 30px;
        }

        .property-info {
            flex: 1;
        }

        .property-badge {
            display: inline-block;
            background: #EFF6FF;
            color: #1D4ED8;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 3px 10px;
            border-radius: 4px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .property-name {
            font-size: 20px;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .property-location {
            color: #666;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .property-rating {
            font-size: 13px;
            color: #F59E0B;
            font-weight: 700;
            margin-left: 8px;
        }

        .room-badge {
            margin-top: 12px;
            background: #EFF6FF;
            border-radius: 10px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1D4ED8;
            font-size: 14px;
            font-weight: 700;
        }

        .room-badge .amenity {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #555;
            font-weight: 400;
            font-size: 12px;
            margin-left: 8px;
        }

        /* DURATION PICKER */
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 18px;
        }

        .duration-tabs {
            display: flex;
            background: #F1F5F9;
            border-radius: 10px;
            padding: 4px;
            gap: 4px;
            margin-bottom: 22px;
        }

        .duration-tab {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            color: #666;
            border: none;
            background: transparent;
            transition: all 0.2s;
        }

        .duration-tab.active {
            background: #fff;
            color: #1E3A8A;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
        }

        .date-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .date-group label {
            font-size: 12px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            display: block;
            margin-bottom: 6px;
        }

        .date-input {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            color: #1a1a2e;
            cursor: pointer;
            background: #fff;
            transition: border-color 0.2s;
        }

        .date-input:hover {
            border-color: #1E3A8A;
        }

        .date-input svg {
            color: #888;
        }

        .summary-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14px;
            color: #444;
        }

        .summary-divider {
            border: none;
            border-top: 1.5px dashed #E2E8F0;
            margin: 16px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            font-weight: 700;
        }

        .summary-total-amount {
            color: #1E3A8A;
            font-size: 20px;
        }

        .deposit-notice {
            background: #FFF7ED;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 12px;
            color: #92400E;
            margin: 16px 0;
            display: flex;
            gap: 8px;
            align-items: flex-start;
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
            letter-spacing: 0.3px;
        }

        .btn-primary:hover {
            background: #1e40af;
            transform: translateY(-1px);
        }

        .terms-note {
            font-size: 11px;
            color: #999;
            text-align: center;
            margin-top: 12px;
            line-height: 1.5;
        }

        .terms-note a {
            color: #1E3A8A;
        }
    </style>

    <div class="page-wrapper">

        <div class="stepper-wrapper">
            <div class="step-item">
                <div class="step-circle active">1</div>
                <div class="step-label active">Informasi</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">2</div>
                <div class="step-label">Pembayaran</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <div class="step-label">Selesai</div>
            </div>
        </div>

        <div class="main-layout">
            <div>

                <div class="card">
                    <div class="property-header">
                        <div class="property-img" style="background-image: url('');"></div>
                        <div class="property-info">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span class="property-badge">Kost Campur</span>
                                <span class="property-rating">★ 4.8</span>
                            </div>
                            <div class="property-name">Kost Mentari Residence</div>
                            <div class="property-location">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#666"
                                    stroke-width="2.5">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                                Kebayoran Baru, Jakarta Selatan
                            </div>
                            <div class="room-badge">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1D4ED8"
                                    stroke-width="2.5">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                </svg>
                                Kamar Superior - No. 102
                                <span class="amenity">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#555"
                                        stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                    </svg>
                                    12 m²
                                </span>
                                <span class="amenity">
                                    <i class="bi bi-snow"></i> AC
                                </span>

                                <span class="amenity">
                                    <i class="bi bi-wifi"></i> WiFi
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="section-title">Pilih Durasi Sewa</div>
                    <div class="duration-tabs">
                        <button class="duration-tab active" onclick="setTab(this)">Harian</button>
                        <button class="duration-tab" onclick="setTab(this)">Mingguan</button>
                        <button class="duration-tab" onclick="setTab(this)">Bulanan</button>
                    </div>
                    <div class="date-row">
                        <div class="date-group">
                            <label>Tanggal Masuk</label>
                            <div class="date-input">
                                <span>12 Okt 2023</span>
                                <i class="bi bi-calendar3"></i>
                            </div>
                        </div>

                        <div class="date-group">
                            <label>Tanggal Keluar</label>
                            <div class="date-input">
                                <span>12 Okt 2023</span>
                                <i class="bi bi-calendar3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-title">Rincian Pembayaran</div>
                <div class="summary-row">
                    <span>Harga Sewa (1 Hari)</span>
                    <span>Rp 250.000</span>
                </div>
                <div class="summary-row">
                    <span>Biaya Layanan</span>
                    <span>Rp 5.000</span>
                </div>
                <hr class="summary-divider">
                <div class="summary-total">
                    <span>Total Pembayaran</span>
                    <span class="summary-total-amount">Rp 355.000</span>
                </div>
                <div class="deposit-notice">
                    <i class="bi bi-info-circle"></i>
                    <span>Deposit akan dikembalikan penuh saat check-out jika tidak ada kerusakan pada fasilitas.</span>
                </div>
                <a href="{{ route('payments.pembayaran') }}">
                    <button class="btn-primary">Lanjut ke Pembayaran</button>
                </a>
                <div class="terms-note">
                    Dengan menekan tombol di atas, Anda menyetujui
                    <a href="#">Syarat & Ketentuan</a> yang berlaku.
                </div>
            </div>
        </div>
    </div>

    <script>
        function setTab(el) {
            document.querySelectorAll('.duration-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }
    </script>
@endsection
