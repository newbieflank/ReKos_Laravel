@extends('layouts.app')

@section('content')
    <div class="container mt-5">
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
                        <h3 class="fw-bold text-primary mb-0">100+</h3>
                        <span class="text-muted small">Pengguna</span>
                    </div>
                    <div>
                        <h3 class="fw-bold text-primary mb-0">100+</h3>
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
                <div class="bg-white p-3 p-md-4 rounded-4 shadow-sm d-flex flex-column flex-md-row align-items-end justify-content-between gap-3"
                    style="box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;">

                    <div class="flex-grow-1 w-100">
                        <label class="form-label text-dark small fw-bold ms-2 mb-2">Lokasi</label>
                        <div class="bg-light rounded-pill px-3 py-2 d-flex align-items-center">
                            <select class="form-select border-0 bg-transparent shadow-none p-0 text-muted fw-medium"
                                style="cursor: pointer; appearance: none; background-image: none;">
                                <option>Pilih Lokasi</option>
                                <option>Bondowoso Kota</option>
                            </select>
                            <i class="fas fa-chevron-down text-muted small ms-auto"></i>
                        </div>
                    </div>

                    <div class="flex-grow-1 w-100">
                        <label class="form-label text-dark small fw-bold ms-2 mb-2">Area</label>
                        <div class="bg-light rounded-pill px-3 py-2 d-flex align-items-center">
                            <select class="form-select border-0 bg-transparent shadow-none p-0 text-muted fw-medium"
                                style="cursor: pointer; appearance: none; background-image: none;">
                                <option>Pilih Area</option>
                                <option>Tenggarang</option>
                            </select>
                            <i class="fas fa-chevron-down text-muted small ms-auto"></i>
                        </div>
                    </div>

                    <div class="flex-grow-1 w-100">
                        <label class="form-label text-dark small fw-bold ms-2 mb-2">Tipe</label>
                        <div class="bg-light rounded-pill px-3 py-2 d-flex align-items-center">
                            <select class="form-select border-0 bg-transparent shadow-none p-0 text-muted fw-medium"
                                style="cursor: pointer; appearance: none; background-image: none;">
                                <option>Pilih Tipe</option>
                                <option>Campur</option>
                                <option>Putra</option>
                            </select>
                            <i class="fas fa-chevron-down text-muted small ms-auto"></i>
                        </div>
                    </div>

                    <div class="w-100" style="max-width: 180px;">
                        <button class="btn btn-primary rounded-pill w-100 py-2 fw-bold text-white shadow-sm"
                            style="height: 44px;">Cari</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <section class="section-biru" style="padding-top: 100px; padding-bottom: 60px;">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-uppercase fw-bold text-light mb-1" style="letter-spacing: 1px;">REKOMENDASI</h6>
                <h2 class="fw-bold">Kost Terbaik di Bondowoso</h2>
            </div>

            <div class="row g-4">
                @foreach($kosts as $kost)
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('detail', $kost->id) }}" class="text-decoration-none">
                        <div class="card card-kost h-100 p-2 border-0 shadow-sm">
                            <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                class="card-img-top rounded-3" alt="Kost">
                            <div class="card-body px-2 pb-1 pt-3">
                                <h6 class="fw-bold text-dark mb-1">{{ $kost->boarding_house_name }}</h6>
                                <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    {{ Str::limit($kost->alamat, 25) }}</p>
                                
                                @php $sisa = $kost->rooms->where('available', true)->count(); @endphp
                                @if($sisa > 0)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 mb-2" style="font-size: 0.7rem;"><i class="fa-solid fa-door-open me-1"></i> Sisa {{ $sisa }} Kamar</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 mb-2" style="font-size: 0.7rem;"><i class="fa-solid fa-door-closed me-1"></i> Penuh</span>
                                @endif

                                <div class="mt-2 border-top pt-2">
                                    <span class="fw-bold text-primary fs-5">Rp {{ number_format($kost->rooms->min('monthly_price') ?? 0, 0, ',', '.') }}<span
                                            class="text-muted small fw-normal fs-6"> / Bulan</span></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <button class="btn btn-light text-primary fw-bold rounded-pill px-5 py-2 shadow-sm bg-white">Lihat <i
                        class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-2">Pilihan Kost Terbaik di Sekitarmu</h3>
                <p class="text-muted">Menyesuaikan dengan lokasi Anda saat ini, ini adalah pilihan tepat untuk Anda.</p>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-4">
                <button class="btn btn-primary rounded-pill px-4">Semua</button>
                <button
                    class="btn btn-outline-secondary rounded-pill px-4 text-dark border-light bg-light">Tenggarang</button>
                <button
                    class="btn btn-outline-secondary rounded-pill px-4 text-dark border-light bg-light">Wonosari</button>
                <button
                    class="btn btn-outline-secondary rounded-pill px-4 text-dark border-light bg-light">Tamanan</button>
            </div>

            <div class="row g-4">
                @foreach($kosts as $kost)
                <div class="col-lg-3 col-md-6">
                    <a href="{{ route('detail', $kost->id) }}" class="text-decoration-none">
                        <div class="card card-kost h-100 p-2 border shadow-sm">
                            <img src="https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                class="card-img-top rounded-3" alt="Kost">
                            <div class="card-body px-2 pb-1 pt-3">
                                <h6 class="fw-bold text-dark mb-1">{{ $kost->boarding_house_name }}</h6>
                                <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    {{ Str::limit($kost->alamat, 25) }}</p>
                                
                                @php $sisa = $kost->rooms->where('available', true)->count(); @endphp
                                @if($sisa > 0)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 mb-2" style="font-size: 0.7rem;"><i class="fa-solid fa-door-open me-1"></i> Sisa {{ $sisa }} Kamar</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1 mb-2" style="font-size: 0.7rem;"><i class="fa-solid fa-door-closed me-1"></i> Penuh</span>
                                @endif

                                <div class="mt-2 border-top pt-2">
                                    <span class="fw-bold text-primary fs-5">Rp {{ number_format($kost->rooms->min('monthly_price') ?? 0, 0, ',', '.') }}<span
                                            class="text-muted small fw-normal fs-6"> / Bulan</span></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
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

    <section id="service" class="py-5 mb-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="fw-bold text-primary mb-1">Service</h6>
                <h2 class="fw-bold">Ulasan Pengguna Re-Kost</h2>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <button class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px;"><i
                            class="fas fa-arrow-left"></i></button>
                    <button class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px;"><i
                            class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <div class="p-4 rounded-4 bg-light border-0 h-100">
                        <div class="text-warning mb-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-muted small fst-italic">"Sangat membantu saya menemukan kost yang dekat dengan
                            kampus. Aplikasinya mudah digunakan dan informasinya akurat!"</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="rounded-circle me-2"
                                width="40" height="40" alt="User">
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 14px;">Intan Pertiwi</h6>
                                <span class="text-muted" style="font-size: 12px;">Mahasiswa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="p-4 rounded-4 bg-light border-0 h-100">
                        <div class="text-warning mb-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-muted small fst-italic">"Harga transparan, tidak ada tipu-tipu. Saya langsung
                            booking dan besoknya bisa langsung masuk. Mantap Re-Kost!"</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-2"
                                width="40" height="40" alt="User">
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 14px;">Budi Santoso</h6>
                                <span class="text-muted" style="font-size: 12px;">Karyawan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="p-4 rounded-4 bg-light border-0 h-100">
                        <div class="text-warning mb-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="text-muted small fst-italic">"Pilihan kostnya sangat banyak. Saya bisa filter sesuai
                            budget bulanan saya dengan sangat mudah."</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-2"
                                width="40" height="40" alt="User">
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 14px;">Siti Aminah</h6>
                                <span class="text-muted" style="font-size: 12px;">Mahasiswa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="p-4 rounded-4 bg-light border-0 h-100">
                        <div class="text-warning mb-2">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="text-muted small fst-italic">"Sangat direkomendasikan buat anak rantau yang bingung cari
                            kostan di area Bondowoso!"</p>
                        <div class="d-flex align-items-center mt-3">
                            <img src="https://randomuser.me/api/portraits/men/46.jpg" class="rounded-circle me-2"
                                width="40" height="40" alt="User">
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 14px;">Rizky Pratama</h6>
                                <span class="text-muted" style="font-size: 12px;">Freelancer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
