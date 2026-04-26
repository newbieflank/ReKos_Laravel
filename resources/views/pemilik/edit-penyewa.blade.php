@extends('layouts.pemilik')

@section('title', 'Edit Penyewa - RE-KOST')

@section('content')
    <style>
        .container-fluid-custom {
            width: 100%;
            max-width: 780px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .form-label-custom {
            font-size: 0.75rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }

        .form-control-custom {
            background-color: #f1f3f5;
            border: 1px solid #f1f3f5;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #495057;
            transition: all 0.2s;
            width: 100%;
        }

        .form-control-custom:focus {
            background-color: #fff;
            border-color: #0d6efd;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        }

        .form-section-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f3f5;
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .section-icon-box {
            width: 40px;
            height: 40px;
            background-color: #e6f0ff;
            color: #0d6efd;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .btn-primary-custom {
            background-color: #4a85f6;
            color: white;
            border-radius: 8px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
            transition: 0.2s;
        }

        .btn-primary-custom:hover {
            background-color: #3b71d8;
        }

        .btn-cancel {
            background-color: #e9ecef;
            color: #495057;
            border-radius: 8px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
            transition: 0.2s;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #dee2e6;
            color: #212529;
        }
    </style>

    <div class="container-fluid-custom pb-5">
        <a href="{{ route('pemilik.penyewa') }}" class="btn btn-light border btn-sm mb-3 text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Penyewa
        </a>

        <h3 class="fw-bold text-dark mb-1 mt-2">Edit Data Penyewa</h3>
        <p class="text-secondary small mb-4">Perbarui informasi sewa dan status penyewa.</p>

        <form action="{{ route('pemilik.penyewa.update', $tenant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section-card">
                <div class="section-title-wrap">
                    <div class="section-icon-box"><i class="fa-solid fa-user"></i></div>
                    <h5 class="fw-bold mb-0">Informasi Penyewa</h5>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">Nama Penyewa</label>
                        <input type="text" class="form-control-custom" value="{{ $tenant->user->name ?? '-' }}" readonly
                            style="background-color: #f8f9fa; color: #6c757d;">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">Email</label>
                        <input type="text" class="form-control-custom" value="{{ $tenant->user->email ?? '-' }}" readonly
                            style="background-color: #f8f9fa; color: #6c757d;">
                    </div>
                </div>
            </div>

            <div class="form-section-card">
                <div class="section-title-wrap">
                    <div class="section-icon-box"><i class="fa-solid fa-bed"></i></div>
                    <h5 class="fw-bold mb-0">Detail Sewa</h5>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">Kamar</label>
                        <select name="room_id" class="form-control-custom" required>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ $tenant->room_id == $room->id ? 'selected' : '' }}>
                                    {{ $room->room_name }} ({{ $room->boardingHouse->boarding_house_name ?? '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">Tipe Sewa</label>
                        <select name="rental_type" class="form-control-custom" required>
                            <option value="daily" {{ $tenant->rental_type === 'daily' ? 'selected' : '' }}>Harian
                            </option>
                            <option value="weekly" {{ $tenant->rental_type === 'weekly' ? 'selected' : '' }}>Mingguan
                            </option>
                            <option value="monthly" {{ $tenant->rental_type === 'monthly' ? 'selected' : '' }}>Bulanan
                            </option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">Tanggal Masuk</label>
                        <input type="date" name="start_date" class="form-control-custom"
                            value="{{ $tenant->start_date?->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">Tanggal Keluar <span class="text-muted fw-normal"
                                style="text-transform:none;">(opsional)</span></label>
                        <input type="date" name="end_date" class="form-control-custom"
                            value="{{ $tenant->end_date?->format('Y-m-d') }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">Total Bayar (Rp)</label>
                        <input type="number" name="total_price" class="form-control-custom"
                            value="{{ $tenant->total_price }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">Status Sewa</label>
                        <select name="status" class="form-control-custom" required>
                            <option value="active" {{ $tenant->status === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="pending" {{ $tenant->status === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="complete" {{ $tenant->status === 'complete' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="cancelled" {{ $tenant->status === 'cancelled' ? 'selected' : '' }}>Terminated
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('pemilik.penyewa') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-primary-custom">
                    <i class="fa-regular fa-floppy-disk me-2"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
@endsection
