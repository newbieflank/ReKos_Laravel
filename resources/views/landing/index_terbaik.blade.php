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
    <section class="section-biru" style="padding-top: 100px; padding-bottom: 60px;">
        <div class="container">
            <div class="mb-3">
                <button onclick="history.back()" class="btn btn-light shadow-sm rounded-pill px-3 py-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </button>
            </div>
            <div class="text-center mb-5">
                <h6 class="text-uppercase fw-bold text-light mb-1" style="letter-spacing: 1px;">REKOMENDASI</h6>
                <h2 class="fw-bold">Kost Terbaik di Bondowoso</h2>
            </div>

            <div class="row g-3">
                @foreach($rooms as $room)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('detail', $room->boardingHouse->id) }}" class="text-decoration-none">
                            <div class="card card-kost h-100 p-2 border-0 shadow-sm">
                                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                    class="card-img-top rounded-3" alt="Kamar">
                                <div class="card-body px-2 pb-1 pt-3 text-start">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-bold text-dark mb-0">{{ $room->room_name }}</h6>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1"
                                            style="font-size: 0.7rem;">{{ $room->room_type }}</span>
                                    </div>
                                    <p class="text-muted small mb-1"><i class="fas fa-house text-secondary me-1"></i>
                                        {{ Str::limit($room->boardingHouse->boarding_house_name, 25) }}</p>
                                    <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        {{ Str::limit($room->boardingHouse->alamat, 25) }}</p>

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
        </div>
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