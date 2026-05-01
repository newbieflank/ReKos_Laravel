@extends('layouts.app')

@section('content')
<div class="container py-5 mt-4" style="min-height: 80vh;">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('home') }}" class="text-dark text-decoration-none fs-4 fw-bold">
            <i class="fas fa-chevron-left me-2"></i> Riwayat
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            @forelse($histories as $history)
            <div class="card mb-3 rounded-4 shadow-sm border" style="border-color: #e5e7eb;">
                <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div class="d-flex align-items-center mb-3 mb-md-0 w-100">
                        <!-- Image -->
                        <div class="flex-shrink-0 me-3">
                            <a href="{{ route('detail', ['id' => $history->room->boardingHouse->id ?? 0, 'room_id' => $history->room->id ?? 0]) }}">
                                @if(isset($history->room) && $history->room->main_image)
                                    <img src="{{ asset($history->room->main_image) }}" 
                                        class="rounded-3 object-fit-cover shadow-sm" 
                                        style="width: 100px; height: 100px;"
                                        alt="Kamar Kost">
                                @else
                                    <div class="rounded-3 d-flex align-items-center justify-content-center bg-light text-muted border shadow-sm" style="width: 100px; height: 100px;">
                                        <i class="fa-solid fa-bed fs-3"></i>
                                    </div>
                                @endif
                            </a>
                        </div>
                        
                        <!-- Details -->
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <a href="{{ route('detail', ['id' => $history->room->boardingHouse->id ?? 0, 'room_id' => $history->room->id ?? 0]) }}" class="text-decoration-none text-dark">
                                    <h5 class="fw-bold mb-0 text-dark hover-primary" style="font-size: 1.1rem; transition: color 0.2s;">{{ $history->room->boardingHouse->boarding_house_name ?? 'Nama Kost Tidak Diketahui' }}</h5>
                                </a>
                                <div class="d-md-none">
                                    @if(in_array(strtolower($history->status), ['active', 'sedang disewa']))
                                        <span class="badge bg-primary text-white px-2 py-1 rounded" style="font-size: 0.65rem;">SEDANG DISEWA</span>
                                    @elseif(in_array(strtolower($history->status), ['completed', 'selesai']))
                                        <span class="badge bg-success text-white px-2 py-1 rounded" style="font-size: 0.65rem;">SELESAI</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-2 py-1 rounded" style="font-size: 0.65rem;">{{ strtoupper($history->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="text-muted mb-2 small">{{ $history->room->room_type ?? 'Tipe Kamar' }} - {{ $history->room->room_name ?? 'No.' }}</p>
                            
                            <!-- Rating Dropdown -->
                            @php
                                $boardingHouseId = $history->room->boardingHouse->id ?? null;
                                $hasReviewed = $boardingHouseId && isset($reviews) && $reviews->has($boardingHouseId);
                            @endphp

                            <div class="mt-2 dropdown">
                                @if($hasReviewed)
                                    @php
                                        $userReview = $reviews->get($boardingHouseId);
                                    @endphp
                                    <div class="d-flex align-items-center gap-1 text-warning mt-2" style="font-size: 0.9rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($userReview->rating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - $userReview->rating < 1 && $i - $userReview->rating > 0)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="text-muted ms-1 small text-dark fw-medium">{{ number_format($userReview->rating, 1) }}/5</span>
                                    </div>
                                    @if($userReview->review)
                                        <p class="text-muted small mt-1 mb-0 fst-italic">"{{ Str::limit($userReview->review, 50) }}"</p>
                                    @endif
                                @else
                                    <button class="btn btn-sm text-primary p-0 bg-transparent shadow-none d-flex align-items-center gap-1" type="button" id="ratingDropdown{{ $history->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: 500;">
                                        <i class="far fa-star"></i> Beri Rating <i class="fas fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                                    </button>
                                    <div class="dropdown-menu p-3 shadow border-0" aria-labelledby="ratingDropdown{{ $history->id }}" style="min-width: 260px; border-radius: 12px; margin-top: 10px;">
                                        <h6 class="fw-bold mb-3 text-dark" style="font-size: 0.95rem;">Nilai Pengalamanmu</h6>
                                        <form action="{{ route('user.history.review') }}" method="POST" class="rating-form">
                                            @csrf
                                            <input type="hidden" name="boarding_house_id" value="{{ $boardingHouseId }}">
                                            <input type="hidden" name="rating" class="rating-input" value="0">
                                            
                                            <div class="d-flex mb-3 star-container" style="gap: 5px;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star fs-4 star-icon" data-value="{{ $i }}" style="color: #e5e7eb; cursor: pointer; transition: color 0.2s;"></i>
                                                @endfor
                                            </div>
                                            <div class="mb-3">
                                                <textarea name="review" class="form-control form-control-sm border-0 bg-light" rows="3" placeholder="Tulis ulasan Anda (opsional)..." style="resize: none; border-radius: 8px;"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill fw-medium py-2">Kirim Ulasan</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="text-md-end text-start d-flex flex-column justify-content-between align-items-md-end h-100 flex-shrink-0" style="min-width: 150px;">
                        <!-- Status Badge -->
                        <div class="d-none d-md-block mb-3 text-end">
                            @if(in_array(strtolower($history->status), ['active', 'sedang disewa']))
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill" style="font-size: 0.7rem; font-weight: 600;">SEDANG DISEWA</span>
                            @elseif(in_array(strtolower($history->status), ['completed', 'selesai']))
                                <span class="badge bg-success text-white px-3 py-1 rounded-pill" style="font-size: 0.7rem; font-weight: 600;">SELESAI</span>
                            @else
                                <span class="badge bg-secondary text-white px-3 py-1 rounded-pill" style="font-size: 0.7rem; font-weight: 600;">{{ strtoupper($history->status) }}</span>
                            @endif
                        </div>
                        
                        <div class="mt-auto d-flex flex-md-column justify-content-between align-items-center align-items-md-end w-100">
                            <h5 class="text-primary fw-bold mb-md-2 mb-0 fs-5">Rp {{ number_format($history->total_price ?? 0, 0, ',', '.') }}</h5>
                            <button class="btn btn-primary btn-sm px-4 rounded-3 fw-semibold">Perpanjang</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-history text-muted mb-3" style="font-size: 3rem;"></i>
                <p class="text-muted">Belum ada riwayat kost.</p>
            </div>
            @endforelse

            @if($histories->count() > 0)
            <div class="text-center mt-4">
                <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium border-1">
                    Show Older History <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prevent dropdown from closing when clicking inside it
        document.querySelectorAll('.dropdown-menu form').forEach(form => {
            form.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });

        const starContainers = document.querySelectorAll('.star-container');

        starContainers.forEach(container => {
            const stars = container.querySelectorAll('.star-icon');
            const ratingInput = container.closest('form').querySelector('.rating-input');
            let selectedRating = 0;

            stars.forEach(star => {
                // Hover event
                star.addEventListener('mouseover', () => {
                    const val = parseInt(star.getAttribute('data-value'));
                    stars.forEach(s => {
                        s.style.color = parseInt(s.getAttribute('data-value')) <= val ? '#FBBF24' : '#e5e7eb';
                    });
                });

                // Mouseout event
                star.addEventListener('mouseout', () => {
                    stars.forEach(s => {
                        s.style.color = parseInt(s.getAttribute('data-value')) <= selectedRating ? '#FBBF24' : '#e5e7eb';
                    });
                });

                // Click event
                star.addEventListener('click', () => {
                    selectedRating = parseInt(star.getAttribute('data-value'));
                    ratingInput.value = selectedRating;
                    stars.forEach(s => {
                        s.style.color = parseInt(s.getAttribute('data-value')) <= selectedRating ? '#FBBF24' : '#e5e7eb';
                    });
                });
            });
        });
    });
</script>
@endpush
