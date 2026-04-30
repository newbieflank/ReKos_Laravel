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

        .date-input {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Input asli disembunyikan tapi tetap bisa diklik di seluruh area */
        .date-input input[type="date"] {
            position: absolute;
            opacity: 0;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
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
        <form action="{{ route('payments.save1') }}" method="POST" id="bookingForm">
            @csrf
            <div class="main-layout">
                <div>
                    <div class="card">
                        <div class="property-header">
                            <div class="property-img" style="background-image: url('');"></div>
                            <div class="property-info">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span class="property-badge">{{ $kos->boardingHouse->boarding_house_type }}</span>
                                    <span class="property-rating">★ {{ $kos->boardingHouse->rating }}</span>
                                </div>
                                <div class="property-name">{{ $kos->boardingHouse->boarding_house_name }}</div>
                                <div class="property-location">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#666"
                                        stroke-width="2.5">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    {{ $kos->boardingHouse->alamat }}
                                </div>
                                <input type="hidden" id="room_id" name="room_id" value="{{ $kos->id }}">
                                <input type="hidden" id="boarding_house_id" name="boarding_house_id"
                                    value="{{ $kos->boardingHouse->id }}">
                                <div class="room-badge">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1D4ED8"
                                        stroke-width="2.5">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    </svg>
                                    {{ $kos->room_name }}
                                    <span class="amenity">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#555"
                                            stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                        </svg>
                                        {{ $kos->room_size }}
                                    </span>
                                    @foreach ($kos->facilities as $item)
                                        <span class="amenity">
                                            @if ($item == 'AC')
                                                <i class="bi bi-snow"></i>
                                            @elseif($item == 'WIFI')
                                                <i class="bi bi-wifi"></i>
                                            @elseif($item == 'Kamar Mandi')
                                                <i class="bi bi-droplet"></i>
                                            @elseif($item == 'Kursi')
                                                <i class="bi bi-chair"></i>
                                            @else
                                                <i class="bi bi-check-circle"></i>
                                            @endif
                                            {{ $item }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="section-title">Pilih Durasi Sewa</div>
                        <div class="duration-tabs">
                            <input type="hidden" name="duration_type" id="durationType" value="harian">
                            <input type="hidden" name="duratuon" id="durationType" value="harian">


                            <button type="button" class="duration-tab {{ $kos->daily_price > 0 ? '' : 'disabled' }}"
                                data-days="1" data-type="harian" {{ $kos->daily_price > 0 ? '' : 'disabled' }}
                                onclick="setTab(this)">Harian</button>

                            <button type="button" class="duration-tab {{ $kos->weekly_price > 0 ? '' : 'disabled' }}"
                                data-days="7" data-type="mingguan" {{ $kos->weekly_price > 0 ? '' : 'disabled' }}
                                onclick="setTab(this)">Mingguan</button>

                            <button type="button" class="duration-tab {{ $kos->monthly_price > 0 ? '' : 'disabled' }}"
                                data-days="30" data-type="bulanan" {{ $kos->monthly_price > 0 ? '' : 'disabled' }}
                                onclick="setTab(this)">Bulanan</button>
                        </div>
                        <div class="date-row">
                            <div class="date-group">
                                <label>Tanggal Masuk</label>
                                <div class="date-input">
                                    <span id="textCheckIn">12 Okt 2023</span>
                                    <i class="bi bi-calendar3"></i>
                                    <input type="date" id="checkInDate" name="start_date">
                                </div>
                            </div>

                            <div class="date-group">
                                <label>Tanggal Keluar</label>
                                <div class="date-input">
                                    <span id="textCheckOut">13 Okt 2023</span>
                                    <i class="bi bi-calendar3"></i>
                                    <input type="date" id="checkOutDate" name="end_date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-title">Rincian Pembayaran</div>
                    <div class="summary-row">
                        <span id="labelDurasi">Harga Sewa (1 Hari)</span>
                        <span id="displayTotalHarga">Rp {{ number_format($kos->daily_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Layanan</span>
                        <span>Rp 5.000</span>
                    </div>
                    <hr class="summary-divider">
                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span class="summary-total-amount" id="grandTotalText">Rp 355.000</span>
                        <input type="hidden" name="total_price" id="inputTotalPrice" value="0">
                    </div>
                    <div class="deposit-notice">
                        <i class="bi bi-info-circle"></i>
                        <span>Deposit akan dikembalikan penuh saat check-out jika tidak ada kerusakan pada fasilitas.</span>
                    </div>
                    <button type="submit" class="btn-primary">Lanjut ke Pembayaran</button>
                    <div class="terms-note">
                        Dengan menekan tombol di atas, Anda menyetujui
                        <a href="#">Syarat & Ketentuan</a> yang berlaku.
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Ambil harga langsung dari database, fallback ke 0 jika tidak ada
        const hargaHarian = {{ $kos->daily_price ?? 0 }};
        const hargaMingguan = {{ $kos->weekly_price ?? 0 }};
        const hargaBulanan = {{ $kos->monthly_price ?? 0 }};
        const biayaLayanan = 5000;

        const checkInInput = document.getElementById('checkInDate');
        const checkOutInput = document.getElementById('checkOutDate');
        const textCheckIn = document.getElementById('textCheckIn');
        const textCheckOut = document.getElementById('textCheckOut');

        function formatDateDisplay(dateString) {
            const options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        function updateSummary() {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            const activeTabElement = document.querySelector('.duration-tab.active');

            if (!activeTabElement || isNaN(checkIn) || isNaN(checkOut)) return;

            const activeTab = activeTabElement.getAttribute('data-days');
            const diffTime = checkOut - checkIn;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays <= 0) return;

            let sewaHarga = 0;
            let label = "";

            // Logika Perhitungan Berdasarkan Tab Aktif
            if (activeTab == "1") {
                sewaHarga = diffDays * hargaHarian;
                label = `Harga Sewa (${diffDays} Hari)`;
            } else if (activeTab == "7") {
                // Jika user pilih mingguan, kita hitung kelipatan minggunya
                const weeks = Math.ceil(diffDays / 7);
                sewaHarga = weeks * hargaMingguan;
                label = `Harga Sewa (${weeks} Minggu)`;
            } else if (activeTab == "30") {
                // Jika user pilih bulanan, kita hitung kelipatan bulannya
                const months = Math.ceil(diffDays / 30);
                sewaHarga = months * hargaBulanan;
                label = `Harga Sewa (${months} Bulan)`;
            }

            const totalFinal = sewaHarga + biayaLayanan;

            // Update UI
            const inputHarga = document.getElementById('inputTotalPrice');
            if (inputHarga) inputHarga.value = totalFinal;

            document.getElementById('labelDurasi').innerText = label;
            document.getElementById('displayTotalHarga').innerText = "Rp " + sewaHarga.toLocaleString('id-ID');
            document.getElementById('grandTotalText').innerText = "Rp " + totalFinal.toLocaleString('id-ID');
        }

        function setTab(element) {
            if (event) event.preventDefault();

            if (element.classList.contains('disabled')) return;

            document.querySelectorAll('.duration-tab').forEach(tab => tab.classList.remove('active'));
            element.classList.add('active');

            const days = parseInt(element.getAttribute('data-days'));
            const typeMapping = {
                "1": "harian",
                "7": "mingguan",
                "30": "bulanan"
            };

            document.getElementById('durationType').value = typeMapping[days];


            const startDate = new Date(checkInInput.value);
            if (!isNaN(startDate.getTime())) {
                const endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + days);

                const valEndDate = endDate.toISOString().split('T')[0];
                checkOutInput.value = valEndDate;
                textCheckOut.innerText = formatDateDisplay(valEndDate);
            }

            updateSummary();
        }

        window.onload = function() {
            const today = new Date();
            const valToday = today.toISOString().split('T')[0];
            checkInInput.value = valToday;
            textCheckIn.innerText = formatDateDisplay(valToday);

            const firstTab = document.querySelector('.duration-tab:not(.disabled)');
            if (firstTab) {
                setTab(firstTab);
            } else {
                updateSummary();
            }
        };

        checkInInput.addEventListener('change', function() {
            textCheckIn.innerText = formatDateDisplay(this.value);
            const activeTab = document.querySelector('.duration-tab.active');
            if (activeTab) setTab(activeTab);
        });

        checkOutInput.addEventListener('change', function() {
            const start = new Date(checkInInput.value);
            let end = new Date(this.value);
            const activeTab = document.querySelector('.duration-tab.active').getAttribute('data-days');
            const interval = parseInt(activeTab);

            if (end <= start) {
                alert("Tanggal keluar harus setelah tanggal masuk");
                end = new Date(start);
                end.setDate(start.getDate() + interval);
            } else {
                const diffTime = end - start;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (interval > 1) {
                    const multiplier = Math.ceil(diffDays / interval);
                    const fixedDays = multiplier * interval;

                    end = new Date(start);
                    end.setDate(start.getDate() + fixedDays);

                    // Beri tahu user (opsional)
                    if (diffDays % interval !== 0) {
                        alert(
                            `Untuk durasi ${document.querySelector('.duration-tab.active').innerText}, tanggal disesuaikan ke kelipatan ${interval} hari terdekat.`
                            );
                    }
                }
            }

            const finalDate = end.toISOString().split('T')[0];
            this.value = finalDate;
            textCheckOut.innerText = formatDateDisplay(finalDate);

            updateSummary();
        });
    </script>
@endsection
