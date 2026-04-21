@extends('layouts.pemilik')

@section('title', 'Daftar Penyewa - RE-KOST')

@section('content')
    <style>
        .container-fluid-custom {
            width: 100%;
            padding-right: 0;
            padding-left: 0;
        }

        .top-action-bar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .search-wrapper {
            background-color: #fff;
            border-radius: 8px;
            padding: 10px 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            min-width: 300px;
            flex-grow: 1;
            max-width: 450px;
        }

        .search-wrapper input {
            border: none;
            outline: none;
            width: 100%;
            padding-left: 12px;
            font-size: 0.9rem;
            background: transparent;
        }

        .btn-add-tenant {
            background-color: #4a85f6;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s;
            box-shadow: 0 4px 6px rgba(74, 133, 246, 0.2);
        }

        .btn-add-tenant:hover {
            background-color: #3b71d8;
            color: #fff;
        }

        .filter-tabs {
            display: flex;
            gap: 24px;
            border-bottom: 1px solid transparent;
        }

        .filter-tab-link {
            text-decoration: none;
            color: #6c757d;
            font-weight: 500;
            font-size: 0.95rem;
            padding-bottom: 8px;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }

        .filter-tab-link.active {
            color: #0d6efd;
            border-bottom-color: #0d6efd;
        }

        .filter-tab-link:hover:not(.active) {
            color: #495057;
        }

        .action-btns .btn-outline-custom {
            background-color: #fff;
            border: 1px solid #e9ecef;
            color: #495057;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 16px;
            transition: all 0.2s;
        }

        .action-btns .btn-outline-custom:hover {
            background-color: #f8f9fa;
            border-color: #ced4da;
        }

        .table-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 16px 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        .table-custom {
            width: 100%;
            margin-bottom: 0;
        }

        .table-custom th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #495057;
            border-bottom: 1px solid #f3f4f6;
            padding: 16px 12px;
            font-weight: 700;
        }

        .table-custom td {
            vertical-align: middle;
            padding: 16px 12px;
            font-size: 0.9rem;
            color: #212529;
            border-bottom: 1px solid #f8f9fa;
        }

        .table-custom tbody tr:hover {
            background-color: #fcfcfc;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-status.active {
            background-color: #e6f0ff;
            color: #0d6efd;
        }

        .badge-status.pending {
            background-color: #f1f3f5;
            color: #6c757d;
        }

        .badge-pay {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-pay.lunas {
            background-color: #e3fdfd;
            color: #00b4d8;
        }

        .badge-pay.belum {
            background-color: #ffe3e3;
            color: #e03131;
        }

        .table-action-icon {
            color: #adb5bd;
            font-size: 1rem;
            margin-right: 12px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .table-action-icon.edit:hover {
            color: #0d6efd;
        }

        .table-action-icon.delete:hover {
            color: #dc3545;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            padding: 16px;
            background-color: transparent;
        }

        .page-link-custom {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            text-decoration: none;
            color: #495057;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
            border: none;
            background: transparent;
        }

        .page-link-custom.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .page-link-custom:hover:not(.active) {
            background-color: #e9ecef;
        }
    </style>

    <div class="container-fluid-custom">
        <div class="top-action-bar">
            <div>
                <h3 class="text-dark fw-bold mb-1">Daftar Penyewa</h3>
                <p class="text-secondary small mb-0">Kelola penyewa, data hunian, dan status sewa Anda.</p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="search-wrapper">
                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    <input type="text" placeholder="Cari nomor kamar atau penyewa...">
                </div>
                <a href="{{ route('pemilik.penyewa.tambah') }}" class="btn-add-tenant text-decoration-none d-inline-block">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Penyewa
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert"
                style="background-color: #d1e7dd; color: #0f5132; border-radius: 12px;">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check fs-5"></i>
                    <span class="fw-medium">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div class="filter-tabs">
                <a href="#" class="filter-tab-link active">Semua</a>
                <a href="#" class="filter-tab-link">Aktif</a>
                <a href="#" class="filter-tab-link">Pending</a>
                <a href="#" class="filter-tab-link">Terminated</a>
            </div>
            <div class="action-btns d-flex gap-2">
                <button class="btn btn-outline-custom"><i class="fa-solid fa-filter me-2"></i> Filter</button>
                <button class="btn btn-outline-custom"><i class="fa-solid fa-download me-2"></i> Export</button>
            </div>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>NAMA</th>
                            <th>KAMAR</th>
                            <th>TGL MASUK</th>
                            <th>TGL KELUAR</th>
                            <th>STATUS</th>
                            <th>BAYAR</th>
                            <th>NO HP</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">Yuyun</td>
                            <td>A101</td>
                            <td>01-01-24</td>
                            <td>01-02-24</td>
                            <td><span class="badge-status active">ACTIVE</span></td>
                            <td><span class="badge-pay lunas">LUNAS</span></td>
                            <td>0822xxx</td>
                            <td>
                                <i class="fa-solid fa-pen table-action-icon edit"></i>
                                <i class="fa-regular fa-trash-can table-action-icon delete" style="color: #e03131;"></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Ahmad Rizky</td>
                            <td>B205</td>
                            <td>15-12-23</td>
                            <td>15-06-24</td>
                            <td><span class="badge-status active">ACTIVE</span></td>
                            <td><span class="badge-pay lunas">LUNAS</span></td>
                            <td>0857xxx</td>
                            <td>
                                <i class="fa-solid fa-pen table-action-icon edit"></i>
                                <i class="fa-regular fa-trash-can table-action-icon delete" style="color: #e03131;"></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Siti Aminah</td>
                            <td>C003</td>
                            <td>10-01-24</td>
                            <td>10-04-24</td>
                            <td><span class="badge-status pending">PENDING</span></td>
                            <td><span class="badge-pay belum">BELUM BAYAR</span></td>
                            <td>0812xxx</td>
                            <td>
                                <i class="fa-solid fa-pen table-action-icon edit"></i>
                                <i class="fa-regular fa-trash-can table-action-icon delete" style="color: #e03131;"></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Budi Santoso</td>
                            <td>A112</td>
                            <td>05-01-24</td>
                            <td>05-01-25</td>
                            <td><span class="badge-status active">ACTIVE</span></td>
                            <td><span class="badge-pay lunas">LUNAS</span></td>
                            <td>0899xxx</td>
                            <td>
                                <i class="fa-solid fa-pen table-action-icon edit"></i>
                                <i class="fa-regular fa-trash-can table-action-icon delete" style="color: #e03131;"></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Rina Melati</td>
                            <td>B102</td>
                            <td>20-11-23</td>
                            <td>20-11-24</td>
                            <td><span class="badge-status active">ACTIVE</span></td>
                            <td><span class="badge-pay lunas">LUNAS</span></td>
                            <td>0877xxx</td>
                            <td>
                                <i class="fa-solid fa-pen table-action-icon edit"></i>
                                <i class="fa-regular fa-trash-can table-action-icon delete" style="color: #e03131;"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container">
            <span class="text-secondary small">Showing 1-5 of 124 tenants</span>
            <div class="d-flex gap-1 align-items-center">
                <a href="#" class="page-link-custom"><i class="fa-solid fa-chevron-left"
                        style="font-size: 10px;"></i></a>
                <a href="#" class="page-link-custom active">1</a>
                <a href="#" class="page-link-custom">2</a>
                <a href="#" class="page-link-custom">3</a>
                <a href="#" class="page-link-custom"><i class="fa-solid fa-chevron-right"
                        style="font-size: 10px;"></i></a>
            </div>
        </div>
    </div>
@endsection
