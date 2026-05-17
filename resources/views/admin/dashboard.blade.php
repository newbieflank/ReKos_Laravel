@extends('layouts.admin')

@push('styles')
    <style>
        .icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .bg-indigo-light {
            background-color: #eef2ff;
            color: #818cf8;
        }

        .bg-yellow-light {
            background-color: #fefce8;
            color: #facc15;
        }

        .bg-emerald-light {
            background-color: #ecfdf5;
            color: #34d399;
        }

        .bg-orange-light {
            background-color: #fff7ed;
            color: #fb923c;
        }

        .card-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.03);
        }
    </style>
@endpush

@section('content')
    <h3 class="fw-bold text-dark mb-4">Dashboard</h3>

    <div class="row g-4 mb-4">

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary small mb-1">Pemilik Kos</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $stats['pemilik_kos'] }}</h3>
                        <p class="text-muted" style="font-size: 0.75rem; margin-top: 4px; margin-bottom: 0;">Total Pemilik Kos
                        </p>
                    </div>
                    <div class="icon-circle bg-indigo-light">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary small mb-1">Pencari Kos</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $stats['pencari_kos'] }}</h3>
                        <p class="text-muted" style="font-size: 0.75rem; margin-top: 4px; margin-bottom: 0;">Total Pencari
                            Kos</p>
                    </div>
                    <div class="icon-circle bg-yellow-light">
                        <i class="fa-solid fa-box"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary small mb-1">Kos</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $stats['kos'] }}</h3>
                        <p class="text-muted" style="font-size: 0.75rem; margin-top: 4px; margin-bottom: 0;">Total Kos</p>
                    </div>
                    <div class="icon-circle bg-emerald-light">
                        <i class="fa-solid fa-house"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card card-custom h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary small mb-1">Rating</p>
                        <h3 class="fw-bold text-dark mb-0">{{ $stats['rating'] }}</h3>
                        <p class="text-muted" style="font-size: 0.75rem; margin-top: 4px; margin-bottom: 0;">Total Rating
                            Kos</p>
                    </div>
                    <div class="icon-circle bg-orange-light">
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card card-custom p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark m-0">New Users</h5>
            <form id="yearFilterForm" method="GET" action="{{ route('admin.dashboard') }}">
                <select name="year" class="form-select form-select-sm w-auto text-secondary shadow-none border-light-subtle" onchange="document.getElementById('yearFilterForm').submit();">
                    @foreach ($availableYears as $year)
                        <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div id="salesChart" class="w-100" style="height: 350px;"></div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                series: [{
                    name: 'New Users',
                    data: @json($chartData)
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#0d6efd'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json($chartCategories),
                    labels: {
                        style: {
                            colors: '#6c757d',
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return Math.floor(val);
                        },
                        style: {
                            colors: '#6c757d',
                            fontSize: '12px'
                        }
                    }
                },
                grid: {
                    borderColor: '#f8f9fa',
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                }
            };

            var chart = new ApexCharts(document.querySelector("#salesChart"), options);
            chart.render();
        });
    </script>
@endpush
