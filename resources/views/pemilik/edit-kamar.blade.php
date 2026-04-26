@extends('layouts.pemilik')

@section('title', 'Edit Kamar - RE-KOST')

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
            color: #0d6efd;
        }

        .stepper-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 40px 0;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .step-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 2;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f8f9fa;
            color: #adb5bd;
            border: 2px solid transparent;
        }

        .step-circle.active {
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }

        .step-circle.completed {
            background-color: #e6f0ff;
            color: #0d6efd;
            border-color: #0d6efd;
        }

        .step-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #adb5bd;
            transition: all 0.3s;
        }

        .step-label.active {
            color: #0d6efd;
        }

        .step-line {
            flex-grow: 1;
            height: 2px;
            background-color: #e9ecef;
            margin: 0 -20px;
            position: relative;
            top: -12px;
            z-index: 1;
            transition: all 0.3s;
        }

        .step-line.completed {
            background-color: #0d6efd;
        }

        .form-section-card {
            background-color: #fff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            border: 1px solid #f1f3f5;
        }

        .form-label-custom {
            font-size: 0.75rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control-custom {
            background-color: #f8f9fa;
            border: 1px solid #f8f9fa;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #495057;
            transition: border-color 0.2s;
        }

        .form-control-custom:focus {
            border-color: #0d6efd;
            background-color: #fff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        }

        .facility-check {
            display: none;
        }

        .facility-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            height: 100%;
            min-height: 100px;
            gap: 8px;
            color: #6c757d;
        }

        .facility-card i {
            font-size: 1.5rem;
        }

        .facility-card span {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .facility-check:checked+.facility-card {
            border-color: #0d6efd;
            background-color: #f4f8ff;
            color: #0d6efd;
        }

        .facility-check:checked+.facility-card::after {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 10px;
            right: 10px;
            color: #0d6efd;
        }

        .price-input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .price-input-group .prefix {
            position: absolute;
            left: 16px;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .price-input-group .suffix {
            position: absolute;
            right: 16px;
            color: #adb5bd;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .price-input-group input {
            padding-left: 45px;
            padding-right: 90px;
            font-weight: 600;
        }

        .upload-box {
            border: 2px dashed #ced4da;
            border-radius: 12px;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #6c757d;
        }

        .upload-box:hover {
            border-color: #0d6efd;
            background-color: #f4f8ff;
            color: #0d6efd;
        }

        .upload-main {
            height: 300px;
        }

        .upload-small {
            height: 140px;
        }

        .summary-card {
            background-color: #fff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #f1f3f5;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .price-summary-box {
            background-color: #3b5bdb;
            color: white;
            border-radius: 16px;
            padding: 32px 24px;
        }

        .badge-facility {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #495057;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-outline-custom {
            color: #495057;
            font-weight: 600;
            background: transparent;
            border: none;
            padding: 10px 20px;
        }

        .btn-outline-custom:hover {
            color: #0d6efd;
        }

        .btn-primary-custom {
            background-color: #3b5bdb;
            color: white;
            border-radius: 8px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
            transition: 0.2s;
        }

        .btn-primary-custom:hover {
            background-color: #2c47ab;
        }
    </style>

    <div class="container-fluid-custom pb-5">

        <a href="{{ route('pemilik.kamar', $kost->id) }}" class="page-title mt-2">
            <i class="fa-solid fa-chevron-left"></i> Edit Kamar
        </a>
        <p class="text-secondary small mt-2">Ubah Informasi Kamar dan sesuaikan detail dasar kamar Anda.
            ini akan membantu penyewa menemukan pilihan yang tepat.</p>

        <div class="stepper-container">
            <div class="step-wrapper">
                <div class="step-circle active" id="circle-1">1</div>
                <div class="step-label active" id="label-1">Informasi</div>
            </div>
            <div class="step-line" id="line-1"></div>
            <div class="step-wrapper">
                <div class="step-circle" id="circle-2">2</div>
                <div class="step-label" id="label-2">Fasilitas</div>
            </div>
            <div class="step-line" id="line-2"></div>
            <div class="step-wrapper">
                <div class="step-circle" id="circle-3">3</div>
                <div class="step-label" id="label-3">Harga</div>
            </div>
            <div class="step-line" id="line-3"></div>
            <div class="step-wrapper">
                <div class="step-circle" id="circle-4">4</div>
                <div class="step-label" id="label-4">Foto</div>
            </div>
            <div class="step-line" id="line-4"></div>
            <div class="step-wrapper">
                <div class="step-circle" id="circle-5">5</div>
                <div class="step-label" id="label-5">Konfirmasi</div>
            </div>
        </div>

        <form id="tambahKamarForm" action="{{ route('pemilik.kamar.update', ['id' => $kost->id, 'room_id' => $room->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div id="step-1">
                <div class="form-section-card">
                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">Nama Kamar</label>
                            <input type="text" name="room_name" id="input_room_name" class="form-control form-control-custom w-100"
                                placeholder="e.g. Kamar Standard" value="{{ old('room_name', $room->room_name) }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">Tipe Kamar</label>
                            <select name="room_type" id="input_room_type" class="form-select form-control-custom text-muted" required>
                                <option value="">Pilih Tipe</option>
                                <option value="Standard" {{ (old('room_type', $room->room_type) == 'Standard') ? 'selected' : '' }}>Standard</option>
                                <option value="Deluxe" {{ (old('room_type', $room->room_type) == 'Deluxe') ? 'selected' : '' }}>Deluxe</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom">Ukuran Kamar (m)</label>
                            <div class="position-relative">
                                <input type="text" name="room_size" id="input_room_size" class="form-control form-control-custom w-100" placeholder="e.g. 3x4"
                                    style="padding-right: 60px;" value="{{ old('room_size', $room->room_size) }}" required>
                                <span class="position-absolute text-muted"
                                    style="right: 16px; top: 12px; font-size: 0.85rem;">Meter</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom">Ketersediaan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="available" id="input_available" style="width: 40px; height: 20px; cursor: pointer;" {{ old('available', $room->available) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2 fw-medium text-dark" for="input_available" style="line-height: 20px; cursor: pointer;">Kamar Tersedia</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom">Kost Terpilih</label>
                            <div class="position-relative">
                                <input type="text" class="form-control form-control-custom text-muted bg-light" value="{{ $kost->boarding_house_name }}" readonly>
                                <i class="fa-solid fa-building position-absolute text-muted"
                                    style="right: 16px; top: 14px;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ route('pemilik.kamar', $kost->id) }}" class="btn-outline-custom text-decoration-none">Batal</a>
                        <button type="button" class="btn-primary-custom" onclick="goToStep(2)">Lanjut <i
                                class="fa-solid fa-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>

            <div id="step-2" class="d-none">
                <div class="form-section-card">

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-layer-group text-primary"></i>
                        <h6 class="fw-bold mb-0">Fasilitas Utama</h6>
                    </div>
                    <div class="row g-3 mb-5">
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="AC" id="fac_ac" class="facility-check">
                            <label for="fac_ac" class="facility-card"><i
                                    class="fa-solid fa-snowflake"></i><span>AC</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="WIFI" id="fac_wifi" class="facility-check">
                            <label for="fac_wifi" class="facility-card"><i
                                    class="fa-solid fa-wifi"></i><span>WIFI</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Kamar Mandi" id="fac_km" class="facility-check">
                            <label for="fac_km" class="facility-card"><i class="fa-solid fa-bath"></i><span>Kamar
                                    Mandi</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="TV" id="fac_tv" class="facility-check">
                            <label for="fac_tv" class="facility-card"><i
                                    class="fa-solid fa-tv"></i><span>TV</span></label>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-couch text-primary"></i>
                        <h6 class="fw-bold mb-0">Fasilitas Tambahan</h6>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Kursi" id="fac_kursi" class="facility-check">
                            <label for="fac_kursi" class="facility-card"
                                style="min-height: 80px; padding: 10px; flex-direction: row; justify-content: start;">
                                <i class="fa-solid fa-chair text-muted ms-2 me-2"></i>
                                <div class="d-flex flex-column"><span class="mb-0">Kursi</span><small
                                        class="text-muted" style="font-size:0.65rem;">Chair</small></div>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Lemari" id="fac_lemari" class="facility-check">
                            <label for="fac_lemari" class="facility-card"
                                style="min-height: 80px; padding: 10px; flex-direction: row; justify-content: start;">
                                <i class="fa-solid fa-door-closed text-muted ms-2 me-2"></i>
                                <div class="d-flex flex-column"><span class="mb-0">Lemari</span><small
                                        class="text-muted" style="font-size:0.65rem;">Wardrobe</small></div>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Meja" id="fac_meja" class="facility-check">
                            <label for="fac_meja" class="facility-card"
                                style="min-height: 80px; padding: 10px; flex-direction: row; justify-content: start;">
                                <i class="fa-solid fa-table text-muted ms-2 me-2"></i>
                                <div class="d-flex flex-column"><span class="mb-0">Meja</span><small class="text-muted"
                                        style="font-size:0.65rem;">Desk</small></div>
                            </label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Lampu" id="fac_lampu" class="facility-check">
                            <label for="fac_lampu" class="facility-card"
                                style="min-height: 80px; padding: 10px; flex-direction: row; justify-content: start;">
                                <i class="fa-solid fa-lightbulb text-muted ms-2 me-2"></i>
                                <div class="d-flex flex-column"><span class="mb-0">Lampu</span><small
                                        class="text-muted" style="font-size:0.65rem;">Desk Lamp</small></div>
                            </label>
                        </div>
                    </div>

                    <label class="form-label-custom">Tambahan lainnya</label>
                    <div class="d-flex gap-2 mb-3">
                        <input type="text" class="form-control form-control-custom flex-grow-1"
                            placeholder="Add custom facility (e.g. Balcony)">
                        <button type="button" class="btn btn-primary shadow-sm px-4 rounded-3"><i
                                class="fa-solid fa-plus me-1"></i> Add</button>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3 fw-medium">Water
                            Heater <i class="fa-solid fa-xmark ms-2" style="cursor:pointer;"></i></span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-3 fw-medium">Exhaust
                            Fan <i class="fa-solid fa-xmark ms-2" style="cursor:pointer;"></i></span>
                    </div>

                    <div class="d-flex justify-content-end align-items-center mt-5 gap-3">
                        <button type="button" class="btn-outline-custom bg-light rounded-3 px-4"
                            onclick="goToStep(1)"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</button>
                        <button type="button" class="btn-primary-custom" onclick="goToStep(3)">Lanjut <i
                                class="fa-solid fa-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>

            <div id="step-3" class="d-none">
                <div class="row g-4">
                    <div class="col-12 col-md-8">
                        <div class="form-section-card h-100">
                            <h5 class="fw-bold mb-1">Penentuan Tarif</h5>
                            <p class="text-secondary small mb-4">Tentukan harga sewa berdasarkan fleksibilitas durasi
                                tinggal yang Anda tawarkan.</p>

                            <div class="mb-4">
                                <label class="form-label-custom">Harga Harian</label>
                                <div class="price-input-group">
                                    <span class="prefix">Rp</span>
                                    <input type="number" name="daily_price" id="input_daily_price" class="form-control form-control-custom w-100" placeholder="0" value="{{ old('daily_price', $room->daily_price) }}">
                                    <span class="suffix">PER HARI</span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label-custom">Harga Mingguan</label>
                                <div class="price-input-group">
                                    <span class="prefix">Rp</span>
                                    <input type="number" name="weekly_price" id="input_weekly_price" class="form-control form-control-custom w-100" placeholder="0" value="{{ old('weekly_price', $room->weekly_price) }}">
                                    <span class="suffix">PER MINGGU</span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label-custom">Harga Bulanan</label>
                                <div class="price-input-group">
                                    <span class="prefix">Rp</span>
                                    <input type="number" name="monthly_price" id="input_monthly_price" class="form-control form-control-custom w-100" placeholder="0" value="{{ old('monthly_price', $room->monthly_price) }}" required>
                                    <span class="suffix">PER BULAN</span>
                                </div>
                            </div>

                            <div class="alert alert-info border-0 mt-4 d-flex gap-3"
                                style="background-color: #f1f8fc; border-radius: 12px; color: #495057;">
                                <i class="fa-solid fa-circle-info fs-5" style="color: #4a85f6;"></i>
                                <div>
                                    <h6 class="fw-bold mb-1" style="font-size: 0.85rem;">Informasi Penting</h6>
                                    <p class="mb-0 small text-muted">Sesuai kebijakan operasional saat ini, tidak ada opsi
                                        harga tahunan untuk jenis kamar ini. Semua pembayaran dilakukan maksimal secara
                                        bulanan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-section-card h-100 p-0 overflow-hidden d-flex flex-column">
                            <div class="p-4" style="background-color: #4a85f6; color: white;">
                                <h5 class="fw-bold mb-3">Strategi Harga</h5>
                                <p class="small mb-4 text-white-50">Kamar dengan harga harian yang kompetitif cenderung
                                    memiliki tingkat okupansi 30% lebih tinggi untuk tipe kamar Deluxe.</p>
                                <div class="bg-white bg-opacity-10 p-3 rounded-3 small d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-lightbulb"></i> GUNAKAN ANGKA PSIKOLOGIS (e.g. 99K)
                                </div>
                            </div>
                            <div class="p-4 bg-white mt-auto">
                                <h6 class="fw-bold text-dark mb-3">Estimasi Pendapatan</h6>
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                                    <span class="text-secondary small">Potensi Bulanan</span>
                                    <span class="fw-bold text-primary">Rp 0</span>
                                </div>
                                <p class="text-muted" style="font-size: 0.65rem;">*Berdasarkan 100% okupansi bulanan.
                                    Estimasi belum termasuk biaya operasional/pajak.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-4 gap-3">
                    <button type="button" class="btn-outline-custom bg-white border shadow-sm rounded-3 px-4"
                        onclick="goToStep(2)"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</button>
                    <button type="button" class="btn-primary-custom" onclick="goToStep(4)">Lanjut <i
                            class="fa-solid fa-arrow-right ms-2"></i></button>
                </div>
            </div>

            <div id="step-4" class="d-none">
                <div class="form-section-card">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="section-icon-box" style="width:32px; height:32px;"><i class="fa-regular fa-image"
                                style="font-size: 1rem;"></i></div>
                        <h5 class="fw-bold mb-0">Galeri Foto Kamar</h5>
                    </div>

                    <div class="row g-4">
                        <div class="col-12 col-md-8">
                            <div class="upload-box upload-main">
                                <div class="bg-white shadow-sm p-3 rounded-circle mb-3 text-primary"><i
                                        class="fa-solid fa-cloud-arrow-up fs-4"></i></div>
                                <h6 class="fw-bold text-dark mb-1">Unggah Foto Utama</h6>
                                <p class="small text-muted">Seret gambar atau klik untuk memilih</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex flex-column gap-4">
                            <div class="upload-box upload-small h-50">
                                <i class="fa-solid fa-camera mb-2 fs-5"></i>
                                <span class="small fw-bold">Tambah Detail</span>
                            </div>
                            <div class="upload-box upload-small h-50">
                                <i class="fa-solid fa-camera mb-2 fs-5"></i>
                                <span class="small fw-bold">Tambah Fasilitas</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted small mt-3"><i class="fa-regular fa-circle-info me-1"></i> Rekomendasi ukuran
                        foto minimal 1280x720 pixel dalam format JPG atau PNG.</p>

                    <div class="d-flex justify-content-end align-items-center mt-5 gap-3">
                        <button type="button" class="btn-outline-custom bg-light rounded-3 px-4"
                            onclick="goToStep(3)"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</button>
                        <button type="button" class="btn-primary-custom" onclick="goToStep(5)">Lanjut <i
                                class="fa-solid fa-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>

            <div id="step-5" class="d-none">
                <div class="row g-4">
                    <div class="col-12 col-lg-7">
                        <div class="summary-card">
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <div class="section-icon-box bg-light text-secondary" style="width:32px; height:32px;"><i
                                        class="fa-solid fa-circle-info"></i></div>
                                <h5 class="fw-bold mb-0 text-dark">Informasi Kamar</h5>
                            </div>
                            <div class="row g-4">
                                <div class="col-6">
                                    <p class="form-label-custom">NAMA KAMAR</p>
                                    <h6 class="fw-bold text-dark" id="summary_room_name">-</h6>
                                </div>
                                <div class="col-6">
                                    <p class="form-label-custom">TIPE</p>
                                    <h6 class="fw-bold text-dark" id="summary_room_type">-</h6>
                                </div>
                                <div class="col-6">
                                    <p class="form-label-custom">UKURAN</p>
                                    <h6 class="fw-bold text-dark" id="summary_room_size">-</h6>
                                </div>
                                <div class="col-6">
                                    <p class="form-label-custom">KOST</p>
                                    <h6 class="fw-bold text-dark">{{ $kost->boarding_house_name }}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="summary-card">
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <div class="section-icon-box bg-light text-secondary" style="width:32px; height:32px;"><i
                                        class="fa-solid fa-list-ul"></i></div>
                                <h5 class="fw-bold mb-0 text-dark">Fasilitas Tersedia</h5>
                            </div>
                            <div class="d-flex flex-wrap gap-2" id="summary_facilities">
                                <!-- Diisi via JS -->
                            </div>
                        </div>

                        <div class="summary-card mb-0">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="section-icon-box bg-light text-secondary"
                                        style="width:32px; height:32px;"><i class="fa-regular fa-image"></i></div>
                                    <h5 class="fw-bold mb-0 text-dark">Galeri Foto</h5>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary">4 File Diunggah</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-3">
                                    <div class="bg-light rounded-3"
                                        style="height: 60px; background-image: url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=200&q=80'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="bg-light rounded-3"
                                        style="height: 60px; background-image: url('https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=200&q=80'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="bg-light rounded-3"
                                        style="height: 60px; background-image: url('https://images.unsplash.com/photo-1560448204-603b3fc33ddc?w=200&q=80'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="bg-light rounded-3"
                                        style="height: 60px; background-image: url('https://images.unsplash.com/photo-1540518614846-7eded433c457?w=200&q=80'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="price-summary-box mb-4">
                            <div
                                class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom border-light border-opacity-25">
                                <i class="fa-solid fa-money-bill-wave fs-5"></i>
                                <h5 class="fw-bold mb-0">Harga Sewa</h5>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-white-50 small">Harian</span>
                                <span class="fw-bold fs-5" id="summary_daily_price">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-white-50 small">Mingguan</span>
                                <span class="fw-bold fs-5" id="summary_weekly_price">Rp 0</span>
                            </div>
                            <div
                                class="d-flex justify-content-between mt-4 pt-4 border-top border-light border-opacity-25">
                                <span class="text-white-50">Bulanan</span>
                                <span class="fw-bold fs-3" id="summary_monthly_price">Rp 0</span>
                            </div>
                        </div>

                        <div class="summary-card mb-4">
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <div class="section-icon-box bg-light text-secondary" style="width:32px; height:32px;"><i
                                        class="fa-solid fa-bed"></i></div>
                                <h5 class="fw-bold mb-0 text-dark">Ketersediaan Kamar</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-secondary small">Status</span>
                                <h5 class="fw-bold text-success mb-0" id="summary_available"><i class="fa-solid fa-circle-check"></i> Tersedia</h5>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 d-flex gap-3 mb-4"
                            style="background-color: #e6f3ff; color: #0056b3; border-radius: 12px;">
                            <i class="fa-regular fa-lightbulb fs-5 mt-1"></i>
                            <p class="mb-0 small">Pastikan semua data sudah sesuai dengan standar operasional Estate
                                Curator untuk meminimalisir kesalahan tagihan.</p>
                        </div>

                        <div class="d-flex justify-content-between gap-3 mt-auto">
                            <button type="button" class="btn btn-light border flex-grow-1 fw-bold"
                                onclick="goToStep(4)"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</button>
                            <button type="submit" class="btn-primary-custom flex-grow-1 shadow-sm">Simpan <i
                                    class="fa-solid fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

    @push('scripts')
        <script>
            function formatRupiah(number) {
                if(!number) return "Rp 0";
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
            }

            function goToStep(step) {
                if (step === 5) {
                    document.getElementById('summary_room_name').innerText = document.getElementById('input_room_name').value || '-';
                    document.getElementById('summary_room_type').innerText = document.getElementById('input_room_type').value || '-';
                    document.getElementById('summary_room_size').innerText = (document.getElementById('input_room_size').value || '-') + ' Meter';
                    
                    document.getElementById('summary_daily_price').innerText = formatRupiah(document.getElementById('input_daily_price').value);
                    document.getElementById('summary_weekly_price').innerText = formatRupiah(document.getElementById('input_weekly_price').value);
                    document.getElementById('summary_monthly_price').innerText = formatRupiah(document.getElementById('input_monthly_price').value);
                    
                    const isAvailable = document.getElementById('input_available').checked;
                    const availEl = document.getElementById('summary_available');
                    if (isAvailable) {
                        availEl.innerHTML = '<i class="fa-solid fa-circle-check"></i> Tersedia';
                        availEl.className = 'fw-bold text-success mb-0';
                    } else {
                        availEl.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> Terisi (Tidak Tersedia)';
                        availEl.className = 'fw-bold text-secondary mb-0';
                    }

                    const facilitiesDiv = document.getElementById('summary_facilities');
                    facilitiesDiv.innerHTML = '';
                    const checkedFacs = document.querySelectorAll('.facility-check:checked');
                    if(checkedFacs.length === 0) {
                        facilitiesDiv.innerHTML = '<span class="text-muted small">Tidak ada fasilitas.</span>';
                    } else {
                        checkedFacs.forEach(cb => {
                            facilitiesDiv.innerHTML += `<span class="badge-facility"><i class="fa-solid fa-check text-primary"></i> ${cb.value}</span>`;
                        });
                    }
                }

                for (let i = 1; i <= 5; i++) {
                    document.getElementById('step-' + i).classList.add('d-none');
                }
                document.getElementById('step-' + step).classList.remove('d-none');

                for (let i = 1; i <= 5; i++) {
                    const circle = document.getElementById('circle-' + i);
                    const label = document.getElementById('label-' + i);
                    const line = document.getElementById('line-' + (i - 1));

                    circle.className = 'step-circle';
                    label.className = 'step-label';
                    if (line) line.className = 'step-line';

                    if (i < step) {
                        circle.classList.add('completed');
                        circle.innerHTML = '<i class="fa-solid fa-check"></i>';
                        if (line) line.classList.add('completed');
                    } else if (i === step) {
                        circle.classList.add('active');
                        circle.innerHTML = i;
                        label.classList.add('active');
                        if (line) line.classList.add('completed');
                    } else {
                        circle.innerHTML = i;
                    }
                }
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        </script>
    @endpush
@endsection
