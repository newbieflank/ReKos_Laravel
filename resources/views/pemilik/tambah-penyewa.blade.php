@extends('layouts.pemilik')

@section('title', 'Tambah Penyewa - RE-KOST')

@section('content')
    <style>
        .container-fluid-custom {
            width: 100%;
            padding: 0 16px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #212529;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title:hover {
            color: #0d47a1;
        }

        .stepper-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 40px 0;
            overflow-x: auto;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .step-circle.active {
            background-color: #0d47a1;
            color: white;
        }

        .step-circle.inactive {
            background-color: #e9ecef;
            color: #adb5bd;
        }

        .step-circle.completed {
            background-color: #e6f0ff;
            color: #0d47a1;
        }

        .step-label {
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.3s;
        }

        .step-label.active {
            color: #0d47a1;
        }

        .step-label.inactive {
            color: #adb5bd;
        }

        .step-line {
            height: 2px;
            width: 50px;
            background-color: #e9ecef;
            margin: 0 16px;
            transition: all 0.3s;
        }

        .step-line.completed {
            background-color: #0d47a1;
        }

        .form-section-card {
            background-color: #f8f9fa;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #f1f3f5;
        }

        .section-icon-box {
            width: 40px;
            height: 40px;
            background-color: #e3f2fd;
            color: #0d6efd;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .form-label-custom {
            font-size: 0.7rem;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-control-custom {
            background-color: #fff;
            border: 1px solid #fff;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #495057;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .form-control-grey {
            background-color: #e9ecef;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #495057;
        }

        .toggle-radio {
            display: none;
        }

        .toggle-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.2s;
            width: 100%;
        }

        .toggle-radio:checked+.toggle-label {
            border-color: #0d47a1;
            color: #0d47a1;
            background-color: #f8fbff;
        }

        .room-select-radio {
            display: none;
        }

        .room-select-card {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            height: 100%;
        }

        .room-select-radio:checked+.room-select-card {
            border-color: #0d47a1;
            background-color: #f8fbff;
            box-shadow: 0 4px 10px rgba(13, 71, 161, 0.1);
        }

        .room-select-radio:checked+.room-select-card::after {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #0d47a1;
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 1.2rem;
        }

        .room-badge-small {
            font-size: 0.6rem;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .bg-suite {
            background-color: #4a6ee0;
            color: white;
        }

        .bg-standard {
            background-color: #e9ecef;
            color: #495057;
        }

        .summary-box {
            background-color: #f1f3f5;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .confirm-card {
            background-color: #fff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #f1f3f5;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .invoice-card {
            background-color: #f8fbff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e6f0ff;
        }

        .btn-cancel {
            color: #6c757d;
            font-weight: 600;
            background: transparent;
            border: none;
            padding: 10px 20px;
        }

        .btn-cancel:hover {
            color: #212529;
        }

        .btn-primary-custom {
            background-color: #0d47a1;
            color: white;
            border-radius: 8px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
            transition: 0.2s;
            width: 100%;
        }

        .btn-primary-custom:hover {
            background-color: #0b3c87;
        }

        .btn-secondary-custom {
            background-color: #e9ecef;
            color: #495057;
            border-radius: 8px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
            transition: 0.2s;
            width: 100%;
        }

        .btn-secondary-custom:hover {
            background-color: #dee2e6;
        }
    </style>

    <div class="container-fluid-custom pb-5">

        <a href="{{ route('pemilik.penyewa') }}" class="page-title mt-2">
            <i class="fa-solid fa-chevron-left"></i> Tambah Penyewa
        </a>

        <div class="stepper-container">
            <div class="d-flex align-items-center">
                <div class="step-circle active" id="circle-1">1</div>
                <div class="step-label active ms-2" id="label-1">Profil Penyewa</div>
            </div>
            <div class="step-line" id="line-1"></div>
            <div class="d-flex align-items-center">
                <div class="step-circle inactive" id="circle-2">2</div>
                <div class="step-label inactive ms-2" id="label-2">Detail Sewa & Pembayaran</div>
            </div>
            <div class="step-line" id="line-2"></div>
            <div class="d-flex align-items-center">
                <div class="step-circle inactive" id="circle-3">3</div>
                <div class="step-label inactive ms-2" id="label-3">Konfirmasi</div>
            </div>
        </div>

        <form id="tambahPenyewaForm" action="{{ route('pemilik.penyewa.simpan') }}" method="POST">
            <input type="hidden" name="room_id" id="hidden_room_id" value="{{ $selectedRoomId }}">
            <input type="hidden" name="total_price" id="hidden_total_price" value="0">
            @csrf

            <div id="step-1">
                <div class="form-section-card">
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="section-icon-box"><i class="fa-solid fa-user-check"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Pilih User Terdaftar</h6>
                            <p class="text-secondary small mb-0">Cari pengguna yang sudah memiliki akun dalam sistem</p>
                        </div>
                    </div>
                    <select name="tenant_id" id="select_tenant" class="form-select form-control-custom w-100" required>
                        <option value="">-- Pilih Pengguna --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-gender="{{ $user->userDetail->gender ?? 'unknown' }}"
                                data-birth="{{ $user->userDetail->birth_date ?? '' }}"
                                data-occ="{{ $user->userDetail->occupation ?? '' }}"
                                data-inst="{{ $user->userDetail->institution ?? '' }}">
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-section-card">
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="section-icon-box"><i class="fa-solid fa-address-card"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Informasi Pribadi</h6>
                            <p class="text-secondary small mb-0">Data diambil otomatis dari akun pengguna yang dipilih</p>
                        </div>
                    </div>

                    {{-- Hidden inputs untuk dikirim ke backend --}}
                    <input type="hidden" name="gender" id="hidden_gender" value="">
                    <input type="hidden" name="birth_date" id="hidden_birth_date" value="">
                    <input type="hidden" name="occupation" id="hidden_occupation" value="">
                    <input type="hidden" name="institution" id="hidden_institution" value="">

                    <div id="user_info_empty" class="text-center py-4 text-muted small">
                        <i class="fa-solid fa-circle-info me-2"></i> Pilih pengguna di atas untuk melihat data profilnya.
                    </div>

                    <div id="user_info_card" class="d-none">
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <p class="form-label-custom">NAMA LENGKAP</p>
                                <p class="text-dark fw-bold mb-0" id="display_name">-</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="form-label-custom">JENIS KELAMIN</p>
                                <p class="text-dark fw-bold mb-0" id="display_gender">-</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="form-label-custom">TANGGAL LAHIR</p>
                                <p class="text-dark fw-bold mb-0" id="display_birth">-</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="form-label-custom">PEKERJAAN</p>
                                <p class="text-dark fw-bold mb-0" id="display_occ">-</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="form-label-custom">INSTANSI</p>
                                <p class="text-dark fw-bold mb-0" id="display_inst">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-4 gap-3">
                    <a href="{{ route('pemilik.penyewa') }}" class="btn-cancel text-decoration-none">Batal</a>
                    <button type="button" class="btn-primary-custom w-auto" onclick="goToStep(2)">Selanjutnya</button>
                </div>
            </div>

            <div id="step-2" class="d-none">
                <div class="form-section-card">
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="section-icon-box"><i class="fa-solid fa-bed"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Pilih Kamar yang Tersedia</h6>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        @forelse($rooms as $room)
                        <div class="col-12 col-md-4">
                            <input type="radio" name="room_select" id="room_{{ $room->id }}" class="room-select-radio"
                                data-id="{{ $room->id }}"
                                data-name="{{ $room->room_name }}"
                                data-type="{{ $room->room_type }}"
                                data-daily="{{ $room->daily_price ?? 0 }}"
                                data-weekly="{{ $room->weekly_price ?? 0 }}"
                                data-monthly="{{ $room->monthly_price ?? 0 }}"
                                {{ ($selectedRoomId == $room->id) ? 'checked' : '' }}>
                            <label for="room_{{ $room->id }}" class="room-select-card d-block">
                                <span class="room-badge-small bg-{{ $room->room_type == 'Deluxe' ? 'suite' : 'standard' }} mb-2 d-inline-block">{{ strtoupper($room->room_type) }}</span>
                                <p class="text-muted small mb-0" style="font-size: 0.7rem;">ROOM</p>
                                <h4 class="fw-bold text-dark mb-4">{{ $room->room_name }}</h4>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <span class="room-price-label text-secondary small">Rp {{ number_format($room->monthly_price,0,',','.') }}/bln</span>
                                </div>
                            </label>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-muted text-center">Tidak ada kamar yang tersedia.</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">TIPE SEWA</label>
                            <select name="rental_type" id="select_rental_type" class="form-select form-control-grey text-dark" required>
                                <option value="monthly">Bulanan</option>
                                <option value="weekly">Mingguan</option>
                                <option value="daily">Harian</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">STATUS SEWA</label>
                            <div class="d-flex p-1" style="background-color: #e9ecef; border-radius: 8px;">
                                <input type="radio" name="status_sewa" id="sewaAktif" value="active" class="toggle-radio" checked>
                                <label for="sewaAktif" class="toggle-label border-0 m-0 py-2">Aktif</label>
                                <input type="radio" name="status_sewa" id="sewaPending" value="pending" class="toggle-radio">
                                <label for="sewaPending" class="toggle-label border-0 m-0 py-2"
                                    style="background:transparent; color:#6c757d;">Pending</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">TANGGAL MASUK</label>
                            <input type="date" name="start_date" id="input_start_date" class="form-control form-control-grey" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">TANGGAL KELUAR (OPSIONAL)</label>
                            <input type="date" name="end_date" id="input_end_date" class="form-control form-control-grey">
                        </div>
                    </div>
                </div>

                <div class="form-section-card">
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="section-icon-box" style="background-color: #e0f8f1; color: #20c997;"><i
                                class="fa-solid fa-money-bill-wave"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Detail Pembayaran</h6>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="mb-4">
                                <label class="form-label-custom">JUMLAH PEMBAYARAN</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0"
                                        style="background-color: #e9ecef; color: #495057; font-weight: 600;">Rp</span>
                                    <input type="number" name="total_price" id="input_total_price" class="form-control form-control-grey text-dark fw-bold"
                                        placeholder="0">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label-custom">STATUS PEMBAYARAN</label>
                                <div class="d-flex gap-2">
                                    <div class="w-100">
                                        <input type="radio" name="status_bayar" id="bayarLunas" class="toggle-radio"
                                            checked>
                                        <label for="bayarLunas" class="toggle-label"><i
                                                class="fa-solid fa-check-circle"></i> Lunas</label>
                                    </div>
                                    <div class="w-100">
                                        <input type="radio" name="status_bayar" id="bayarBelum" class="toggle-radio">
                                        <label for="bayarBelum" class="toggle-label"><i class="fa-solid fa-clock"></i>
                                            Belum Lunas</label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="form-label-custom">TANGGAL PEMBAYARAN</label>
                                <input type="date" class="form-control form-control-grey text-dark"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="summary-box">
                                <div class="d-flex justify-content-between mb-2"><span class="text-secondary small">Kamar</span><span class="text-dark fw-bold small" id="summary_room_label">-</span></div>
                                <div class="d-flex justify-content-between mb-2"><span class="text-secondary small">Tipe Sewa</span><span class="text-dark fw-bold small" id="summary_rental_type">-</span></div>
                                <div class="d-flex justify-content-between mb-4 pb-4 border-bottom"><span
                                        class="text-secondary small">Harga Kamar/Bulan</span><span
                                        class="text-dark fw-bold small" id="summary_room_price">-</span></div>
                                <div class="d-flex justify-content-between align-items-center"><span
                                        class="text-secondary fw-bold" style="font-size: 0.8rem;">TOTAL
                                        TAGIHAN</span><span class="text-primary fw-bold fs-4" id="summary_total">-</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="button" class="btn-secondary-custom w-auto" onclick="goToStep(1)"><i
                            class="fa-solid fa-arrow-left me-2"></i> Kembali</button>
                    <button type="button" class="btn-primary-custom w-auto" onclick="goToStep(3)">Selanjutnya <i
                            class="fa-solid fa-arrow-right ms-2"></i></button>
                </div>
            </div>

            <div id="step-3" class="d-none">
                <div class="mb-4">
                    <h3 class="text-dark fw-bold mb-1">Konfirmasi Pendaftaran</h3>
                    <p class="text-secondary small">Tinjau kembali data pendaftaran penyewa sebelum disimpan.</p>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div class="confirm-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="section-icon-box"><i class="fa-solid fa-user"></i></div>
                                    <h5 class="fw-bold text-dark mb-0">Profil Penyewa</h5>
                                </div>
                                <a href="#" onclick="goToStep(1)"
                                    class="text-primary text-decoration-none small fw-bold">Edit</a>
                            </div>
                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <p class="form-label-custom">NAMA LENGKAP</p>
                                    <p class="text-dark fw-bold mb-0" id="conf_name">-</p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p class="form-label-custom">JENIS KELAMIN</p>
                                    <p class="text-dark fw-bold mb-0" id="conf_gender">-</p>
                                </div>
                            </div>
                        </div>

                        <div class="confirm-card mb-0">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="section-icon-box"><i class="fa-solid fa-bed"></i></div>
                                    <h5 class="fw-bold text-dark mb-0">Detail Sewa</h5>
                                </div>
                                <a href="#" onclick="goToStep(2)"
                                    class="text-primary text-decoration-none small fw-bold">Edit</a>
                            </div>
                            <div class="d-flex align-items-center gap-4 mb-4">
                                <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3 border">
                                    <div class="bg-primary text-white rounded px-2 py-1 fw-bold fs-5" id="conf_room_name">-</div>
                                    <div>
                                        <p class="text-muted small mb-0" style="font-size: 0.65rem;">Tipe Kamar</p>
                                        <p class="text-dark fw-bold mb-0" id="conf_room_type">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="invoice-card h-100 d-flex flex-column">
                            <h5 class="fw-bold text-primary mb-4">Ringkasan Pembayaran</h5>
                            <div class="mb-4">
                                <p class="form-label-custom mb-1">TOTAL BILLING</p>
                                <h3 class="text-primary fw-bold mb-0" id="conf_total">-</h3>
                            </div>
                            <div class="bg-white p-3 rounded border mb-4">
                                <div class="form-check">
                                    <input class="form-check-input mt-1" type="checkbox" id="confirmData">
                                    <label class="form-check-label text-secondary" for="confirmData"
                                        style="font-size: 0.75rem;">Saya mengonfirmasi bahwa seluruh data benar.</label>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <button type="submit" class="btn-primary-custom mb-2">Simpan & Selesaikan <i
                                        class="fa-solid fa-arrow-right ms-2"></i></button>
                                <button type="button" class="btn-secondary-custom"
                                    onclick="goToStep(2)">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function formatRp(n) {
                if (!n) return 'Rp 0';
                return 'Rp ' + parseInt(n).toLocaleString('id-ID');
            }

            // Saat pilih user, auto-fill info pribadi
            document.getElementById('select_tenant').addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                if (!opt.value) {
                    document.getElementById('user_info_empty').classList.remove('d-none');
                    document.getElementById('user_info_card').classList.add('d-none');
                    return;
                }
                const gender = opt.dataset.gender;
                const genderLabel = gender === 'female' ? 'Perempuan' : (gender === 'male' ? 'Laki-laki' : '-');

                // Isi display (read-only)
                document.getElementById('display_name').innerText = opt.dataset.name || '-';
                document.getElementById('display_gender').innerText = genderLabel;
                document.getElementById('display_birth').innerText = opt.dataset.birth || '-';
                document.getElementById('display_occ').innerText = opt.dataset.occ || '-';
                document.getElementById('display_inst').innerText = opt.dataset.inst || '-';

                // Isi hidden inputs untuk dikirim ke backend
                document.getElementById('hidden_gender').value = gender || 'unknown';
                document.getElementById('hidden_birth_date').value = opt.dataset.birth || '';
                document.getElementById('hidden_occupation').value = opt.dataset.occ || '';
                document.getElementById('hidden_institution').value = opt.dataset.inst || '';

                document.getElementById('user_info_empty').classList.add('d-none');
                document.getElementById('user_info_card').classList.remove('d-none');

                // Isi konfirmasi
                document.getElementById('conf_name').innerText = opt.dataset.name || '-';
                document.getElementById('conf_gender').innerText = genderLabel;
            });

            // Fungsi utama: update harga & tanggal dari pilihan kamar + tipe sewa
            function updatePriceAndDate() {
                const checkedRm = document.querySelector('.room-select-radio:checked');
                const rentalSel = document.getElementById('select_rental_type');
                if (!checkedRm || !rentalSel) return;

                const type = rentalSel.value; // daily, weekly, monthly
                const durationMap = { daily: 1, weekly: 7, monthly: 30 };
                const days = durationMap[type] || 30;

                // Ambil harga sesuai tipe sewa
                const priceMap = {
                    daily: checkedRm.dataset.daily,
                    weekly: checkedRm.dataset.weekly,
                    monthly: checkedRm.dataset.monthly
                };
                const price = priceMap[type] || 0;

                // Update label harga di kartu kamar
                const labelMap = { daily: 'hari', weekly: 'minggu', monthly: 'bulan' };
                checkedRm.closest('.col-12').querySelector('.room-price-label').innerText =
                    'Rp ' + parseInt(price).toLocaleString('id-ID') + '/' + labelMap[type];

                // Update field total harga
                document.getElementById('input_total_price').value = price;

                // Update summary box
                document.getElementById('summary_room_label').innerText = checkedRm.dataset.name;
                document.getElementById('summary_room_price').innerText = formatRp(price);
                document.getElementById('summary_total').innerText = formatRp(price);
                document.getElementById('summary_rental_type').innerText = rentalSel.options[rentalSel.selectedIndex].text;
                document.getElementById('hidden_room_id').value = checkedRm.dataset.id;

                // Hitung tanggal keluar dari tanggal masuk
                const startInput = document.getElementById('input_start_date');
                if (startInput.value) {
                    const startDate = new Date(startInput.value);
                    startDate.setDate(startDate.getDate() + days);
                    const yyyy = startDate.getFullYear();
                    const mm = String(startDate.getMonth() + 1).padStart(2, '0');
                    const dd = String(startDate.getDate()).padStart(2, '0');
                    document.getElementById('input_end_date').value = `${yyyy}-${mm}-${dd}`;
                }
            }

            // Saat pilih kamar
            document.querySelectorAll('.room-select-radio').forEach(function(radio) {
                radio.addEventListener('change', updatePriceAndDate);
            });

            // Saat ubah tipe sewa
            document.getElementById('select_rental_type').addEventListener('change', updatePriceAndDate);

            // Saat ubah tanggal masuk
            document.getElementById('input_start_date').addEventListener('change', updatePriceAndDate);

            // Trigger saat halaman load
            const checkedRoom = document.querySelector('.room-select-radio:checked');
            if (checkedRoom) updatePriceAndDate();

            function goToStep(step) {
                if (step === 3) {
                    const tenantOpt = document.getElementById('select_tenant');
                    const selOpt = tenantOpt.options[tenantOpt.selectedIndex];
                    // conf_name & conf_gender sudah diisi saat pilih user

                    const checkedRm = document.querySelector('.room-select-radio:checked');
                    document.getElementById('conf_room_name').innerText = checkedRm ? checkedRm.dataset.name : '-';
                    document.getElementById('conf_room_type').innerText = checkedRm ? checkedRm.dataset.type : '-';

                    const total = document.getElementById('input_total_price').value;
                    document.getElementById('conf_total').innerText = formatRp(total);

                    const rentalSel = document.getElementById('select_rental_type');
                    document.getElementById('summary_rental_type').innerText = rentalSel.options[rentalSel.selectedIndex].text;
                }

                document.getElementById('step-1').classList.add('d-none');
                document.getElementById('step-2').classList.add('d-none');
                document.getElementById('step-3').classList.add('d-none');
                document.getElementById('step-' + step).classList.remove('d-none');

                for (let i = 1; i <= 3; i++) {
                    const circle = document.getElementById('circle-' + i);
                    const label = document.getElementById('label-' + i);
                    const line = document.getElementById('line-' + (i - 1));

                    circle.className = 'step-circle inactive';
                    label.className = 'step-label inactive ms-2';
                    if (line) line.className = 'step-line';

                    if (i < step) {
                        circle.className = 'step-circle completed';
                        circle.innerHTML = '<i class="fa-solid fa-check"></i>';
                        if (line) line.className = 'step-line completed';
                    } else if (i === step) {
                        circle.className = 'step-circle active';
                        circle.innerHTML = i;
                        label.className = 'step-label active ms-2';
                        if (line) line.className = 'step-line completed';
                    } else {
                        circle.innerHTML = i;
                    }
                }
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        </script>
    @endpush
@endsection
