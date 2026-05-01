<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kos - Re-Kost</title>
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
            $fotoFasilitasKost = !empty($otherKost[1]) ? asset($otherKost[1]) : null;
            $fotoLainnyaKost = !empty($otherKost[2]) ? $otherKost[2] : null;

            $firstRoom = isset($selectedRoom) && $selectedRoom ? $selectedRoom : $kos->rooms->first();
            $fotoKamar = $firstRoom && $firstRoom->main_image ? asset($firstRoom->main_image) : null;

            $otherKamar = $firstRoom && $firstRoom->other_images ? json_decode($firstRoom->other_images, true) : [];
            $fotoKamarMandi = !empty($otherKamar[0]) ? asset($otherKamar[0]) : null;
            $fotoFasilitasKamar = !empty($otherKamar[1]) ? asset($otherKamar[1]) : null;
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
                    <img src="{{ $fotoKamar }}" class="w-100 h-100 object-fit-cover rounded" alt="Foto Kamar">
                @else
                    <div
                        class="w-100 h-100 bg-light rounded d-flex flex-column align-items-center justify-content-center text-muted border">
                        <i class="fa-solid fa-bed fs-1 mb-2 text-secondary"></i>
                        <span>Belum ada foto kamar</span>
                    </div>
                @endif
            </div>
            <div class="col-12 col-md-4 d-none d-md-flex flex-column gap-2 h-100">
                <div class="w-100 rounded" style="height: calc(50% - 4px);">
                    @if ($fotoBangunan)
                        <img src="{{ $fotoBangunan }}" class="w-100 h-100 object-fit-cover rounded" alt="Foto Bangunan">
                    @else
                        <div
                            class="w-100 h-100 bg-light rounded d-flex flex-column align-items-center justify-content-center text-muted border">
                            <i class="fa-solid fa-building fs-1 mb-2 text-secondary"></i>
                            <span>Belum ada foto bangunan</span>
                        </div>
                    @endif
                </div>
                <div class="position-relative w-100 rounded" style="height: calc(50% - 4px);">
                    @if ($fotoTampakDepan)
                        <img src="{{ $fotoTampakDepan }}" class="w-100 h-100 object-fit-cover rounded"
                            alt="Foto Tampak Depan">
                    @else
                        <div
                            class="w-100 h-100 bg-light rounded d-flex flex-column align-items-center justify-content-center text-muted border">
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

                <a href="{{ route('payments.create', $kos->id) }}"
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
                    'wifi' => 'fa-solid fa-wifi',
                    'internet' => 'fa-solid fa-wifi',
                    'ac' => 'fa-solid fa-fan',
                    'kipas' => 'fa-solid fa-fan',
                    'dapur' => 'fa-solid fa-fire-burner',
                    'kompor' => 'fa-solid fa-fire-burner',
                    '24 jam' => 'fa-regular fa-clock',
                    'meja' => 'fa-solid fa-table',
                    'parkir' => 'fa-solid fa-square-parking',
                    'mobil' => 'fa-solid fa-car',
                    'motor' => 'fa-solid fa-motorcycle',
                    'lemari' => 'fa-solid fa-door-closed',
                    'tv' => 'fa-solid fa-tv',
                    'televisi' => 'fa-solid fa-tv',
                    'kamar mandi' => 'fa-solid fa-bath',
                    'wc' => 'fa-solid fa-toilet',
                    'laundry' => 'fa-solid fa-shirt',
                    'cuci' => 'fa-solid fa-shirt',
                    'kasur' => 'fa-solid fa-bed',
                    'bed' => 'fa-solid fa-bed',
                    'cctv' => 'fa-solid fa-video',
                    'keamanan' => 'fa-solid fa-shield-halved',
                    'kunci' => 'fa-solid fa-key',
                    'air' => 'fa-solid fa-faucet-drip',
                    'kulkas' => 'fa-solid fa-snowflake',
                    'musholla' => 'fa-solid fa-mosque',
                    'masjid' => 'fa-solid fa-mosque',
                    'kursi' => 'fa-solid fa-chair',
                ];

                $getIcon = function ($name) use ($facilityIcons) {
                    $lowerName = strtolower($name);
                    foreach ($facilityIcons as $keyword => $icon) {
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
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold title-text" id="galleryModalLabel">Galeri Foto Properti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 p-md-5">

                    <div class="mb-5">
                        <h5 class="fw-bold mb-3 heading-text"><i class="fa-solid fa-building text-primary me-2"></i>
                            Foto Bangunan</h5>
                        <div class="row g-3">
                            @if ($fotoBangunan)
                                <div class="col-12 col-md-6">
                                    <img src="{{ $fotoBangunan }}" class="w-100 rounded object-fit-cover shadow-sm"
                                        style="height: 300px;" alt="Foto Bangunan">
                                </div>
                            @endif
                            @if ($fotoTampakDepan)
                                <div class="col-12 col-md-6">
                                    <img src="{{ $fotoTampakDepan }}"
                                        class="w-100 rounded object-fit-cover shadow-sm" style="height: 300px;"
                                        alt="Foto Tampak Depan">
                                </div>
                            @endif
                            @if (!$fotoBangunan && !$fotoTampakDepan)
                                <div class="col-12 text-muted fst-italic">Belum ada foto bangunan diunggah.</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold mb-3 heading-text"><i class="fa-solid fa-bed text-primary me-2"></i> Foto
                            Kamar</h5>
                        <div class="row g-3">
                            @if ($fotoKamar)
                                <div class="col-12 col-md-6">
                                    <img src="{{ $fotoKamar }}" class="w-100 rounded object-fit-cover shadow-sm"
                                        style="height: 300px;" alt="Foto Kamar">
                                </div>
                            @else
                                <div class="col-12 text-muted fst-italic">Belum ada foto kamar diunggah.</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold mb-3 heading-text"><i class="fa-solid fa-bath text-primary me-2"></i> Foto
                            Kamar Mandi</h5>
                        <div class="row g-3">
                            @if ($fotoKamarMandi)
                                <div class="col-12 col-md-6">
                                    <img src="{{ $fotoKamarMandi }}" class="w-100 rounded object-fit-cover shadow-sm"
                                        style="height: 300px;" alt="Foto Kamar Mandi">
                                </div>
                            @else
                                <div class="col-12 text-muted fst-italic">Belum ada foto kamar mandi diunggah.</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold mb-3 heading-text"><i class="fa-solid fa-couch text-primary me-2"></i> Foto
                            Fasilitas Umum</h5>
                        <div class="row g-3">
                            @if ($fotoFasilitasKost)
                                <div class="col-12 col-md-6">
                                    <div class="position-relative h-100">
                                        <img src="{{ $fotoFasilitasKost }}"
                                            class="w-100 rounded object-fit-cover shadow-sm" style="height: 300px;"
                                            alt="Fasilitas Kost">
                                        <span
                                            class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75">Fasilitas
                                            Kost</span>
                                    </div>
                                </div>
                            @endif
                            @if ($fotoFasilitasKamar)
                                <div class="col-12 col-md-6">
                                    <div class="position-relative h-100">
                                        <img src="{{ $fotoFasilitasKamar }}"
                                            class="w-100 rounded object-fit-cover shadow-sm" style="height: 300px;"
                                            alt="Fasilitas Kamar">
                                        <span
                                            class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75">Fasilitas
                                            Dalam Kamar</span>
                                    </div>
                                </div>
                            @endif
                            @if (!$fotoFasilitasKost && !$fotoFasilitasKamar)
                                <div class="col-12 text-muted fst-italic">Belum ada foto fasilitas diunggah.</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5 class="fw-bold mb-3 heading-text"><i class="fa-solid fa-images text-primary me-2"></i>
                            Foto Lainnya</h5>
                        <div class="row g-3">
                            @if ($fotoLainnyaKost)
                                @if (is_array($fotoLainnyaKost))
                                    @foreach ($fotoLainnyaKost as $img)
                                        <div class="col-12 col-md-6">
                                            <div class="position-relative h-100">
                                                <img src="{{ asset($img) }}"
                                                    class="w-100 rounded object-fit-cover shadow-sm"
                                                    style="height: 300px;" alt="Lainnya Kost">
                                                <span
                                                    class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75">Kost</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 col-md-6">
                                        <div class="position-relative h-100">
                                            <img src="{{ asset($fotoLainnyaKost) }}"
                                                class="w-100 rounded object-fit-cover shadow-sm"
                                                style="height: 300px;" alt="Lainnya Kost">
                                            <span
                                                class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75">Kost</span>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if ($fotoLainnyaKamar)
                                @if (is_array($fotoLainnyaKamar))
                                    @foreach ($fotoLainnyaKamar as $img)
                                        <div class="col-12 col-md-6">
                                            <div class="position-relative h-100">
                                                <img src="{{ asset($img) }}"
                                                    class="w-100 rounded object-fit-cover shadow-sm"
                                                    style="height: 300px;" alt="Lainnya Kamar">
                                                <span
                                                    class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75">Kamar</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 col-md-6">
                                        <div class="position-relative h-100">
                                            <img src="{{ asset($fotoLainnyaKamar) }}"
                                                class="w-100 rounded object-fit-cover shadow-sm"
                                                style="height: 300px;" alt="Lainnya Kamar">
                                            <span
                                                class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75">Kamar</span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if (!$fotoLainnyaKost && !$fotoLainnyaKamar)
                                <div class="col-12 text-muted fst-italic">Belum ada foto lainnya diunggah.</div>
                            @endif
                        </div>
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
