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
            background-color: #dc3545;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: 0.2s;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-add {
            background-color: #e6f0ff;
            color: #0d6efd;
        }

        .btn-add:hover {
            background-color: #0d6efd;
            color: #fff;
        }

        .btn-edit {
            background-color: #f8f9fa;
            color: #495057;
            border-color: #e9ecef;
        }

        .btn-edit:hover {
            background-color: #e9ecef;
            color: #212529;
        }

        .btn-expense {
            background-color: #fff3cd;
            color: #ffc107;
            border-color: #ffe69c;
        }

        .btn-expense:hover {
            background-color: #ffc107;
            color: #fff;
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
        <a href="{{ route('pemilik.kost') }}" class="btn btn-primary btn-sm mb-3 text-white"><i
                class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Kost</a>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="text-dark fw-bold mb-1">Daftar Kamar - {{ $kost->boarding_house_name }}</h3>
                <p class="text-secondary small mb-0">Kelola hunian, fasilitas, dan status penyewa Kost Anda.</p>
            </div>
            <a href="{{ route('pemilik.kamar.tambah', $kost->id) }}" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                <i class="fa-solid fa-plus me-2"></i> Tambah Kamar
            </a>
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

        <form action="{{ route('pemilik.kamar', $kost->id) }}" method="GET" class="row mb-4">
            <div class="col-12">
                <div class="search-filter-bar">
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        <input type="text" name="search" class="search-input" placeholder="Cari nomor kamar..." value="{{ $search }}">
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('pemilik.kamar', ['id' => $kost->id, 'search' => $search]) }}" 
                           class="filter-btn {{ !$statusFilter ? 'active' : 'inactive' }} text-decoration-none d-flex align-items-center">SEMUA</a>
                        <a href="{{ route('pemilik.kamar', ['id' => $kost->id, 'status' => 'tersedia', 'search' => $search]) }}" 
                           class="filter-btn {{ $statusFilter === 'tersedia' ? 'active' : 'inactive' }} text-decoration-none d-flex align-items-center">TERSEDIA</a>
                        <a href="{{ route('pemilik.kamar', ['id' => $kost->id, 'status' => 'terisi', 'search' => $search]) }}" 
                           class="filter-btn {{ $statusFilter === 'terisi' ? 'active' : 'inactive' }} text-decoration-none d-flex align-items-center">TERISI</a>
                    </div>
                </div>
            </div>
        </form>

        <div class="row g-4 mb-3" id="roomsContainer">

            @forelse($rooms as $room)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 room-wrapper"
                    data-room-name="{{ strtolower($room->room_name) }}"
                    data-room-status="{{ $room->available ? 'tersedia' : 'terisi' }}">
                    <div class="room-card p-4 {{ !$room->available ? 'bg-light border' : '' }}"
                        style="{{ !$room->available ? 'opacity: 0.85;' : '' }}">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0 {{ $room->available ? 'text-primary' : 'text-secondary' }}">
                                {{ $room->room_name }}</h5>
                            <button class="btn-info-icon" title="Detail Kamar" data-bs-toggle="modal"
                                data-bs-target="#detailKamarModal{{ $room->id }}"><i
                                    class="fa-solid fa-info"></i></button>
                        </div>
                        <p class="text-secondary small mb-3">
                            @if ($room->available)
                                <span class="text-success fw-medium"><i class="fa-solid fa-check-circle me-1"></i> Tersedia</span>
                            @else
                                @php
                                    $activeTenant = $room->tenants->first();
                                @endphp
                                <span class="text-danger fw-medium"><i class="fa-solid fa-user-lock me-1"></i> Terisi</span>
                                @if($activeTenant && $activeTenant->user)
                                    <span class="d-block mt-1 text-dark fw-bold"><i class="fa-regular fa-user me-1"></i> {{ $activeTenant->user->name }}</span>
                                @endif
                            @endif
                        </p>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @if (is_array($room->facilities))
                                @foreach (array_slice($room->facilities, 0, 3) as $fasilitas)
                                    <span class="room-badge">{{ $fasilitas }}</span>
                                @endforeach
                                @if (count($room->facilities) > 3)
                                    <span class="room-badge">{{ count($room->facilities) - 3 }}+</span>
                                @endif
                            @else
                                <span class="room-badge">Fasilitas Standar</span>
                            @endif
                        </div>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="status-dot {{ $room->available ? 'tersedia' : 'terisi' }}"
                                title="{{ $room->available ? 'Tersedia' : 'Terisi' }}"></span>
                            <div class="d-flex gap-2">

                                <a href="{{ route('pemilik.kamar.edit', ['id' => $kost->id, 'room_id' => $room->id]) }}"
                                    class="action-btn btn-edit text-decoration-none" title="Edit Data"><i
                                        class="fa-solid fa-pen"></i></a>
                                <form
                                    action="{{ route('pemilik.kamar.duplicate', ['id' => $kost->id, 'room_id' => $room->id]) }}"
                                    method="POST" class="m-0"
                                    onsubmit="event.preventDefault(); Swal.fire({ title: 'Duplikasi Kamar?', text: 'Masukkan jumlah kamar yang ingin diduplikasi:', icon: 'question', input: 'number', inputAttributes: { min: 1, step: 1 }, inputValue: 1, showCancelButton: true, confirmButtonColor: '#0d6efd', cancelButtonColor: '#6c757d', confirmButtonText: 'Duplikasi', cancelButtonText: 'Batal', inputValidator: (value) => { if (!value || value < 1) { return 'Jumlah harus minimal 1!' } } }).then((result) => { if (result.isConfirmed) { let input = document.createElement('input'); input.type = 'hidden'; input.name = 'quantity'; input.value = result.value; this.appendChild(input); this.submit(); } });">
                                    @csrf
                                    <button type="submit" class="action-btn btn-edit border-0" title="Duplikasi Kamar">
                                        <i class="fa-solid fa-copy"></i>
                                    </button>
                                </form>
                                <form
                                    action="{{ route('pemilik.kamar.hapus', ['id' => $kost->id, 'room_id' => $room->id]) }}"
                                    method="POST" class="m-0"
                                    onsubmit="event.preventDefault(); confirmDelete(this, 'Yakin ingin menghapus kamar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-expense border-0" title="Hapus Kamar"
                                        style="background-color: #fee2e2; color: #ef4444;"><i
                                            class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada data kamar untuk kost ini. Silakan tambahkan kamar baru.
                    </p>
                </div>
            @endforelse

            @if($rooms->count() < 8)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <a href="{{ route('pemilik.kamar.tambah', $kost->id) }}" class="add-room-card text-decoration-none">
                        <i class="fa-solid fa-plus mb-2" style="font-size: 28px;"></i>
                        <h5 class="fw-bold mb-0">Tambah Kamar</h5>
                    </a>
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-center mb-5">
            {{ $rooms->links('pagination::bootstrap-5') }}
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
                                        <h3 class="fw-bold text-dark mb-0">{{ $totalRooms }}</h3>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="stat-box border-left-primary">
                                        <p class="text-muted small fw-bold mb-1"
                                            style="font-size: 0.65rem; letter-spacing: 1px;">TERISI</p>
                                        <h3 class="fw-bold text-dark mb-0">{{ $occupiedRooms }}</h3>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="stat-box">
                                        <p class="text-muted small fw-bold mb-1"
                                            style="font-size: 0.65rem; letter-spacing: 1px;">TERSEDIA</p>
                                        <h3 class="fw-bold text-primary mb-0">{{ $availableRooms }}</h3>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="stat-box">
                                        <p class="text-muted small fw-bold mb-1"
                                            style="font-size: 0.65rem; letter-spacing: 1px;">EFISIENSI</p>
                                        <h3 class="fw-bold mb-0" style="color: #20c997;">{{ $occupancyRate }}%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @push('modals')
    @foreach($rooms as $room)
        <div class="modal fade" id="detailKamarModal{{ $room->id }}" tabindex="-1"
            aria-labelledby="detailKamarModalLabel{{ $room->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content modal-content-custom shadow-lg">
                    <div class="modal-header border-0 pb-0 px-4 pt-4">
                        <h5 class="modal-title text-primary fw-bold"
                            id="detailKamarModalLabel{{ $room->id }}">Detail {{ $room->room_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="row mb-5">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <h5 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                                    Status: {{ $room->available ? 'Tersedia' : 'Terisi' }} <span
                                        class="status-dot {{ $room->available ? 'tersedia' : 'terisi' }}"></span>
                                </h5>
                                <p class="text-muted small fw-bold mb-0" style="letter-spacing: 1px;">
                                    TIPE : <span class="text-dark">{{ strtoupper($room->room_type) }}</span>
                                </p>
                            </div>
                            <div class="col-12 col-md-6 text-md-end">
                                <p class="text-muted small fw-bold mb-1" style="letter-spacing: 0.5px;">
                                    UKURAN : <span class="text-dark">{{ $room->room_size }} Meter</span>
                                </p>
                                <p class="text-muted small fw-bold mb-0" style="letter-spacing: 0.5px;">
                                    HARGA : <span class="text-dark">Rp
                                        {{ number_format($room->monthly_price, 0, ',', '.') }}/Bulan</span>
                                </p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="section-title mb-3">FASILITAS KAMAR</div>
                            <div class="row g-3">
                                @if (is_array($room->facilities) && count($room->facilities) > 0)
                                    @foreach ($room->facilities as $fac)
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="facility-box"><i
                                                    class="fa-solid fa-check text-primary"></i>
                                                {{ $fac }}</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <p class="text-muted small">Tidak ada fasilitas.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('pemilik.kamar.edit', ['id' => $kost->id, 'room_id' => $room->id]) }}"
                            class="btn-update-status text-decoration-none d-flex justify-content-center align-items-center gap-2">
                            Edit Kamar <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endpush

@endsection

@push('scripts')
    <script>
        // Backend filtering is now handled by the controller
    </script>
@endpush
