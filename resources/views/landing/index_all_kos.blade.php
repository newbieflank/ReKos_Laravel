@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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
    </style>
@endpush

@section('content')

    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="mb-3">
                <button onclick="history.back()" class="btn btn-light shadow-sm rounded-pill px-3 py-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </button>
            </div>
            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-2">Pilihan Kost Terbaik di Sekitarmu</h3>
                <p class="text-muted">Menyesuaikan dengan lokasi Anda saat ini, ini adalah pilihan tepat untuk Anda.</p>
            </div>


            @if($rooms->count() > 0)
                <div class="row g-3">
                    @foreach($rooms as $room)
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ route('detail', ['id' => $room->boardingHouse->id, 'room_id' => $room->id]) }}" class="text-decoration-none">
                                <div class="card card-kost h-100 p-2 border shadow-sm">
                                    @if($room->main_image)
                                        <img src="{{ asset($room->main_image) }}" class="card-img-top rounded-3 object-fit-cover" style="height: 180px;" alt="Kamar">
                                    @else
                                        <div class="card-img-top rounded-3 d-flex align-items-center justify-content-center bg-light text-muted" style="height: 180px;">
                                            <i class="fa-solid fa-bed fs-2"></i>
                                        </div>
                                    @endif
                                    <div class="card-body px-2 pb-1 pt-3 text-start">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="fw-bold text-dark mb-0">{{ $room->room_name }}</h6>
                                                <div class="d-flex align-items-center mt-1">
                                                    <i class="fas fa-star text-warning" style="font-size: 0.75rem;"></i>
                                                    <span class="ms-1 small fw-medium">{{ number_format($room->boardingHouse->rating ?? 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1"
                                                style="font-size: 0.7rem;">{{ $room->room_type }}</span>
                                        </div>
                                        @php
                                            $typeMap = ['male' => 'Putra', 'female' => 'Putri', 'mixed' => 'Campur'];
                                            $typeLabel = $typeMap[$room->boardingHouse->boarding_house_type] ?? ucfirst($room->boardingHouse->boarding_house_type);
                                        @endphp
                                        <p class="text-muted small mb-1"><i class="fas fa-house text-secondary me-1"></i> {{ Str::limit($room->boardingHouse->boarding_house_name, 25) }} <span class="ms-1 fw-bold text-primary" style="font-size: 0.7rem;">({{ $typeLabel }})</span></p>
                                        @php
                                            $alamat = $room->boardingHouse->alamat ?? '';
                                            $alamatParts = array_map('trim', explode(',', $alamat));
                                            $area = 'Bondowoso';
                                            if (count($alamatParts) >= 6 && strtolower($alamatParts[count($alamatParts) - 5]) === 'bondowoso') {
                                                $area = $alamatParts[count($alamatParts) - 6];
                                            } elseif (count($alamatParts) > 1) {
                                                $area = $alamatParts[1];
                                            }
                                        @endphp
                                        <p class="text-dark small mb-1 fw-medium"><i class="fas fa-map text-success me-1"></i> Area {{ Str::limit($area, 20) }}</p>
                                        <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ Str::limit($alamat, 25) }}</p>

                                        @if($room->available)
                                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 mb-2"
                                                style="font-size: 0.7rem;"><i class="fa-solid fa-door-open me-1"></i>
                                                Tersedia</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 mb-2"
                                                style="font-size: 0.7rem;"><i class="fa-solid fa-door-closed me-1"></i>
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
            @else
                <div class="text-center py-5 my-5">
                    <i class="fa-solid fa-search fs-1 text-muted mb-3 opacity-50"></i>
                    <h5 class="fw-bold text-dark">Kost Tidak Ditemukan</h5>
                    <p class="text-muted">Maaf, tidak ada kost yang sesuai dengan kriteria pencarian Anda.<br>Silakan coba filter atau area yang lain.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                        640: { slidesPerView: 2, spaceBetween: 20 },
                        768: { slidesPerView: 3, spaceBetween: 30 },
                        1024: { slidesPerView: 4, spaceBetween: 30 },
                    },
                });
            });

            // Initialize review slider
            document.querySelectorAll('.reviewSwiper').forEach((el) => {
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
                        640: { slidesPerView: 2, spaceBetween: 20 },
                        768: { slidesPerView: 3, spaceBetween: 30 },
                        1024: { slidesPerView: 4, spaceBetween: 30 },
                    },
                });
            });
        });
    </script>
@endpush