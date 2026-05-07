@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <style>
        .swiper-container-wrapper {
            position: relative;
            padding: 0 50px;
        }

        .swiper {
            width: 100%;
            height: 100%;
            padding-bottom: 50px;
        }

        .swiper-slide {
            height: auto;
        }

        .swiper-pagination-bullet {
            background: #59A1FF;
        }

        .section-biru .swiper-pagination-bullet {
            background: #fff;
        }

        /* Swiper Navigation Buttons */
        .swiper-button-next,
        .swiper-button-prev {
            color: #59A1FF;
            background: rgba(255, 255, 255, 1);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            margin-top: -22px;
        }

        .swiper-button-prev {
            left: 0;
        }

        .swiper-button-next {
            right: 0;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 18px;
            font-weight: bold;
        }

        .section-biru .swiper-button-next,
        .section-biru .swiper-button-prev {
            color: #59A1FF;
        }

        /* Custom Styling for Choices.js */
        .choices {
            margin-bottom: 0;
            width: 100%;
        }
        .choices__inner {
            background-color: transparent !important;
            border: none !important;
            padding: 0 !important;
            min-height: auto !important;
            display: flex;
            align-items: center;
        }
        .choices__list--single {
            padding: 0 !important;
            font-weight: 600;
            color: #4A5568 !important;
        }
        .choices__list--dropdown {
            border-radius: 15px !important;
            border: none !important;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
            margin-top: 15px !important;
            padding: 8px !important;
            z-index: 1000 !important;
        }
        .choices__item--selectable {
            border-radius: 10px !important;
            padding: 10px 15px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease;
        }
        .choices__item--selectable.is-highlighted {
            background-color: #E6F0FF !important;
            color: #0d6efd !important;
        }
        .choices[data-type*="select-one"]:after {
            display: none !important; /* Hide default arrow */
        }
        .search-pill-wrapper {
            background-color: #f8f9fa;
            border-radius: 50px;
            padding: 8px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        .search-pill-wrapper:hover {
            background-color: #eef2f7;
        }
        .search-pill-wrapper:focus-within {
            background-color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        .choices__placeholder {
            opacity: 1;
            color: #718096 !important;
        }
    </style>
@endpush

@section('content')
    <div id="hero" class="container mt-5">
        <div class="row align-items-center p-4 p-md-5 mx-1">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="fw-bold display-5 mb-3" style="color: #1A202C;">
                    Cari Kost Terbaik di Bondowoso, Temukan Hunian Nyaman untukmu.
                </h1>
                <p class="text-muted mb-4 fs-5">
                    Platform pencarian tempat tinggal no 1 dan aman di Indonesia yang siap membantumu menemukan tempat
                    beristirahat!
                </p>
                <button class="btn btn-primary btn-lg px-4 fs-6 text-white mb-4 shadow-sm">
                    Mulai Cari
                </button>
                <div class="d-flex gap-5">
                    <div>
                        <h3 class="fw-bold text-primary mb-0">{{ $totalPengguna }}+</h3>
                        <span class="text-muted small">Pengguna</span>
                    </div>
                    <div>
                        <h3 class="fw-bold text-primary mb-0">{{ $totalKost }}+</h3>
                        <span class="text-muted small">Kost-kostan</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Kamar Kost" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>

    <div class="container" style="margin-bottom: -50px; position: relative; z-index: 10;">
        <div class="row mx-0 mx-md-1">
            <div class="col-12 px-0">
                <form action="{{ route('allkos.index') }}" method="GET"
                    class="bg-white p-3 p-md-4 rounded-4 shadow-sm d-flex flex-column flex-md-row align-items-end justify-content-between gap-3"
                    style="box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;">

                    <div class="flex-grow-1 w-100">
                        <label class="form-label text-dark small fw-bold ms-2 mb-2">Harga</label>
                        <div class="search-pill-wrapper">
                            <i class="fas fa-money-bill-wave me-2 text-primary opacity-75"></i>
                            <select name="harga" class="choices-select">
                                <option value="">Pilih Harga</option>
                                <option value="100000">Rp 0 - Rp 100.000</option>
                                <option value="200000">Rp 100.000 - Rp 200.000</option>
                                <option value="300000">Rp 200.000 - Rp 300.000</option>
                                <option value="400000">Rp 300.000 - Rp 400.000</option>
                                <option value="500000">Rp 400.000 - Rp 500.000</option>
                                <option value="600000">Rp 500.000 - Rp 600.000</option>
                                <option value="700000">Rp 600.000 - Rp 700.000</option>
                                <option value="800000">Rp 700.000 - Rp 800.000</option>
                                <option value="900000">Rp 800.000 - Rp 900.000</option>
                                <option value="1000000">Rp 900.000 - Rp 1.000.000</option>
                                <option value="1000001">> Rp 1.000.000</option>
                            </select>
                            <i class="fas fa-chevron-down text-muted small ms-auto"></i>
                        </div>
                    </div>

                    <div class="flex-grow-1 w-100">
                        <label class="form-label text-dark small fw-bold ms-2 mb-2">Area</label>
                        <div class="search-pill-wrapper">
                            <i class="fas fa-map-marker-alt me-2 text-danger opacity-75"></i>
                            <select name="area" class="choices-select">
                                <option value="">Pilih Area</option>
                                @if (isset($areas) && count($areas) > 0)
                                    @foreach ($areas as $a)
                                        <option value="{{ $a }}">{{ $a }}</option>
                                    @endforeach
                                @else
                                    <option value="Kotakulon">Kotakulon</option>
                                @endif
                            </select>
                            <i class="fas fa-chevron-down text-muted small ms-auto"></i>
                        </div>
                    </div>

                    <div class="flex-grow-1 w-100">
                        <label class="form-label text-dark small fw-bold ms-2 mb-2">Tipe Kost</label>
                        <div class="search-pill-wrapper">
                            <i class="fas fa-users me-2 text-success opacity-75"></i>
                            <select name="tipe" class="choices-select">
                                <option value="">Pilih Tipe</option>
                                <option value="male">Putra</option>
                                <option value="female">Putri</option>
                                <option value="mixed">Campur</option>
                            </select>
                            <i class="fas fa-chevron-down text-muted small ms-auto"></i>
                        </div>
                    </div>

                    <div class="w-100" style="max-width: 140px;">
                        <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 fw-bold text-white shadow"
                            style="height: 48px;">Cari</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <section id="rekomendasi" class="section-biru" style="padding-top: 100px; padding-bottom: 60px;">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-uppercase fw-bold text-light mb-1" style="letter-spacing: 1px;">REKOMENDASI</h6>
                <h2 class="fw-bold">Kost Terbaik di Bondowoso</h2>
            </div>

            <div class="swiper-container-wrapper">
                <div class="swiper roomSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($rooms as $room)
                            <div class="swiper-slide">
                                <a href="{{ route('detail', ['id' => $room->boardingHouse->id, 'room_id' => $room->id]) }}"
                                    class="text-decoration-none">
                                    <div class="card card-kost h-100 p-2 border-0 shadow-sm">
                                        @if ($room->main_image)
                                            <img src="{{ asset($room->main_image) }}"
                                                class="card-img-top rounded-3 object-fit-cover" style="height: 180px;"
                                                alt="Kamar">
                                        @else
                                            <div class="card-img-top rounded-3 d-flex align-items-center justify-content-center bg-light text-muted"
                                                style="height: 180px;">
                                                <i class="fa-solid fa-bed fs-2"></i>
                                            </div>
                                        @endif
                                        <div class="card-body px-2 pb-1 pt-3 text-start">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-0">{{ $room->room_name }}</h6>
                                                    <div class="d-flex align-items-center mt-1">
                                                        <i class="fas fa-star text-warning" style="font-size: 0.75rem;"></i>
                                                        <span
                                                            class="ms-1 small fw-medium">{{ number_format($room->boardingHouse->rating ?? 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1"
                                                    style="font-size: 0.7rem;">{{ $room->room_type }}</span>
                                            </div>
                                            @php
                                                $typeMap = [
                                                    'male' => 'Putra',
                                                    'female' => 'Putri',
                                                    'mixed' => 'Campur',
                                                ];
                                                $typeLabel =
                                                    $typeMap[$room->boardingHouse->boarding_house_type] ??
                                                    ucfirst($room->boardingHouse->boarding_house_type);
                                            @endphp
                                            <p class="text-muted small mb-1"><i
                                                    class="fas fa-house text-secondary me-1"></i>
                                                {{ Str::limit($room->boardingHouse->boarding_house_name, 25) }} <span
                                                    class="ms-1 fw-bold text-primary"
                                                    style="font-size: 0.7rem;">({{ $typeLabel }})</span></p>
                                            @php
                                                $alamat = $room->boardingHouse->alamat ?? '';
                                                $alamatParts = array_map('trim', explode(',', $alamat));
                                                $area = 'Bondowoso';
                                                if (
                                                    count($alamatParts) >= 6 &&
                                                    strtolower($alamatParts[count($alamatParts) - 5]) === 'bondowoso'
                                                ) {
                                                    $area = $alamatParts[count($alamatParts) - 6];
                                                } elseif (count($alamatParts) > 1) {
                                                    $area = $alamatParts[1];
                                                }
                                            @endphp
                                            <p class="text-dark small mb-1 fw-medium"><i
                                                    class="fas fa-map text-success me-1"></i> Area
                                                {{ Str::limit($area, 20) }}</p>
                                            <p class="text-muted small mb-2"><i
                                                    class="fas fa-map-marker-alt text-danger me-1"></i>
                                                {{ Str::limit($alamat, 25) }}</p>

                                            @if ($room->available)
                                                <span
                                                    class="badge bg-success-subtle text-success rounded-pill px-2 py-1 mb-2"
                                                    style="font-size: 0.7rem;"><i class="fa-solid fa-door-open me-1"></i>
                                                    Tersedia</span>
                                            @else
                                                <span
                                                    class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 mb-2"
                                                    style="font-size: 0.7rem;"><i
                                                        class="fa-solid fa-door-closed me-1"></i>
                                                    Penuh</span>
                                            @endif

                                            <div class="mt-2 border-top pt-2">
                                                <span class="fw-bold text-primary fs-5">Rp
                                                    {{ number_format($room->monthly_price ?? 0, 0, ',', '.') }}<span
                                                        class="text-muted small fw-normal fs-6"> / Bulan</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-button-prev d-none d-md-flex"></div>
                <div class="swiper-button-next d-none d-md-flex"></div>
            </div>

            <div class="text-center mt-5">
                <a class="btn btn-light text-primary fw-bold rounded-pill px-5 py-2 shadow-sm bg-white"
                    href="{{ route('kosterbaik.index') }}">Lihat <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <section id="kostan" class="py-5 bg-white">
        <div class="container py-4">
            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-2">Kost-Kost yang ada di Bondowoso</h3>
                <p class="text-muted">Berikut ini adalah pilihan kost-kost di Bondowoso</p>
            </div>

            <div class="swiper-container-wrapper">
                <div class="swiper roomSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($rooms as $room)
                            <div class="swiper-slide">
                                <a href="{{ route('detail', ['id' => $room->boardingHouse->id, 'room_id' => $room->id]) }}"
                                    class="text-decoration-none">
                                    <div class="card card-kost h-100 p-2 border shadow-sm">
                                        @if ($room->main_image)
                                            <img src="{{ asset($room->main_image) }}"
                                                class="card-img-top rounded-3 object-fit-cover" style="height: 180px;"
                                                alt="Kamar">
                                        @else
                                            <div class="card-img-top rounded-3 d-flex align-items-center justify-content-center bg-light text-muted"
                                                style="height: 180px;">
                                                <i class="fa-solid fa-bed fs-2"></i>
                                            </div>
                                        @endif
                                        <div class="card-body px-2 pb-1 pt-3 text-start">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="fw-bold text-dark mb-0">{{ $room->room_name }}</h6>
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1"
                                                    style="font-size: 0.7rem;">{{ $room->room_type }}</span>
                                            </div>
                                            @php
                                                $typeMap = [
                                                    'male' => 'Putra',
                                                    'female' => 'Putri',
                                                    'mixed' => 'Campur',
                                                ];
                                                $typeLabel =
                                                    $typeMap[$room->boardingHouse->boarding_house_type] ??
                                                    ucfirst($room->boardingHouse->boarding_house_type);
                                            @endphp
                                            <p class="text-muted small mb-1"><i
                                                    class="fas fa-house text-secondary me-1"></i>
                                                {{ Str::limit($room->boardingHouse->boarding_house_name, 25) }} <span
                                                    class="ms-1 fw-bold text-primary"
                                                    style="font-size: 0.7rem;">({{ $typeLabel }})</span></p>
                                            @php
                                                $alamat = $room->boardingHouse->alamat ?? '';
                                                $alamatParts = array_map('trim', explode(',', $alamat));
                                                $area = 'Bondowoso';
                                                if (
                                                    count($alamatParts) >= 6 &&
                                                    strtolower($alamatParts[count($alamatParts) - 5]) === 'bondowoso'
                                                ) {
                                                    $area = $alamatParts[count($alamatParts) - 6];
                                                } elseif (count($alamatParts) > 1) {
                                                    $area = $alamatParts[1];
                                                }
                                            @endphp
                                            <p class="text-dark small mb-1 fw-medium"><i
                                                    class="fas fa-map text-success me-1"></i> Area
                                                {{ Str::limit($area, 20) }}</p>
                                            <p class="text-muted small mb-2"><i
                                                    class="fas fa-map-marker-alt text-danger me-1"></i>
                                                {{ Str::limit($alamat, 25) }}</p>

                                            @if ($room->available)
                                                <span
                                                    class="badge bg-success-subtle text-success rounded-pill px-2 py-1 mb-2"
                                                    style="font-size: 0.7rem;"><i class="fa-solid fa-door-open me-1"></i>
                                                    Tersedia</span>
                                            @else
                                                <span
                                                    class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 mb-2"
                                                    style="font-size: 0.7rem;"><i
                                                        class="fa-solid fa-door-closed me-1"></i> Penuh</span>
                                            @endif

                                            <div class="mt-2 border-top pt-2">
                                                <span class="fw-bold text-primary fs-5">Rp
                                                    {{ number_format($room->monthly_price ?? 0, 0, ',', '.') }}<span
                                                        class="text-muted small fw-normal fs-6"> / Bulan</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-button-prev d-none d-md-flex"></div>
                <div class="swiper-button-next d-none d-md-flex"></div>
            </div>
            <div class="text-center mt-5">
                <a class="btn btn-light text-primary fw-bold rounded-pill px-5 py-2 shadow-sm bg-white"
                    href="{{ route('allkos.index') }}">Lihat <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <div class="container my-5 py-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Kenapa Pilih Re-Kost?</h2>
            <p class="text-muted">Kami memberikan layanan terbaik untuk membantu menemukan hunianmu.</p>
        </div>

        <div class="row g-4 text-center">
            <div class="col-lg-3 col-md-6">
                <div class="card-kost bg-white p-4 h-100 border-0 shadow-sm rounded-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width: 70px; height: 70px; background-color: #fef0cd; border-radius: 20px;">
                        <i class="fas fa-star text-warning fs-3 mb-0"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Kost Terverifikasi</h5>
                    <p class="text-muted small mb-0 mt-2">Semua kost di platform kami telah dicek keasliannya dan
                        kualitasnya.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card-kost bg-white p-4 h-100 border-0 shadow-sm rounded-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width: 70px; height: 70px; background-color: #e5f5eb; border-radius: 20px;">
                        <i class="fas fa-sack-dollar text-success fs-3 mb-0"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Harga Transparan</h5>
                    <p class="text-muted small mb-0 mt-2">Tidak ada biaya tersembunyi. Harga yang kamu lihat adalah yang
                        dibayar.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card-kost bg-white p-4 h-100 border-0 shadow-sm rounded-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width: 70px; height: 70px; background-color: #fdf2e9; border-radius: 20px;">
                        <i class="fas fa-bolt text-warning fs-3 mb-0"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Booking Cepat</h5>
                    <p class="text-muted small mb-0 mt-2">Proses pemesanan dan pembayaran dapat dilakukan dalam hitungan
                        menit.</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card-kost bg-white p-4 h-100 border-0 shadow-sm rounded-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="width: 70px; height: 70px; background-color: #fbeceb; border-radius: 20px;">
                        <i class="fas fa-house-user text-danger fs-3 mb-0"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Banyak Pilihan</h5>
                    <p class="text-muted small mb-0 mt-2">Tersedia ribuan pilihan kost untuk mahasiswa maupun karyawan.</p>
                </div>
            </div>
        </div>
    </div>

    <section id="rating" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="fw-bold text-primary mb-1">Ulasam</h6>
                <h2 class="fw-bold">Ulasan Pengguna Re-Kost</h2>
            </div>

            {{-- Alert sukses/error --}}
            <div id="dynamicAlertContainer"></div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Review Slider: hanya dari database --}}
            @if ($reviews->isNotEmpty())
                <div class="swiper-container-wrapper mb-4">
                    <div class="swiper reviewSwiper">
                        <div class="swiper-wrapper">
                            @foreach ($reviews as $rev)
                                <div class="swiper-slide">
                                    <div class="p-4 rounded-4 bg-light border-0 h-100 text-start">
                                        <div class="text-warning mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($rev->rating))
                                                    <i class="fas fa-star"></i>
                                                @elseif($i - $rev->rating < 1 && $i - $rev->rating > 0)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-muted small fst-italic">"{{ $rev->review }}"</p>
                                        <div class="d-flex align-items-center mt-3">
                                            @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('avatars/' . $rev->user->id . '.jpg'))
                                                <img src="{{ asset('storage/avatars/' . $rev->user->id . '.jpg') }}"
                                                    class="rounded-circle me-2 object-fit-cover" width="40"
                                                    height="40" alt="User">
                                            @else
                                                <div class="rounded-circle me-2 d-flex align-items-center justify-content-center bg-primary text-white fw-bold flex-shrink-0"
                                                    style="width:40px;height:40px;font-size:16px;">
                                                    {{ strtoupper(substr($rev->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="fw-bold mb-0" style="font-size:14px;">{{ $rev->user->name }}
                                                </h6>
                                                <span class="text-muted" style="font-size:12px;">
                                                    {{ $rev->user->userDetail?->city ?? 'Pengguna Re-Kost' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class="swiper-button-prev d-none d-md-flex"></div>
                    <div class="swiper-button-next d-none d-md-flex"></div>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="far fa-comment-dots fs-1 mb-3 d-block" style="color:#dee2e6;"></i>
                    <p class="mb-0">Belum ada ulasan. Jadilah yang pertama memberi ulasan!</p>
                </div>
            @endif

            {{-- Form Rating --}}
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    <div class="p-4 rounded-4 bg-light border" style="background:#f8f9ff !important;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @auth
                                @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('avatars/' . auth()->user()->id . '.jpg'))
                                    <img src="{{ asset('storage/avatars/' . auth()->user()->id . '.jpg') }}"
                                        class="rounded-circle object-fit-cover" width="48" height="48"
                                        alt="Foto Profil">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white fw-bold flex-shrink-0"
                                        style="width:48px;height:48px;font-size:18px;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white flex-shrink-0"
                                    style="width:48px;height:48px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endauth
                            <div>
                                <div class="fw-semibold text-dark">
                                    @auth {{ auth()->user()->name }}
                                    @else
                                    Masuk untuk memberi ulasan @endauth
                                </div>
                                {{-- Bintang interaktif --}}
                                <div class="star-rating d-flex gap-1 mt-1" id="starRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star star-icon fs-5" data-value="{{ $i }}"
                                            style="color: #ddd; cursor: pointer; transition: color 0.15s;"
                                            id="star-{{ $i }}">
                                        </i>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        @auth
                            <form id="reviewForm" action="{{ route('app.review.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="rating" id="ratingInput" value="0">
                                <div class="input-group">
                                    <input type="text" name="review" id="reviewText"
                                        class="form-control rounded-start-pill border-end-0 @error('review') is-invalid @enderror"
                                        placeholder="Tulis ulasan anda disini..." style="border-color:#dee2e6;"
                                        maxlength="500">
                                    <button type="submit" class="btn btn-primary rounded-end-pill px-3"
                                        style="border-top-left-radius:0;border-bottom-left-radius:0;">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                                @error('review')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @error('rating')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </form>
                        @else
                            <div class="input-group">
                                <input type="text" class="form-control rounded-start-pill border-end-0"
                                    placeholder="Tulis ulasan anda disini..." disabled style="border-color:#dee2e6;">
                                <a href="{{ route('login') }}" class="btn btn-primary rounded-end-pill px-3">
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                            </div>
                            <p class="text-muted small mt-2"><a href="{{ route('login') }}" class="text-primary">Login</a>
                                untuk memberikan ulasan.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Choices.js
            const selects = document.querySelectorAll('.choices-select');
            selects.forEach(select => {
                new Choices(select, {
                    searchEnabled: false,
                    itemSelectText: '',
                    shouldSort: false,
                    classNames: {
                        containerOuter: 'choices',
                        containerInner: 'choices__inner',
                        input: 'choices__input',
                        inputCloned: 'choices__input--cloned',
                        list: 'choices__list',
                        listItems: 'choices__list--multiple',
                        listSingle: 'choices__list--single',
                        listDropdown: 'choices__list--dropdown',
                        item: 'choices__item',
                        itemSelectable: 'choices__item--selectable',
                        itemDisabled: 'choices__item--disabled',
                        itemChoice: 'choices__item--choice',
                        placeholder: 'choices__placeholder',
                        group: 'choices__group',
                        groupHeading: 'choices__heading',
                        button: 'choices__button',
                        activeState: 'is-active',
                        focusState: 'is-focused',
                        openState: 'is-open',
                        disabledState: 'is-disabled',
                        highlightState: 'is-highlighted',
                        selectedState: 'is-selected',
                        flippedState: 'is-flipped',
                        loadingState: 'is-loading',
                        noResults: 'has-no-results',
                        noChoices: 'has-no-choices'
                    }
                });
            });
            // Initialize all room sliders
            document.querySelectorAll('.roomSwiper').forEach((el) => {
                const container = el.closest('.swiper-container-wrapper');
                const prevEl = container.querySelector('.swiper-button-prev');
                const nextEl = container.querySelector('.swiper-button-next');
                const paginationEl = el.querySelector('.swiper-pagination');

                new Swiper(el, {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: nextEl,
                        prevEl: prevEl,
                    },
                    pagination: {
                        el: paginationEl,
                        clickable: true,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 30
                        },
                    },
                });
            });

            // Initialize review slider
            window.reviewSwiperInstances = [];
            document.querySelectorAll('.reviewSwiper').forEach((el) => {
                const container = el.closest('.swiper-container-wrapper');
                const prevEl = container.querySelector('.swiper-button-prev');
                const nextEl = container.querySelector('.swiper-button-next');
                const paginationEl = el.querySelector('.swiper-pagination');

                const swiper = new Swiper(el, {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    centerInsufficientSlides: true,
                    navigation: {
                        nextEl: nextEl,
                        prevEl: prevEl,
                    },
                    pagination: {
                        el: paginationEl,
                        clickable: true,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 30
                        },
                    },
                });
                window.reviewSwiperInstances.push(swiper);
            });

            // === Bintang Rating Interaktif ===
            const stars = document.querySelectorAll('.star-icon');
            const ratingInput = document.getElementById('ratingInput');
            let selectedRating = 0;

            stars.forEach(star => {
                // Hover: highlight bintang
                star.addEventListener('mouseover', () => {
                    const val = parseInt(star.getAttribute('data-value'));
                    stars.forEach(s => {
                        s.style.color = parseInt(s.getAttribute('data-value')) <= val ?
                            '#FBBF24' : '#ddd';
                    });
                });

                // Keluar hover: kembali ke selected
                star.addEventListener('mouseout', () => {
                    stars.forEach(s => {
                        s.style.color = parseInt(s.getAttribute('data-value')) <=
                            selectedRating ? '#FBBF24' : '#ddd';
                    });
                });

                // Klik: simpan rating
                star.addEventListener('click', () => {
                    selectedRating = parseInt(star.getAttribute('data-value'));
                    if (ratingInput) ratingInput.value = selectedRating;
                    stars.forEach(s => {
                        s.style.color = parseInt(s.getAttribute('data-value')) <=
                            selectedRating ? '#FBBF24' : '#ddd';
                    });
                });
            });

            // AJAX Form Submission untuk Review
            const reviewForm = document.getElementById('reviewForm');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalBtnHtml = submitBtn.innerHTML;
                    const dynamicAlertContainer = document.getElementById('dynamicAlertContainer');

                    // Reset alert container
                    dynamicAlertContainer.innerHTML = '';

                    // Validasi manual cepat
                    if (formData.get('rating') == '0') {
                        showAlert('danger', 'Silakan pilih rating bintang terlebih dahulu.');
                        return;
                    }
                    if (!formData.get('review').trim()) {
                        showAlert('danger', 'Silakan tulis ulasan Anda.');
                        return;
                    }

                    // Tampilkan loading
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            submitBtn.innerHTML = originalBtnHtml;
                            submitBtn.disabled = false;

                            if (data.success) {
                                // Tampilkan pesan sukses
                                showAlert('success', data.message);

                                // Buat elemen slide baru
                                const newSlide = generateReviewSlide(data.data);

                                // Tambahkan slide ke Swiper
                                if (window.reviewSwiperInstances && window.reviewSwiperInstances
                                    .length > 0) {
                                    const swiper = window.reviewSwiperInstances[0];
                                    swiper.appendSlide(newSlide);
                                    swiper.update();
                                    swiper.slideTo(swiper.slides.length - 1); // Geser ke slide terakhir
                                } else {
                                    // Jika swiper belum ada (belum ada review), reload page saja atau buat swiper baru
                                    window.location.reload();
                                }

                                // Reset form
                                reviewForm.reset();
                                selectedRating = 0;
                                ratingInput.value = 0;
                                stars.forEach(s => s.style.color = '#ddd');

                            } else {
                                // Tampilkan error (sudah review)
                                showAlert('danger', data.message || 'Terjadi kesalahan.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitBtn.innerHTML = originalBtnHtml;
                            submitBtn.disabled = false;
                            showAlert('danger', 'Terjadi kesalahan sistem. Coba lagi nanti.');
                        });
                });
            }

            // Helper untuk memunculkan alert
            function showAlert(type, message) {
                const dynamicAlertContainer = document.getElementById('dynamicAlertContainer');
                const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                dynamicAlertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="fas ${icon} me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            }

            // Helper untuk membuat HTML slide baru
            function generateReviewSlide(data) {
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= Math.floor(data.rating)) {
                        starsHtml += '<i class="fas fa-star"></i>';
                    } else if (i - data.rating < 1 && i - data.rating > 0) {
                        starsHtml += '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        starsHtml += '<i class="far fa-star"></i>';
                    }
                }

                let avatarHtml = '';
                if (data.user_avatar) {
                    avatarHtml =
                        `<img src="${data.user_avatar}" class="rounded-circle me-2 object-fit-cover" width="40" height="40" alt="User">`;
                } else {
                    avatarHtml =
                        `<div class="rounded-circle me-2 d-flex align-items-center justify-content-center bg-primary text-white fw-bold flex-shrink-0" style="width:40px;height:40px;font-size:16px;">${data.user_initial}</div>`;
                }

                return `
                <div class="swiper-slide">
                    <div class="p-4 rounded-4 bg-light border-0 h-100 text-start">
                        <div class="text-warning mb-2">
                            ${starsHtml}
                        </div>
                        <p class="text-muted small fst-italic">"${data.review}"</p>
                        <div class="d-flex align-items-center mt-3">
                            ${avatarHtml}
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size:14px;">${data.user_name}</h6>
                                <span class="text-muted" style="font-size:12px;">${data.user_city}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            }
        });
    </script>
@endpush
