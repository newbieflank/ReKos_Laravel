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
            z-index: 1;
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

        /* LAYOUT */
        .main-layout {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px 60px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 28px;
            align-items: start;
        }

        /* CARD */
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 28px 32px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        /* PAYMENT METHOD */
        .card-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 20px;
        }

        .method-section {
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .method-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            cursor: pointer;
            background: #fff;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            user-select: none;
        }

        .method-header:hover {
            background: #F8FAFC;
        }

        .method-header svg {
            transition: transform 0.2s;
        }

        .method-header.open svg {
            transform: rotate(180deg);
        }

        .method-body {
            padding: 12px 16px 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            border-top: 1.5px solid #E2E8F0;
            background: #FAFBFF;
        }

        .method-body.hidden {
            display: none;
        }

        /* BANK/EWALLET OPTION */
        .pay-option {
            flex: 0 0 calc(25% - 8px);
            min-width: 100px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            padding: 12px 10px;
            cursor: pointer;
            text-align: center;
            transition: all 0.15s;
            background: #fff;
        }

        .pay-option:hover {
            border-color: #1E3A8A;
            background: #EFF6FF;
        }

        .pay-option.selected {
            border-color: #1E3A8A;
            background: #EFF6FF;
            box-shadow: 0 0 0 2px #bfdbfe;
        }

        .pay-option-logo {
            font-size: 11px;
            font-weight: 800;
            color: #1E3A8A;
            display: block;
            margin-bottom: 4px;
        }

        .pay-option-label {
            font-size: 11px;
            color: #555;
            font-weight: 500;
        }

        /* e-wallet icons */
        .ewallet-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 12px 16px 16px;
            border-top: 1.5px solid #E2E8F0;
            background: #FAFBFF;
        }

        .ewallet-option {
            flex: 0 0 calc(33.33% - 8px);
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            padding: 12px 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.15s;
        }

        .ewallet-option:hover {
            border-color: #1E3A8A;
            background: #EFF6FF;
        }

        .ewallet-option.selected {
            border-color: #1E3A8A;
            background: #EFF6FF;
        }

        .ew-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .ew-gopay {
            background: #00AE42;
        }

        .ew-ovo {
            background: #4C2B8C;
        }

        .ew-dana {
            background: #1678FB;
        }

        /* CREDIT CARD */
        .cc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            cursor: pointer;
            background: #fff;
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .cc-cards {
            display: flex;
            gap: 6px;
        }

        .cc-brand {
            background: #f0f0f0;
            border-radius: 5px;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: 700;
            color: #666;
        }

        /* SECURITY NOTICE */
        .security-notice {
            background: #EFF6FF;
            border-radius: 12px;
            padding: 14px 18px;
            margin-top: 18px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: #1E3A8A;
            line-height: 1.5;
        }

        /* SUMMARY CARD */
        .summary-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 20px;
        }

        .summary-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .order-room-box {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding-bottom: 16px;
            border-bottom: 1px solid #F1F5F9;
            margin-bottom: 16px;
        }

        .room-thumb {
            width: 64px;
            height: 64px;
            border-radius: 10px;
            background: linear-gradient(135deg, #b0b8c8 0%, #8a95a5 100%);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .room-info {
            font-size: 14px;
        }

        .room-name {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 2px;
        }

        .room-loc {
            color: #777;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .room-date {
            color: #1D4ED8;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
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
            border-top: 1px solid #E2E8F0;
            margin: 12px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: 700;
        }

        .summary-total-amt {
            color: #1E3A8A;
            font-size: 18px;
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
            margin-top: 18px;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: #1e40af;
            transform: translateY(-1px);
        }

        .security-badges {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 14px;
        }

        .badge-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #888;
            font-weight: 600;
        }

        .terms-note {
            font-size: 11px;
            color: #999;
            text-align: center;
            margin-top: 10px;
            line-height: 1.5;
        }

        .terms-note a {
            color: #1E3A8A;
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
                <div class="step-circle active">2</div>
                <div class="step-label active">Pembayaran</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <div class="step-label">Selesai</div>
            </div>
        </div>

        <form action="{{ route('payments.save2') }}" method="POST" id="paymentForm">
            @csrf
            <div class="main-layout">
                <div>
                    <div class="card">
                        <div class="card-title">Pilih Metode Pembayaran</div>

                        <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="BRI Virtual">
                        <div class="method-section">
                            <div class="method-header open" onclick="toggleSection(this)">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#333"
                                        stroke-width="2">
                                        <rect x="2" y="7" width="20" height="15" rx="2" />
                                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                                        <line x1="12" y1="12" x2="12" y2="16" />
                                    </svg>
                                    Transfer Bank (Virtual Account)
                                </div>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#888"
                                    stroke-width="2.5">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </div>
                            <div class="method-body" id="bank-body">
                                <div class="pay-option" onclick="selectOption(this)">
                                    <span class="pay-option-logo" style="color:#005BAA;">BCA</span>
                                    <span class="pay-option-label">BCA Transfer</span>
                                </div>
                                <div class="pay-option" onclick="selectOption(this)">
                                    <span class="pay-option-logo" style="color:#F37021;">BNI</span>
                                    <span class="pay-option-label">BNI Transfer</span>
                                </div>
                                <div class="pay-option" onclick="selectOption(this)">
                                    <span class="pay-option-logo" style="color:#003087;">MANDIRI</span>
                                    <span class="pay-option-label">Mandiri VA</span>
                                </div>
                                <div class="pay-option selected" onclick="selectOption(this)">
                                    <span class="pay-option-logo" style="color:#005BAA;">BRI</span>
                                    <span class="pay-option-label">BRI Virtual</span>
                                </div>
                            </div>
                        </div>

                        <div class="method-section">
                            <div class="method-header open" onclick="toggleSection(this)">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#333"
                                        stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2" />
                                        <line x1="1" y1="10" x2="23" y2="10" />
                                    </svg>
                                    E-Wallet
                                </div>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#888"
                                    stroke-width="2.5">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </div>
                            <div class="ewallet-row" id="ewallet-body">
                                <div class="ewallet-option" onclick="selectOption(this)">
                                    <span class="ew-icon ew-gopay">Go</span>
                                    <span>GoPay</span>
                                </div>
                                <div class="ewallet-option" onclick="selectOption(this)">
                                    <span class="ew-icon ew-ovo">OVO</span>
                                    <span>OVO</span>
                                </div>
                                <div class="ewallet-option" onclick="selectOption(this)">
                                    <span class="ew-icon ew-dana">D</span>
                                    <span>DANA</span>
                                </div>
                            </div>
                        </div>

                        <div class="method-section">
                            <div class="cc-header">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="#333" stroke-width="2">
                                        <rect x="1" y="4" width="22" height="16" rx="2" />
                                        <line x1="1" y1="10" x2="23" y2="10" />
                                    </svg>
                                    Kartu Kredit
                                </div>
                                <div class="cc-cards">
                                    <span class="cc-brand">VISA</span>
                                    <span class="cc-brand">MC</span>
                                </div>
                            </div>
                        </div>

                        <div class="security-notice">
                            <i class="bi bi-info-circle"></i>
                            <span>
                                Pembayaran Anda aman dan terenkripsi. Detail pembayaran akan dikirimkan ke email Anda segera
                                setelah transaksi selesai.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-title">Ringkasan Pesanan</div>
                    <div class="order-room-box">
                        <div class="room-thumb">
                            <img src="{{ asset($kos->main_image) }}"
                                style="width: 64px; height: 64px; border-radius: 10px;" alt="Foto Kamar Utama">
                        </div>
                        <div class="room-info">
                            <div class="room-name">{{ $kos->boardingHouse->boarding_house_name }} - {{ $kos->room_name }}
                            </div>
                            <div class="room-loc">{{ $kos->boardingHouse->alamat }}</div>
                            <div class="room-date">
                                <i class="bi bi-calendar3"></i>
                                {{ ucfirst($bookingData['duration_type']) }}
                                ({{ \Carbon\Carbon::parse($bookingData['start_date'])->format('d M') }} –
                                {{ \Carbon\Carbon::parse($bookingData['end_date'])->format('d M Y') }})
                            </div>
                        </div>
                    </div>
                    <div class="summary-row">
                        <span>Harga Sewa ({{ ucfirst($bookingData['duration_type']) }})</span>
                        <span>Rp {{ number_format($bookingData['total_price'] - 5000, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Layanan</span>
                        <span>Rp 5.000</span>
                    </div>
                    <hr class="summary-divider">
                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span class="summary-total-amt">Rp
                            {{ number_format($bookingData['total_price'], 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" form="paymentForm" class="btn-primary">Bayar Sekarang ...</button>
                    <div class="terms-note">
                        Dengan menekan tombol di atas, Anda menyetujui
                        <a href="#">Syarat & Ketentuan</a> serta
                        <a href="#">Kebijakan Privasi</a> Re-Kost.
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleSection(header) {
            const body = header.nextElementSibling;
            header.classList.toggle('open');
            body.classList.toggle('hidden');
        }

        function selectOption(element) {
            document.querySelectorAll('.pay-option, .ewallet-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            element.classList.add('selected');
            let label = "";
            const labelElement = element.querySelector('.pay-option-label');

            if (labelElement) {
                label = labelElement.innerText;
            } else {
                label = element.querySelector('span:last-child').innerText;
            }
            document.getElementById('selectedPaymentMethod').value = label;
        }
    </script>
@endsection
