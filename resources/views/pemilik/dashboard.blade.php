@extends('layouts.pemilik')

@section('title', 'Dashboard Pemilik - RE-KOST')

@section('content')
    <div class="mb-4">
        <h3 class="text-primary fw-bold mb-1">Dashboard</h3>
        <p class="text-secondary small">Selamat datang kembali, Pemilik. Berikut status kost Anda hari ini.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="card card-custom p-4 h-100">
                <p class="text-muted small fw-bold mb-2">PENDAPATAN</p>
                <h2 class="text-primary fw-bold mb-3">Rp. 1.000.000</h2>
                <i class="fa-solid fa-money-bill-wave card-bg-icon text-primary"></i>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-custom p-4 h-100">
                <p class="text-muted small fw-bold mb-2">PENGELUARAN</p>
                <h2 class="text-dark fw-bold mb-3">Rp. 1.000.000</h2>
                <i class="fa-solid fa-credit-card card-bg-icon text-secondary"></i>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card card-custom p-4 h-100 text-white" style="background-color: #4a85f6;">
                <p class="small fw-bold mb-2 text-white-50">GUEST RATING</p>
                <div class="d-flex align-items-end gap-2 mb-2">
                    <h2 class="fw-bold mb-0">3 / 5</h2>
                    <span class="mb-1 text-white-50">Rate</span>
                </div>
                <div class="text-warning mb-0 fs-5">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <i class="fa-solid fa-shield-check card-bg-icon text-white"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Statistik Keuangan</h5>
                        <p class="text-muted small mb-0">Annual performance overview of revenue and expenses.</p>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-light border btn-sm text-muted">2023</button>
                        <button type="button" class="btn btn-primary btn-sm">2024</button>
                    </div>
                </div>

                <div style="height: 350px;">
                    <canvas id="keuanganChart"></canvas>
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
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov',
                        'Des'
                    ],
                    datasets: [{
                            label: 'Pendapatan',
                            data: [550, 750, 650, 50, 650, 350, 320, 10, 450, 600, 800, 950],
                            backgroundColor: '#0d6efd',
                            borderRadius: 2,
                            barPercentage: 0.8,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Pengeluaran',
                            data: [540, 850, 400, 250, 550, 450, 650, 750, 300, 400, 550, 600],
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
                            max: 1000,
                            ticks: {
                                stepSize: 250
                            },
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
        });
    </script>
@endpush
