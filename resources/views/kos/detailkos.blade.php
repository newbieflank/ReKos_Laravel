<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Re-Kost</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        html {
            scroll-behavior: smooth;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .scroll-section {
            scroll-margin-top: 100px;
        }

        .nav-tabs-custom {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .nav-tabs-custom::-webkit-scrollbar {
            display: none;
        }

        .tab-link {
            color: #6c757d;
            font-weight: 600;
            text-decoration: none;
            padding-bottom: 8px;
            margin-right: 24px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .tab-link.active {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
        }

        .tab-link:hover {
            color: #0d6efd;
        }

        .gallery-main {
            height: 250px;
        }

        .gallery-sub {
            height: 120px;
        }

        .title-text {
            font-size: 1.25rem;
        }

        .price-text {
            font-size: 1.25rem;
        }

        .heading-text {
            font-size: 1.1rem;
        }

        .body-text {
            font-size: 0.85rem;
        }

        .icon-text {
            font-size: 0.85rem;
        }

        @media (min-width: 768px) {
            .gallery-wrapper {
                height: 400px;
            }

            .gallery-main {
                height: 100%;
            }

            .gallery-sub {
                height: 50%;
            }

            .title-text {
                font-size: 1.75rem;
            }

            .price-text {
                font-size: 1.5rem;
            }

            .heading-text {
                font-size: 1.25rem;
            }

            .body-text {
                font-size: 1rem;
            }

            .icon-text {
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body class="bg-light">

    @include('partials.navbar')

    <div class="container bg-white my-4 p-3 p-md-4 shadow-sm rounded">

        <a href="{{ url('/') }}" class="text-decoration-none text-muted mb-3 d-inline-block fw-medium body-text">
            <i class="fa-solid fa-chevron-left me-2 p-2 bg-light rounded-circle"></i> Back
        </a>

        @php
            $mainKost = $kos->main_image ? asset($kos->main_image) : null;
            $otherKost = $kos->other_images ? json_decode($kos->other_images, true) : [];

            $fotoBangunan = $mainKost;
            $fotoTampakDepan = !empty($otherKost[0]) ? asset($otherKost[0]) : null;
            $fotoFasilitasKost = !empty($otherKost[1]) ? $otherKost[1] : null;
            $fotoLainnyaKost = !empty($otherKost[2]) ? $otherKost[2] : null;

            $firstRoom = isset($selectedRoom) && $selectedRoom ? $selectedRoom : $kos->rooms->first();
            $fotoKamar = $firstRoom && $firstRoom->main_image ? asset($firstRoom->main_image) : null;

            $otherKamar = $firstRoom && $firstRoom->other_images ? json_decode($firstRoom->other_images, true) : [];
            $fotoKamarMandi = !empty($otherKamar[0]) ? asset($otherKamar[0]) : null;
            $fotoFasilitasKamar = !empty($otherKamar[1]) ? $otherKamar[1] : null;
            $fotoLainnyaKamar = !empty($otherKamar[2]) ? $otherKamar[2] : null;
        @endphp

        <style>
            .gallery-wrapper {
                height: 300px;
                overflow: hidden;
            }

            @media (min-width: 768px) {
                .gallery-wrapper {
                    height: 450px;
                }
            }
        </style>

        <div class="row g-2 mb-4 mb-md-5 gallery-wrapper position-relative">
            <div class="col-12 col-md-8 h-100">
                @if ($fotoKamar)
                    <img src="{{ $fotoKamar }}" class="w-100 h-100 object-fit-cover rounded" alt="Foto Kamar" data-bs-toggle="modal" data-bs-target="#galleryModal" style="cursor: pointer;">
                @else
                    <div
                        class="w-100 h-100 bg-light rounded d-flex flex-column align-items-center justify-content-center text-muted border" data-bs-toggle="modal" data-bs-target="#galleryModal" style="cursor: pointer;">
                        <i class="fa-solid fa-bed fs-1 mb-2 text-secondary"></i>
                        <span>Belum ada foto kamar</span>
                    </div>
                @endif
            </div>
            <div class="col-12 col-md-4 d-none d-md-flex flex-column gap-2 h-100">
                <div class="w-100 rounded" style="height: calc(50% - 4px);">
                    @if ($fotoBangunan)
                        <img src="{{ $fotoBangunan }}" class="w-100 h-100 object-fit-cover rounded" alt="Foto Bangunan" data-bs-toggle="modal" data-bs-target="#galleryModal" style="cursor: pointer;">
                    @else
                        <div
                            class="w-100 h-100 bg-light rounded d-flex flex-column align-items-center justify-content-center text-muted border" data-bs-toggle="modal" data-bs-target="#galleryModal" style="cursor: pointer;">
                            <i class="fa-solid fa-building fs-1 mb-2 text-secondary"></i>
                            <span>Belum ada foto bangunan</span>
                        </div>
                    @endif
                </div>
                <div class="position-relative w-100 rounded" style="height: calc(50% - 4px);">
                    @if ($fotoTampakDepan)
                        <img src="{{ $fotoTampakDepan }}" class="w-100 h-100 object-fit-cover rounded"
                            alt="Foto Tampak Depan" data-bs-toggle="modal" data-bs-target="#galleryModal" style="cursor: pointer;">
                    @else
                        <div
                            class="w-100 h-100 bg-light rounded d-flex flex-column align-items-center justify-content-center text-muted border" data-bs-toggle="modal" data-bs-target="#galleryModal" style="cursor: pointer;">
                            <i class="fa-solid fa-image fs-1 mb-2 text-secondary"></i>
                            <span>Belum ada foto tampak depan</span>
                        </div>
                    @endif
                    <div class="position-absolute w-100 h-100 top-0 start-0 bg-dark bg-opacity-25 rounded d-flex align-items-end justify-content-end p-3"
                        data-bs-toggle="modal" data-bs-target="#galleryModal" style="cursor: pointer; transition: 0.3s;"
                        onmouseover="this.classList.add('bg-opacity-50')"
                        onmouseout="this.classList.remove('bg-opacity-50')">
                        <button class="btn btn-light fw-bold shadow-sm px-3 py-2"><i
                                class="fa-solid fa-images me-2"></i> Lihat Semua Foto</button>
                    </div>
                </div>
            </div>
            <!-- Mobile overlay button -->
            <div class="col-12 d-md-none position-absolute bottom-0 end-0 p-3 d-flex justify-content-end"
                style="z-index: 10;">
                <button class="btn btn-light fw-bold shadow-sm px-3 py-2" data-bs-toggle="modal"
                    data-bs-target="#galleryModal"><i class="fa-solid fa-images me-2"></i> Lihat Semua</button>
            </div>
        </div>

        <div id="info-umum" class="row border-bottom pb-4 mb-4 scroll-section">
            <div class="col-12 col-md-7">
                <div class="d-flex mb-4 border-bottom nav-tabs-custom body-text">
                    <a href="#" class="tab-link active" onclick="changeTab(event, 'info-umum', this)">Info
                        Umum</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'fasilitas', this)">Fasilitas</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'lokasi', this)">Lokasi</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'kebijakan', this)">Kebijakan</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'tentang', this)">Tentang</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'ulasan', this)">Ulasan</a>
                </div>

                <h2 class="fw-bold title-text mb-1">{{ $firstRoom ? $firstRoom->room_name : 'Kamar' }}</h2>
                <h5 class="text-muted fw-semibold mb-2"><i
                        class="fa-solid fa-house-chimney text-secondary me-2"></i>{{ $kos->boarding_house_name }}</h5>
                <div class="d-flex flex-wrap align-items-center mb-2 gap-2 text-warning body-text">
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($rating))
                                <i class="fa-solid fa-star"></i>
                            @elseif($i == ceil($rating) && $rating - floor($rating) > 0)
                                <i class="fa-solid fa-star-half-stroke"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-muted fw-medium">{{ number_format($rating, 1) }} ({{ $reviewsCount }}
                        Reviews)</span>
                    @if ($firstRoom && $firstRoom->available)
                        <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1"
                            style="font-size: 0.75rem;"><i class="fa-solid fa-door-open me-1"></i> Kamar Tersedia</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1"
                            style="font-size: 0.75rem;"><i class="fa-solid fa-door-closed me-1"></i> Kamar Penuh</span>
                    @endif
                </div>
                <p class="text-muted mb-0 body-text"><i class="fa-solid fa-location-dot me-2"></i> {{ $kos->alamat }}
                </p>
            </div>

            <div
                class="col-12 col-md-5 d-flex flex-column justify-content-end mt-4 mt-md-0 border-top border-md-0 pt-3 pt-md-0">
                <div class="p-3 p-md-4 rounded-4 shadow-sm mb-3 ms-md-auto"
                    style="background: linear-gradient(145deg, #ffffff, #f8f9fa); border: 1px solid #e9ecef; width: 100%; max-width: 350px;">
                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                        <i class="fa-solid fa-tags text-warning me-2 fs-5"></i>
                        <span class="text-secondary fw-bold text-uppercase"
                            style="font-size: 0.8rem; letter-spacing: 0.5px;">Tarif Sewa</span>
                    </div>

                    @if ($hargaHarian > 0)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-secondary border px-2 py-1 rounded-1">Harian</span>
                            <span class="fw-bold text-dark" style="font-size: 1.05rem;">Rp
                                {{ number_format($hargaHarian, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    @if ($hargaMingguan > 0)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-secondary border px-2 py-1 rounded-1">Mingguan</span>
                            <span class="fw-bold text-dark" style="font-size: 1.05rem;">Rp
                                {{ number_format($hargaMingguan, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    @if ($hargaBulanan > 0)
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-2">Bulanan</span>
                            <span class="fw-bold text-primary fs-4">Rp
                                {{ number_format($hargaBulanan, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

                <a href="{{ route('payments.create', $kos->rooms->first()->id) }}"
                    class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm ms-md-auto d-flex align-items-center justify-content-center gap-2"
                    style="width: 100%; max-width: 350px;">
                    <i class="fa-solid fa-check-circle"></i> Ajukan Sewa
                </a>
            </div>
        </div>

        <div id="spesifikasi" class="border-bottom pb-4 mb-4 scroll-section">
            <h5 class="fw-bold mb-4 heading-text">Spesifikasi Kamar</h5>
            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded p-2 me-3 text-primary d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-ruler-combined fs-5"></i>
                        </div>
                        <div>
                            <span class="d-block text-muted small">Ukuran Kamar</span>
                            <span
                                class="fw-medium body-text">{{ $firstRoom && $firstRoom->room_size ? $firstRoom->room_size : 'Belum ditentukan' }}
                                Meter</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="fasilitas" class="border-bottom pb-4 mb-4 scroll-section">
            <h5 class="fw-bold mb-4 heading-text">Fasilitas</h5>
            @php
                $facilityIcons = [
                    // Kost - Umum Dasar
                    'area parkir' => 'fa-solid fa-car',
                    'parkir' => 'fa-solid fa-square-parking',
                    'mobil' => 'fa-solid fa-car',
                    'motor' => 'fa-solid fa-motorcycle',
                    'dapur' => 'fa-solid fa-kitchen-set',
                    'kompor' => 'fa-solid fa-fire-burner',
                    'kamar mandi luar' => 'fa-solid fa-shower',
                    'kamar mandi' => 'fa-solid fa-bath',
                    'km luar' => 'fa-solid fa-shower',
                    'wc' => 'fa-solid fa-toilet',
                    'area jemur' => 'fa-solid fa-wind',
                    'jemur' => 'fa-solid fa-wind',
                    'wi-fi' => 'fa-solid fa-wifi',
                    'wifi' => 'fa-solid fa-wifi',
                    'internet' => 'fa-solid fa-wifi',
                    // Kost - Keamanan
                    'cctv' => 'fa-solid fa-camera',
                    'penjaga kost' => 'fa-solid fa-user-shield',
                    'penjaga' => 'fa-solid fa-user-shield',
                    'satpam' => 'fa-solid fa-user-shield',
                    'keamanan' => 'fa-solid fa-shield-halved',
                    'kunci' => 'fa-solid fa-key',
                    // Kost - Kenyamanan & Ekstra
                    'ruang tamu' => 'fa-solid fa-couch',
                    'peralatan elektronik' => 'fa-solid fa-plug',
                    'mesin cuci' => 'fa-solid fa-jug-detergent',
                    'kulkas' => 'fa-solid fa-temperature-low',
                    'rak buku' => 'fa-solid fa-book-open',
                    'ruang belajar' => 'fa-solid fa-book-open',
                    'mushola' => 'fa-solid fa-place-of-worship',
                    'musholla' => 'fa-solid fa-place-of-worship',
                    'masjid' => 'fa-solid fa-mosque',
                    // Kamar
                    'ac' => 'fa-solid fa-snowflake',
                    'kipas angin' => 'fa-solid fa-fan',
                    'kipas' => 'fa-solid fa-fan',
                    'tv' => 'fa-solid fa-tv',
                    'televisi' => 'fa-solid fa-tv',
                    'stop kontak' => 'fa-solid fa-plug',
                    'kasur' => 'fa-solid fa-bed',
                    'bed' => 'fa-solid fa-bed',
                    'lemari pakaian' => 'fa-solid fa-box-archive',
                    'lemari' => 'fa-solid fa-box-archive',
                    'meja' => 'fa-solid fa-table',
                    'kursi' => 'fa-solid fa-chair',
                    'bantal' => 'fa-solid fa-moon',
                    'guling' => 'fa-solid fa-moon',
                    'lampu' => 'fa-solid fa-lightbulb',
                    // Lainnya
                    '24 jam' => 'fa-regular fa-clock',
                    'air' => 'fa-solid fa-faucet-drip',
                ];

                $getIcon = function ($name) use ($facilityIcons) {
                    $lowerName = strtolower($name);
                    // Cari dari yang paling spesifik (panjang) ke paling umum (pendek)
                    $sorted = $facilityIcons;
                    uksort($sorted, fn($a, $b) => strlen($b) - strlen($a));
                    foreach ($sorted as $keyword => $icon) {
                        if (str_contains($lowerName, $keyword)) {
                            return $icon;
                        }
                    }
                    return 'fa-solid fa-circle-check';
                };
            @endphp

            <h6 class="fw-bold text-dark mb-3">Fasilitas Umum (Kos)</h6>
            <div class="row gy-3 mb-4">
                @if ($kos->facilities && count($kos->facilities) > 0)
                    @foreach ($kos->facilities as $f)
                        <div class="col-6 col-md-3 text-muted d-flex align-items-center">
                            <div class="d-flex justify-content-center align-items-center bg-light rounded-circle me-3"
                                style="width: 36px; height: 36px;">
                                <i class="{{ $getIcon($f) }} text-primary" style="font-size: 1rem;"></i>
                            </div>
                            <span class="fw-medium icon-text">{{ $f }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-muted">Belum ada data fasilitas umum</div>
                @endif
            </div>

            <h6 class="fw-bold text-dark mb-3">Fasilitas Kamar</h6>
            <div class="row gy-3 mb-4">
                @php
                    $roomFacilities = [];
                    foreach ($kos->rooms as $room) {
                        if (is_array($room->facilities)) {
                            $roomFacilities = array_merge($roomFacilities, $room->facilities);
                        }
                    }
                    $roomFacilities = array_unique($roomFacilities);
                @endphp

                @if (count($roomFacilities) > 0)
                    @foreach ($roomFacilities as $f)
                        <div class="col-6 col-md-3 text-muted d-flex align-items-center">
                            <div class="d-flex justify-content-center align-items-center bg-light rounded-circle me-3"
                                style="width: 36px; height: 36px;">
                                <i class="{{ $getIcon($f) }} text-primary" style="font-size: 1rem;"></i>
                            </div>
                            <span class="fw-medium icon-text">{{ $f }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-muted">Belum ada data fasilitas kamar</div>
                @endif
            </div>
        </div>

        <div id="lokasi" class="border-bottom pb-4 mb-4 scroll-section">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="bg-secondary rounded w-100" style="height: 250px; overflow: hidden;">
                        <iframe
                            src="https://www.google.com/maps?q={{ $kos->latitude ?? '-8.1751105' }},{{ $kos->longitude ?? '113.7051936' }}&hl=es;z=14&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="text-muted body-text lh-lg">{{ $kos->alamat }}</p>
                </div>
            </div>
        </div>

        <div id="kebijakan" class="border-bottom pb-4 mb-4 scroll-section">
            <h5 class="fw-bold mb-4 heading-text">Kebijakan</h5>
            <div class="row">
                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <p class="fw-bold text-dark mb-0 body-text">Yang Harus Diketahui</p>
                </div>
                <div class="col-12 col-md-9">
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <p class="text-muted mb-0 body-text">{{ $kos->house_rule ?? 'Belum ada kebijakan' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="tentang" class="border-bottom pb-4 mb-4 scroll-section">
            <h5 class="fw-bold mb-3 heading-text">Tentang {{ $kos->boarding_house_name }}</h5>
            <div class="text-muted body-text lh-lg">
                <p>{{ $kos->description ?? 'Belum ada deskripsi' }}</p>
            </div>
        </div>

        <div id="ulasan" class="pb-4 mb-4 scroll-section">
            <h5 class="fw-bold mb-3 heading-text">Ulasan Penyewa</h5>
            @if ($kos->reviews && $kos->reviews->count() > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach ($kos->reviews as $review)
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(145deg, #ffffff, #f8f9fa); border: 1px solid #e9ecef !important;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold shadow-sm" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $review->user->name ?? 'Anonim' }}</h6>
                                        <div class="text-warning small mt-1 d-flex align-items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-regular fa-star text-secondary opacity-25"></i>
                                                @endif
                                            @endfor
                                            <span class="text-muted ms-2" style="font-size: 0.8rem;"><i class="fa-regular fa-clock me-1"></i>{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-secondary mb-0 body-text fst-italic lh-lg">"{!! nl2br(e($review->review)) !!}"</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-muted body-text bg-light p-5 rounded-4 text-center border" style="border-style: dashed !important;">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-regular fa-comment-dots fs-3 text-primary"></i>
                    </div>
                    <p class="mb-0 fw-medium">Belum ada ulasan untuk kost ini.</p>
                    <small class="opacity-75">Jadilah yang pertama menyewa dan memberikan ulasan!</small>
                </div>
            @endif
        </div>

        {{--
        <div class="mt-4 mb-2 text-center">
            <button class="btn btn-primary w-100 fw-bold py-3 shadow-sm heading-text">
                Tanya Pemilik Sebelum Sewa
            </button>
        </div>
        --}}

    </div>

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-0">
                <div class="modal-header border-0 pb-0 position-absolute w-100" style="z-index: 1055;">
                    <h5 class="modal-title fw-bold title-text" id="galleryModalLabel">Galeri Foto Properti</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @php
                                $allImages = [];
                                if ($fotoKamar) $allImages[] = ['src' => $fotoKamar, 'label' => 'Foto Kamar'];
                                if ($fotoBangunan) $allImages[] = ['src' => $fotoBangunan, 'label' => 'Foto Bangunan'];
                                if ($fotoTampakDepan) $allImages[] = ['src' => $fotoTampakDepan, 'label' => 'Foto Tampak Depan'];
                                if ($fotoKamarMandi) $allImages[] = ['src' => $fotoKamarMandi, 'label' => 'Foto Kamar Mandi'];

                                if ($fotoFasilitasKost) {
                                    if (is_array($fotoFasilitasKost)) {
                                        foreach ($fotoFasilitasKost as $img) $allImages[] = ['src' => asset($img), 'label' => 'Fasilitas Kos'];
                                    } else {
                                        $allImages[] = ['src' => asset($fotoFasilitasKost), 'label' => 'Fasilitas Kos'];
                                    }
                                }
                                if ($fotoFasilitasKamar) {
                                    if (is_array($fotoFasilitasKamar)) {
                                        foreach ($fotoFasilitasKamar as $img) $allImages[] = ['src' => asset($img), 'label' => 'Fasilitas Kamar'];
                                    } else {
                                        $allImages[] = ['src' => asset($fotoFasilitasKamar), 'label' => 'Fasilitas Kamar'];
                                    }
                                }
                                if ($fotoLainnyaKost) {
                                    if (is_array($fotoLainnyaKost)) {
                                        foreach ($fotoLainnyaKost as $img) $allImages[] = ['src' => asset($img), 'label' => 'Lainnya Kos'];
                                    } else {
                                        $allImages[] = ['src' => asset($fotoLainnyaKost), 'label' => 'Lainnya Kos'];
                                    }
                                }
                                if ($fotoLainnyaKamar) {
                                    if (is_array($fotoLainnyaKamar)) {
                                        foreach ($fotoLainnyaKamar as $img) $allImages[] = ['src' => asset($img), 'label' => 'Lainnya Kamar'];
                                    } else {
                                        $allImages[] = ['src' => asset($fotoLainnyaKamar), 'label' => 'Lainnya Kamar'];
                                    }
                                }
                                
                                $uniqueImages = [];
                                $addedUrls = [];
                                foreach($allImages as $img) {
                                    if(!in_array($img['src'], $addedUrls)) {
                                        $addedUrls[] = $img['src'];
                                        $uniqueImages[] = $img;
                                    }
                                }
                            @endphp

                            @if(count($uniqueImages) > 0)
                                @foreach($uniqueImages as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
                                            <img src="{{ $image['src'] }}" class="d-block w-100" style="max-height: 100%; object-fit: contain;" alt="{{ $image['label'] }}">
                                        </div>
                                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded px-3 py-1 mb-3">
                                            <h5 class="mb-0">{{ $image['label'] }}</h5>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-center align-items-center text-white" style="height: 80vh;">
                                        <h5>Belum ada foto</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if(count($uniqueImages) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function changeTab(event, targetId, element) {
            event.preventDefault();

            let tabs = document.querySelectorAll('.tab-link');
            tabs.forEach(tab => tab.classList.remove('active'));

            element.classList.add('active');

            let targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    </script>
</body>

</html>
