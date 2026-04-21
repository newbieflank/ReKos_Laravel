@extends('layouts.pemilik')

@section('title', 'Daftar Kamar - RE-KOST')

@section('content')
    <style>
        .container-fluid-custom {
            width: 100%;
            padding-right: 0;
            padding-left: 0;
        }

        .search-filter-bar {
            background-color: #fff;
            border-radius: 50px;
            padding: 8px 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .search-input-wrapper {
            display: flex;
            align-items: center;
            flex-grow: 1;
            max-width: 600px;
        }

        .search-input {
            border: none;
            outline: none;
            width: 100%;
            padding-left: 12px;
            font-size: 0.9rem;
            background: transparent;
        }

        .filter-btn {
            border-radius: 20px;
            padding: 6px 20px;
            font-size: 0.8rem;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
        }

        .filter-btn.active {
            background-color: #e6f0ff;
            color: #0d6efd;
        }

        .filter-btn.inactive {
            background-color: transparent;
            color: #6c757d;
        }

        .filter-btn.inactive:hover {
            background-color: #f8f9fa;
        }

        .room-card {
            background-color: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .room-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        }

        .room-badge {
            font-size: 0.7rem;
            padding: 4px 10px;
            border: 1px solid #e9ecef;
            color: #6c757d;
            border-radius: 6px;
            background-color: #fff;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.tersedia {
            background-color: #20c997;
        }

        .status-dot.terisi {
            background-color: #0d6efd;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: none;
            color: white;
            font-size: 0.85rem;
            transition: opacity 0.2s;
        }

        .action-btn:hover {
            opacity: 0.8;
        }

        .btn-add {
            background-color: #20c997;
        }

        .btn-edit {
            background-color: #f6c23e;
        }

        .btn-info-icon {
            color: #adb5bd;
            background: transparent;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-info-icon:hover {
            color: #0d6efd;
            border-color: #0d6efd;
            background-color: #e6f0ff;
        }

        .add-room-card {
            border: 2px dashed #ced4da;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            min-height: 180px;
            cursor: pointer;
            color: #212529;
            background-color: transparent;
            transition: all 0.2s;
        }

        .add-room-card:hover {
            background-color: #f8f9fa;
            border-color: #adb5bd;
        }

        .occupancy-card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            padding: 24px;
        }

        .stat-box {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 16px;
            height: 100%;
        }

        .stat-box.border-left-primary {
            border-left: 4px solid #0d6efd;
        }

        /* --- STYLE KHUSUS MODAL POPUP DETAIL KAMAR --- */
        .modal-content-custom {
            border-radius: 16px;
            border: none;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #495057;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before {
            content: "";
            display: inline-block;
            width: 24px;
            height: 3px;
            background-color: #495057;
        }

        .facility-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 1px solid #f1f3f5;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #495057;
            background-color: #fff;
        }

        .facility-box i {
            color: #0d6efd;
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .facility-badge {
            background-color: #f8f9fa;
            color: #495057;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #f1f3f5;
        }

        .btn-update-status {
            background-color: #0d6efd;
            color: white;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: 0.2s;
        }

        .btn-update-status:hover {
            background-color: #0b5ed7;
        }
    </style>

    <div class="container-fluid-custom">
        <div class="mb-4">
            <h3 class="text-dark fw-bold mb-1">Daftar Kamar</h3>
            <p class="text-secondary small">Kelola hunian, fasilitas, dan status penyewa Kost Anda.</p>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="search-filter-bar">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        <input type="text" class="search-input" placeholder="Cari nomor kamar atau penyewa...">
                    </div>
                    <div class="d-flex gap-2">
                        <button class="filter-btn active">SEMUA</button>
                        <button class="filter-btn inactive">TERSEDIA</button>
                        <button class="filter-btn inactive">TERISI</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="room-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="text-primary fw-bold mb-0">Kamar 01</h5>
                        <button class="btn-info-icon" title="Detail Kamar" data-bs-toggle="modal"
                            data-bs-target="#detailKamarModal"><i class="fa-solid fa-info"></i></button>
                    </div>
                    <p class="text-secondary small mb-3">Budi Setiawan</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="room-badge">WiFi</span>
                        <span class="room-badge">Kamar Mandi</span>
                        <span class="room-badge">7+</span>
                    </div>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="status-dot tersedia" title="Tersedia"></span>
                        <div class="d-flex gap-2">
                            <button class="action-btn btn-add"><i class="fa-solid fa-plus"></i></button>
                            <button class="action-btn btn-edit" title="Edit Data" data-bs-toggle="modal"
                                data-bs-target="#detailKamarModal"><i class="fa-solid fa-pen"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="room-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="text-primary fw-bold mb-0">Kamar 02</h5>
                        <button class="btn-info-icon" title="Detail Kamar" data-bs-toggle="modal"
                            data-bs-target="#detailKamarModal"><i class="fa-solid fa-info"></i></button>
                    </div>
                    <p class="text-secondary small mb-3">Andi Saputra</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="room-badge">WiFi</span>
                        <span class="room-badge">AC</span>
                    </div>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="status-dot terisi" title="Terisi"></span>
                        <div class="d-flex gap-2">
                            <button class="action-btn btn-add"><i class="fa-solid fa-plus"></i></button>
                            <button class="action-btn btn-edit" title="Edit Data" data-bs-toggle="modal"
                                data-bs-target="#detailKamarModal"><i class="fa-solid fa-pen"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="room-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="text-primary fw-bold mb-0">Kamar 03</h5>
                        <button class="btn-info-icon" title="Detail Kamar" data-bs-toggle="modal"
                            data-bs-target="#detailKamarModal"><i class="fa-solid fa-info"></i></button>
                    </div>
                    <p class="text-secondary small mb-3">Citra Lestari</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="room-badge">WiFi</span>
                        <span class="room-badge">Kamar Mandi</span>
                        <span class="room-badge">7+</span>
                    </div>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="status-dot tersedia" title="Tersedia"></span>
                        <div class="d-flex gap-2">
                            <button class="action-btn btn-add"><i class="fa-solid fa-plus"></i></button>
                            <button class="action-btn btn-edit" title="Edit Data" data-bs-toggle="modal"
                                data-bs-target="#detailKamarModal"><i class="fa-solid fa-pen"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="room-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="text-primary fw-bold mb-0">Kamar 04</h5>
                        <button class="btn-info-icon" title="Detail Kamar" data-bs-toggle="modal"
                            data-bs-target="#detailKamarModal"><i class="fa-solid fa-info"></i></button>
                    </div>
                    <p class="text-secondary small mb-3">Dewi Anggraini</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="room-badge">WiFi</span>
                        <span class="room-badge">Kamar Mandi</span>
                        <span class="room-badge">AC</span>
                    </div>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="status-dot terisi" title="Terisi"></span>
                        <div class="d-flex gap-2">
                            <button class="action-btn btn-add"><i class="fa-solid fa-plus"></i></button>
                            <button class="action-btn btn-edit" title="Edit Data" data-bs-toggle="modal"
                                data-bs-target="#detailKamarModal"><i class="fa-solid fa-pen"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="room-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="text-primary fw-bold mb-0">Kamar 05</h5>
                        <button class="btn-info-icon" title="Detail Kamar" data-bs-toggle="modal"
                            data-bs-target="#detailKamarModal"><i class="fa-solid fa-info"></i></button>
                    </div>
                    <p class="text-secondary small mb-3">Kosong</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="room-badge">WiFi</span>
                        <span class="room-badge">Kamar Mandi</span>
                    </div>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="status-dot tersedia" title="Tersedia"></span>
                        <div class="d-flex gap-2">
                            <button class="action-btn btn-add"><i class="fa-solid fa-plus"></i></button>
                            <button class="action-btn btn-edit" title="Edit Data" data-bs-toggle="modal"
                                data-bs-target="#detailKamarModal"><i class="fa-solid fa-pen"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="room-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="text-primary fw-bold mb-0">Kamar 06</h5>
                        <button class="btn-info-icon" title="Detail Kamar" data-bs-toggle="modal"
                            data-bs-target="#detailKamarModal"><i class="fa-solid fa-info"></i></button>
                    </div>
                    <p class="text-secondary small mb-3">Eko Prasetyo</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="room-badge">WiFi</span>
                        <span class="room-badge">Kamar Mandi</span>
                        <span class="room-badge">7+</span>
                    </div>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="status-dot terisi" title="Terisi"></span>
                        <div class="d-flex gap-2">
                            <button class="action-btn btn-add"><i class="fa-solid fa-plus"></i></button>
                            <button class="action-btn btn-edit" title="Edit Data" data-bs-toggle="modal"
                                data-bs-target="#detailKamarModal"><i class="fa-solid fa-pen"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="add-room-card">
                    <i class="fa-solid fa-plus mb-2" style="font-size: 28px;"></i>
                    <h5 class="fw-bold mb-0">Tambah Kamar</h5>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="occupancy-card">
                    <div class="row align-items-center g-4">

                        <div class="col-12 col-md-3 col-xl-3">
                            <h5 class="fw-bold text-dark mb-2">Okupansi<br>Keseluruhan</h5>
                            <p class="text-secondary small mb-0">Status ketersediaan unit properti Anda secara real-time.
                            </p>
                        </div>

                        <div class="col-12 col-md-9 col-xl-9">
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <div class="stat-box">
                                        <p class="text-muted small fw-bold mb-1"
                                            style="font-size: 0.65rem; letter-spacing: 1px;">TOTAL KAMAR</p>
                                        <h3 class="fw-bold text-dark mb-0">24</h3>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="stat-box border-left-primary">
                                        <p class="text-muted small fw-bold mb-1"
                                            style="font-size: 0.65rem; letter-spacing: 1px;">TERISI</p>
                                        <h3 class="fw-bold text-dark mb-0">18</h3>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="stat-box">
                                        <p class="text-muted small fw-bold mb-1"
                                            style="font-size: 0.65rem; letter-spacing: 1px;">TERSEDIA</p>
                                        <h3 class="fw-bold text-primary mb-0">6</h3>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="stat-box">
                                        <p class="text-muted small fw-bold mb-1"
                                            style="font-size: 0.65rem; letter-spacing: 1px;">EFISIENSI</p>
                                        <h3 class="fw-bold mb-0" style="color: #20c997;">75%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailKamarModal" tabindex="-1" aria-labelledby="detailKamarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-content-custom shadow-lg">

                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title text-primary fw-bold" id="detailKamarModalLabel">Detail Kamar 01</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 py-4">

                    <div class="row mb-5">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <h5 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                                Budi setiawan <span class="status-dot tersedia"></span>
                            </h5>
                            <p class="text-muted small fw-bold mb-0" style="letter-spacing: 1px;">
                                TIPE : <span class="text-dark">BULANAN</span>
                            </p>
                        </div>
                        <div class="col-12 col-md-6 text-md-end">
                            <p class="text-muted small fw-bold mb-1" style="letter-spacing: 0.5px;">
                                TGL MASUK : <span class="text-dark">01-12-2000</span>
                            </p>
                            <p class="text-muted small fw-bold mb-0" style="letter-spacing: 0.5px;">
                                TGL AKHIR : <span class="text-dark">01-12-2000</span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="section-title mb-3">FASILITAS POPULER</div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-wifi"></i> Wifi</div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-kitchen-set"></i> Dapur</div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-clock"></i> 24 Jam</div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-snowflake"></i> AC/Kipas Angin</div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-table"></i> Meja</div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-square-parking"></i> Parkir</div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-door-closed"></i> Lemari</div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-calendar-days"></i> Mingguan/Bulanan</div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="facility-box"><i class="fa-solid fa-tv"></i> Television</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="section-title mb-3" style="color: #adb5bd;">
                            <style>
                                .section-title.lainnya::before {
                                    background-color: #adb5bd;
                                }
                            </style>
                            <span class="section-title lainnya" style="border: none;">FASILITAS LAINNYA</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="facility-badge"><i class="fa-solid fa-person-praying text-secondary"></i>
                                Musholla</span>
                            <span class="facility-badge"><i class="fa-solid fa-cart-shopping text-secondary"></i>
                                Supermarket</span>
                            <span class="facility-badge"><i class="fa-solid fa-building-columns text-secondary"></i>
                                ATM/Bank</span>
                            <span class="facility-badge"><i class="fa-solid fa-shirt text-secondary"></i> Laundry</span>
                            <span class="facility-badge"><i class="fa-solid fa-briefcase-medical text-secondary"></i>
                                Apotek</span>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <a href="#" class="text-primary text-decoration-none fw-bold small"
                            style="font-size: 0.8rem;">
                            Lihat lebih sedikit <i class="fa-solid fa-chevron-up ms-1"></i>
                        </a>
                    </div>

                    <button class="btn-update-status d-flex justify-content-center align-items-center gap-2">
                        Update Room Status <i class="fa-solid fa-arrow-right"></i>
                    </button>

                </div>
            </div>
        </div>
    </div>

@endsection
