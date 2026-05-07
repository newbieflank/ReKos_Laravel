@extends('layouts.pemilik')

@section('title', 'Dashboard Pemilik - RE-KOST')

@section('content')
    <div class="mb-4">
        <h3 class="text-primary fw-bold mb-1">Dashboard</h3>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom p-4 h-100">
                <p class="text-muted small fw-bold mb-2">TOTAL PENDAPATAN (1 Tahun)</p>
                <h2 class="text-primary fw-bold mb-3">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h2>
                <i class="fa-solid fa-money-bill-wave card-bg-icon text-primary"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom p-4 h-100">
                <p class="text-muted small fw-bold mb-2">TOTAL PENGELUARAN (1 Tahun)</p>
                <h2 class="text-dark fw-bold mb-3">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h2>
                <i class="fa-solid fa-credit-card card-bg-icon text-secondary"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom p-4 h-100">
                <p class="text-muted small fw-bold mb-2">KAMAR TERLARIS</p>
                @if($bestSellingRoom)
                    <h4 class="text-success fw-bold mb-1 text-truncate" title="{{ $bestSellingRoom->boardingHouse->name ?? '' }} - {{ $bestSellingRoom->room_name }}">
                        {{ $bestSellingRoom->room_name }}
                    </h4>
                    <span class="small text-muted">{{ $bestSellingRoom->tenants_count }} kali ditempati</span>
                @else
                    <h4 class="text-muted fw-bold mb-1">Belum Ada</h4>
                    <span class="small text-muted">-</span>
                @endif
                <i class="fa-solid fa-bed card-bg-icon text-success"></i>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom p-4 h-100 text-white" style="background-color: #4a85f6;">
                <p class="small fw-bold mb-2 text-white-50">GUEST RATING</p>
                <div class="d-flex align-items-end gap-2 mb-2">
                    @if ($totalReviews == 0)
                        <h2 class="fw-bold mb-0">0 / 0</h2>
                        <span class="mb-1 text-white-50">Rate</span>
                    @else
                        <h2 class="fw-bold mb-0">{{ number_format($avgRating, 1) }} / 5</h2>
                        <span class="mb-1 text-white-50">({{ $totalReviews }} Ulasan)</span>
                    @endif
                </div>
                <div class="text-warning mb-0 fs-5">
                    @php
                        $ratingInt = round($avgRating);
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $ratingInt)
                            <i class="fa-solid fa-star"></i>
                        @else
                            <i class="fa-regular fa-star"></i>
                        @endif
                    @endfor
                </div>
                <i class="fa-solid fa-shield-check card-bg-icon text-white"></i>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Grafik Keuangan</h5>
                    </div>
                    <div class="btn-group" role="group">
                        @foreach ($availableYears as $year)
                            <a href="{{ route('pemilik.dashboard', ['year' => $year]) }}"
                                class="btn {{ $year == $currentYear ? 'btn-primary' : 'btn-light border text-muted' }} btn-sm">{{ $year }}</a>
                        @endforeach
                    </div>
                </div>

                <div style="height: 350px;">
                    <canvas id="keuanganChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Grafik Kamar Terlaris</h5>
                        <p class="text-muted small mb-0">Berdasarkan total pesanan</p>
                    </div>
                </div>
                <div style="height: 350px;" class="d-flex justify-content-center align-items-center">
                    @if(count($chartRoomNames) > 0)
                        <canvas id="kamarTerlarisChart"></canvas>
                    @else
                        <div class="text-center text-muted">
                            <i class="fa-solid fa-bed fs-1 mb-2 text-light"></i>
                            <p>Belum ada data kamar terlaris</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('keuanganChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($months) !!},
                    datasets: [{
                            label: 'Pendapatan',
                            data: {!! json_encode($chartIncome) !!},
                            backgroundColor: '#0d6efd',
                            borderRadius: 2,
                            barPercentage: 0.8,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Pengeluaran',
                            data: {!! json_encode($chartExpense) !!},
                            backgroundColor: '#495057',
                            borderRadius: 2,
                            barPercentage: 0.8,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Chart Kamar Terlaris (Doughnut)
            @if(count($chartRoomNames) > 0)
            const kamarCtx = document.getElementById('kamarTerlarisChart').getContext('2d');
            new Chart(kamarCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chartRoomNames) !!},
                    datasets: [{
                        data: {!! json_encode($chartRoomCounts) !!},
                        backgroundColor: [
                            '#0d6efd', // primary
                            '#4a85f6', // lighter primary
                            '#198754', // success
                            '#ffc107', // warning
                            '#0dcaf0'  // info
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });
            @endif
        });
    </script>
@endpush
