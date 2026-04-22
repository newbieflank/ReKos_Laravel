@extends('layouts.pemilik')

@section('title', 'Daftar Kost - RE-KOST')

@section('content')
<style>
    .container-fluid-custom { width: 100%; padding-right: 0; padding-left: 0; }
    
    /* Tombol Filter Pill */
    .filter-pill { border-radius: 50px; padding: 8px 24px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.2s; border: none; }
    .filter-pill.active { background-color: #0d6efd; color: white; }
    .filter-pill.inactive { background-color: #e6f0ff; color: #0d6efd; }
    .filter-pill.inactive:hover { background-color: #d1e3ff; }

    /* Kartu Kost */
    .kost-card { background-color: #fff; border-radius: 16px; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.02); padding: 24px; height: 100%; display: flex; flex-direction: column; transition: transform 0.2s; }
    .kost-card:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.05); }
    .badge-status-kost { background-color: #e6f0ff; color: #0d6efd; font-size: 0.7rem; font-weight: 700; padding: 6px 12px; border-radius: 50px; }
    
    /* Progress Bar Okupansi */
    .progress-custom { height: 8px; border-radius: 10px; background-color: #e9ecef; margin-top: 8px; margin-bottom: 24px; }
    .progress-bar-custom { background-color: #0d6efd; border-radius: 10px; }

    /* Tombol Aksi Bawah */
    .btn-detail { background-color: #f8f9fa; color: #495057; border: none; border-radius: 8px; padding: 8px 16px; font-weight: 600; font-size: 0.85rem; transition: 0.2s; flex-grow: 1; }
    .btn-detail:hover { background-color: #e9ecef; color: #212529; }
    .btn-action-outline { border: 1px solid #dee2e6; color: #adb5bd; background: transparent; width: 36px; height: 36px; display: flex; justify-content: center; align-items: center; border-radius: 8px; transition: 0.2s; }
    .btn-action-outline:hover { color: #0d6efd; border-color: #0d6efd; background-color: #f8f9fa; }

    /* Kartu Tambah Kost */
    .add-kost-card { border: 2px dashed #dee2e6; border-radius: 16px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; min-height: 220px; cursor: pointer; color: #6c757d; text-decoration: none; transition: all 0.2s; }
    .add-kost-card:hover { background-color: #f8f9fa; border-color: #0d6efd; color: #0d6efd; }

    /* Kartu Statistik Okupansi */
    .occupancy-card { background-color: #fff; border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); padding: 32px; margin-top: 16px; border: 1px solid #f1f3f5; }
    .stat-box { background-color: #f8f9fa; border-radius: 12px; padding: 20px; height: 100%; }
    .stat-box.border-left-primary { border-left: 4px solid #0d6efd; }
</style>

<div class="container-fluid-custom">
    <div class="mb-4">
        <h3 class="text-primary fw-bold mb-1">Daftar Kost</h3>
        <p class="text-secondary small">Kelola daftar properti kost Anda, pantau okupansi, dan detail lokasi.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="background-color: #d1e7dd; color: #0f5132; border-radius: 12px;">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-check fs-5"></i>
                <span class="fw-medium">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex gap-3 mb-4">
        <button class="filter-pill active">Semua</button>
        <button class="filter-pill inactive">Tersedia</button>
        <button class="filter-pill inactive">Penuh</button>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="kost-card">
                <div class="d-flex justify-content-end mb-2">
                    <span class="badge-status-kost">TERSEDIA</span>
                </div>
                <h5 class="fw-bold text-dark mb-1">Kost Melati</h5>
                <p class="text-muted small mb-4"><i class="fa-solid fa-location-dot me-1"></i> Jl. Melati No. 45, Kebayoran Baru</p>
                
                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-end">
                        <span class="text-secondary small fw-medium">Okupansi</span>
                        <span class="text-dark fw-bold small">18 / 20 Kamar</span>
                    </div>
                    <div class="progress progress-custom">
                        <div class="progress-bar progress-bar-custom" style="width: 90%"></div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button class="btn-detail">Detail</button>
                        <button class="btn-action-outline"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn-action-outline"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn-action-outline"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="kost-card">
                <div class="d-flex justify-content-end mb-2">
                    <span class="badge-status-kost">TERSEDIA</span>
                </div>
                <h5 class="fw-bold text-dark mb-1">Kost Melati</h5>
                <p class="text-muted small mb-4"><i class="fa-solid fa-location-dot me-1"></i> Jl. Melati No. 45, Kebayoran Baru</p>
                
                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-end">
                        <span class="text-secondary small fw-medium">Okupansi</span>
                        <span class="text-dark fw-bold small">18 / 20 Kamar</span>
                    </div>
                    <div class="progress progress-custom">
                        <div class="progress-bar progress-bar-custom" style="width: 90%"></div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button class="btn-detail">Detail</button>
                        <button class="btn-action-outline"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn-action-outline"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn-action-outline"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="kost-card">
                <div class="d-flex justify-content-end mb-2">
                    <span class="badge-status-kost">TERSEDIA</span>
                </div>
                <h5 class="fw-bold text-dark mb-1">Kost Melati</h5>
                <p class="text-muted small mb-4"><i class="fa-solid fa-location-dot me-1"></i> Jl. Melati No. 45, Kebayoran Baru</p>
                
                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-end">
                        <span class="text-secondary small fw-medium">Okupansi</span>
                        <span class="text-dark fw-bold small">18 / 20 Kamar</span>
                    </div>
                    <div class="progress progress-custom">
                        <div class="progress-bar progress-bar-custom" style="width: 90%"></div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button class="btn-detail">Detail</button>
                        <button class="btn-action-outline"><i class="fa-solid fa-plus"></i></button>
                        <button class="btn-action-outline"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn-action-outline"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('pemilik.kost.tambah') }}" class="add-kost-card">
                <i class="fa-solid fa-plus mb-3" style="font-size: 32px; color: #4a85f6;"></i>
                <h5 class="fw-bold mb-0" style="color: #4a85f6;">Tambah Kost</h5>
            </a>
        </div>
    </div>

    <div class="occupancy-card">
        <div class="row align-items-center g-4">
            <div class="col-12 col-md-3">
                <h4 class="text-primary fw-bold mb-2">Okupansi<br>Keseluruhan</h4>
                <p class="text-secondary small mb-0">Status ketersediaan unit properti Anda secara real-time.</p>
            </div>
            <div class="col-12 col-md-9">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <p class="text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">TOTAL KOST</p>
                            <h2 class="fw-bold text-primary mb-0">24</h2>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box border-left-primary">
                            <p class="text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">TERISI</p>
                            <h2 class="fw-bold text-primary mb-0">18</h2>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <p class="text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">TERSEDIA</p>
                            <h2 class="fw-bold text-primary mb-0">6</h2>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box">
                            <p class="text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">EFISIENSI</p>
                            <h2 class="fw-bold mb-0" style="color: #20c997;">75%</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection