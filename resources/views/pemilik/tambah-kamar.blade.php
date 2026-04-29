@extends('layouts.pemilik')

@section('title', 'Tambah Kamar - RE-KOST')

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
            <i class="fa-solid fa-chevron-left"></i> Tambah Kamar
        </a>
        <p class="text-secondary small mt-2">Informasi Kamar mulai dengan mendefinisikan detail dasar kamar Anda. Informasi
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

        <form id="tambahKamarForm" action="{{ route('pemilik.kamar.simpan', $kost->id) }}" method="POST">
            @csrf

            <div id="step-1">
                <div class="form-section-card">
                    <div class="row g-4 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">Nama Kamar</label>
                            <input type="text" name="room_name" id="input_room_name" class="form-control form-control-custom w-100"
                                placeholder="e.g. Kamar Standard" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label-custom">Tipe Kamar</label>
                            <input type="text" name="room_type" id="input_room_type" class="form-control form-control-custom w-100" placeholder="e.g. Standard, Deluxe, VIP" required>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom">Ukuran Kamar (m)</label>
                            <div class="position-relative">
                                <input type="text" name="room_size" id="input_room_size" class="form-control form-control-custom w-100" placeholder="e.g. 3x4"
                                    style="padding-right: 60px;" required>
                                <span class="position-absolute text-muted"
                                    style="right: 16px; top: 12px; font-size: 0.85rem;">Meter</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label-custom">Ketersediaan</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="available" id="input_available" checked style="width: 40px; height: 20px; cursor: pointer;">
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
                        <i class="fa-solid fa-bed text-primary"></i>
                        <h6 class="fw-bold mb-0">Fasilitas Kamar</h6>
                    </div>
                    <div class="row g-3 mb-5" id="facilities-container">
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="AC" id="fac_ac" class="facility-check">
                            <label for="fac_ac" class="facility-card"><i class="fa-solid fa-snowflake"></i><span>AC</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="WIFI" id="fac_wifi" class="facility-check">
                            <label for="fac_wifi" class="facility-card"><i class="fa-solid fa-wifi"></i><span>WIFI</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Kamar Mandi" id="fac_km" class="facility-check">
                            <label for="fac_km" class="facility-card"><i class="fa-solid fa-bath"></i><span>Kamar Mandi</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="TV" id="fac_tv" class="facility-check">
                            <label for="fac_tv" class="facility-card"><i class="fa-solid fa-tv"></i><span>TV</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Kursi" id="fac_kursi" class="facility-check">
                            <label for="fac_kursi" class="facility-card"><i class="fa-solid fa-chair"></i><span>Kursi</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Lemari" id="fac_lemari" class="facility-check">
                            <label for="fac_lemari" class="facility-card"><i class="fa-solid fa-door-closed"></i><span>Lemari</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Meja" id="fac_meja" class="facility-check">
                            <label for="fac_meja" class="facility-card"><i class="fa-solid fa-table"></i><span>Meja</span></label>
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="checkbox" name="facilities[]" value="Lampu" id="fac_lampu" class="facility-check">
                            <label for="fac_lampu" class="facility-card"><i class="fa-solid fa-lightbulb"></i><span>Lampu</span></label>
                        </div>
                    </div>

                    <label class="form-label-custom">Tambahan lainnya</label>
                    <div class="d-flex gap-2 mb-3">
                        <input type="text" id="custom-facility-input" class="form-control form-control-custom flex-grow-1"
                            placeholder="Add custom facility (e.g. Balcony)">
                        <button type="button" class="btn btn-primary shadow-sm px-4 rounded-3" onclick="addCustomFacility()"><i
                                class="fa-solid fa-plus me-1"></i> Add</button>
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
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="form-section-card shadow-sm border-0">
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 64px; height: 64px;">
                                    <i class="fa-solid fa-money-bill-wave fs-3"></i>
                                </div>
                                <h4 class="fw-bold text-dark">Penentuan Tarif & Biaya</h4>
                                <p class="text-secondary small">Tentukan harga sewa berdasarkan durasi tinggal dan catat estimasi pengeluaran bulanan.</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <div class="p-4 border rounded-4 bg-light h-100">
                                        <h6 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="fa-solid fa-tags text-primary me-2"></i>Tarif Sewa Kamar</h6>
                                        
                                        <div class="mb-4">
                                            <label class="form-label-custom">Harga Harian</label>
                                            <div class="input-group input-group-lg bg-white" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                                <span class="input-group-text bg-transparent border-0 text-muted pe-1">Rp</span>
                                                <input type="text" name="daily_price" id="input_daily_price" class="form-control border-0 px-2 fw-bold rupiah-input" placeholder="0">
                                                <span class="input-group-text bg-transparent border-0 text-muted small fw-bold ps-1">/ HARI</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label-custom">Harga Mingguan</label>
                                            <div class="input-group input-group-lg bg-white" style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                                                <span class="input-group-text bg-transparent border-0 text-muted pe-1">Rp</span>
                                                <input type="text" name="weekly_price" id="input_weekly_price" class="form-control border-0 px-2 fw-bold rupiah-input" placeholder="0">
                                                <span class="input-group-text bg-transparent border-0 text-muted small fw-bold ps-1">/ MINGGU</span>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label-custom text-primary">Harga Bulanan <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-lg bg-white" style="border: 2px solid #0d6efd; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(13,110,253,0.1);">
                                                <span class="input-group-text bg-primary text-white border-0 fw-bold pe-2">Rp</span>
                                                <input type="text" name="monthly_price" id="input_monthly_price" class="form-control border-0 px-2 fw-bold text-primary fs-5 rupiah-input" placeholder="0" required>
                                                <span class="input-group-text bg-primary text-white border-0 small fw-bold ps-2">/ BULAN</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <div class="p-4 border rounded-4 h-100" style="background-color: #fffdf5; border-color: #ffe69c !important;">
                                        <h6 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="fa-solid fa-wallet text-warning me-2"></i>Pengeluaran Operasional</h6>
                                        
                                        <div class="mb-4">
                                            <label class="form-label-custom text-dark">Estimasi Pengeluaran Bulanan <span class="text-danger">*</span></label>
                                            <p class="text-muted mb-3" style="font-size: 0.75rem; line-height: 1.5;">Perkiraan biaya bulanan khusus untuk kamar ini (misal: porsi listrik, kebersihan, perawatan) untuk dihitung dalam laporan keuangan.</p>
                                            <div class="input-group input-group-lg bg-white" style="border: 2px solid #ffc107; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(255,193,7,0.1);">
                                                <span class="input-group-text border-0 fw-bold pe-2" style="background-color: #ffc107; color: white;">Rp</span>
                                                <input type="text" name="monthly_expense" id="input_monthly_expense" class="form-control border-0 px-2 fw-bold text-dark fs-5 rupiah-input" placeholder="0" required>
                                                <span class="input-group-text border-0 small fw-bold ps-2" style="background-color: #ffc107; color: white;">/ BULAN</span>
                                            </div>
                                        </div>
                                        
                                        <div class="alert border-0 d-flex gap-3 mb-0" style="background-color: white; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                                            <i class="fa-solid fa-circle-info fs-5 text-info mt-1"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1" style="font-size: 0.8rem; color: #495057;">Saran Pengisian</h6>
                                                <p class="mb-0 text-muted" style="font-size: 0.7rem; line-height: 1.4;">Isi dengan angka perkiraan rasional. Jika biaya seperti token listrik ditanggung penuh oleh penyewa, abaikan biaya tersebut dari estimasi ini.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end align-items-center mt-5 gap-3 pt-4 border-top">
                                <button type="button" class="btn-outline-custom bg-light rounded-3 px-4 py-2"
                                    onclick="goToStep(2)"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</button>
                                <button type="button" class="btn-primary-custom px-5 py-2 shadow-sm" onclick="goToStep(4)">Lanjut <i
                                        class="fa-solid fa-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                    </div>
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
            function addCustomFacility() {
                const input = document.getElementById('custom-facility-input');
                const val = input.value.trim();
                if(!val) return;
                
                const container = document.getElementById('facilities-container');
                const id = 'fac_custom_' + Date.now();
                
                const col = document.createElement('div');
                col.className = 'col-6 col-md-3 custom-facility-item';
                
                col.innerHTML = `
                    <input type="checkbox" name="facilities[]" value="${val}" id="${id}" class="facility-check" checked>
                    <label for="${id}" class="facility-card position-relative">
                        <i class="fa-solid fa-tag text-primary"></i>
                        <span>${val}</span>
                        <button type="button" class="btn btn-sm text-danger position-absolute" style="top: 2px; left: 2px; z-index: 10; padding: 2px 6px;" onclick="event.preventDefault(); this.closest('.custom-facility-item').remove()">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </label>
                `;
                
                container.appendChild(col);
                input.value = '';
            }

            // Rupiah Formatting
            function formatRupiah(angka) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            }

            document.querySelectorAll('.rupiah-input').forEach(function(input) {
                input.addEventListener('keyup', function(e) {
                    this.value = formatRupiah(this.value);
                });
            });

            // Clean form before submit
            document.getElementById('tambahKamarForm').addEventListener('submit', function(e) {
                document.querySelectorAll('.rupiah-input').forEach(function(input) {
                    input.value = input.value.replace(/\./g, '');
                });
            });
        </script>
    @endpush
@endsection
