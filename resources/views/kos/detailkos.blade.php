<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kos - Re-Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        html { scroll-behavior: smooth; }
        
        .object-fit-cover { object-fit: cover; }
        
        .scroll-section { scroll-margin-top: 100px; }
        
        .nav-tabs-custom { 
            overflow-x: auto; 
            white-space: nowrap; 
            -webkit-overflow-scrolling: touch; 
            scrollbar-width: none; 
        }
        .nav-tabs-custom::-webkit-scrollbar { display: none; }
        
        .tab-link { 
            color: #6c757d; 
            font-weight: 600; 
            text-decoration: none; 
            padding-bottom: 8px; 
            margin-right: 24px; 
            display: inline-block; 
            transition: all 0.3s ease;
        }
        .tab-link.active { color: #0d6efd; border-bottom: 2px solid #0d6efd; }
        .tab-link:hover { color: #0d6efd; }

        .gallery-main { height: 250px; } 
        .gallery-sub { height: 120px; }  
        
        .title-text { font-size: 1.25rem; }
        .price-text { font-size: 1.25rem; }
        .heading-text { font-size: 1.1rem; }
        .body-text { font-size: 0.85rem; }
        .icon-text { font-size: 0.85rem; }

        @media (min-width: 768px) {
            .gallery-wrapper { height: 400px; }
            .gallery-main { height: 100%; }
            .gallery-sub { height: 50%; }
            
            .title-text { font-size: 1.75rem; }
            .price-text { font-size: 1.5rem; }
            .heading-text { font-size: 1.25rem; }
            .body-text { font-size: 1rem; }
            .icon-text { font-size: 0.95rem; }
        }
    </style>
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container bg-white my-4 p-3 p-md-4 shadow-sm rounded">
        
        <a href="{{ url('/') }}" class="text-decoration-none text-muted mb-3 d-inline-block fw-medium body-text">
            <i class="fa-solid fa-chevron-left me-2 p-2 bg-light rounded-circle"></i> Back
        </a>

        <div class="row g-2 mb-4 mb-md-5 gallery-wrapper">
            <div class="col-12 col-md-6 gallery-main">
                <img src="https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=800&q=80" class="w-100 h-100 object-fit-cover rounded" alt="Tampak Depan">
            </div>
            <div class="col-6 col-md-3 d-flex flex-column gap-2">
                <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=400&q=80" class="w-100 gallery-sub object-fit-cover rounded" alt="Kamar Tidur">
                <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=400&q=80" class="w-100 gallery-sub object-fit-cover rounded" alt="Kamar Mandi">
            </div>
            <div class="col-6 col-md-3 d-flex flex-column gap-2">
                <img src="https://images.unsplash.com/photo-1556911223-e1520288c05b?w=400&q=80" class="w-100 gallery-sub object-fit-cover rounded" alt="Dapur">
                <img src="https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?w=400&q=80" class="w-100 gallery-sub object-fit-cover rounded" alt="Meja Belajar">
            </div>
        </div>

        <div id="info-umum" class="row border-bottom pb-4 mb-4 scroll-section">
            <div class="col-12 col-md-8">
                <div class="d-flex mb-4 border-bottom nav-tabs-custom body-text">
                    <a href="#" class="tab-link active" onclick="changeTab(event, 'info-umum', this)">Info Umum</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'fasilitas', this)">Fasilitas</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'lokasi', this)">Lokasi</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'kebijakan', this)">Kebijakan</a>
                    <a href="#" class="tab-link" onclick="changeTab(event, 'tentang', this)">Tentang</a>
                </div>
                
                <h2 class="fw-bold title-text mb-2">{{ $kos['nama'] }}</h2>
                <div class="d-flex flex-wrap align-items-center mb-2 gap-2 text-warning body-text">
                    <div>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span class="text-muted fw-medium">{{ $kos['rating'] }} (100 Reviews)</span>
                    <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1" style="font-size: 0.75rem;">• Sering penuh</span>
                </div>
                <p class="text-muted mb-0 body-text"><i class="fa-solid fa-location-dot me-2"></i> {{ $kos['lokasi'] }}</p>
            </div>
            
            <div class="col-12 col-md-4 text-md-end d-flex flex-column justify-content-end mt-4 mt-md-0 border-top border-md-0 pt-3 pt-md-0">
                <small class="text-muted body-text">Mulai dari</small>
                <h3 class="fw-bold text-danger mb-0 price-text">IDR {{ $kos['harga'] }}</h3>
                <small class="text-muted mb-3 body-text">/kamar/bulan</small>
                <button class="btn btn-primary fw-bold px-4 py-2 body-text">Ajukan Sewa</button>
            </div>
        </div>

        <div id="fasilitas" class="border-bottom pb-4 mb-4 scroll-section">
            <h5 class="fw-bold mb-4 heading-text">Fasilitas Populer</h5>
            <div class="row gy-3 mb-4">
                @foreach($kos['fasilitas_populer'] as $f)
                <div class="col-6 col-md-3 text-muted">
                    <i class="{{ $f['icon'] }} me-2 text-secondary" style="width: 20px;"></i> 
                    <span class="fw-medium icon-text">{{ $f['nama'] }}</span>
                </div>
                @endforeach
            </div>
            
            <h5 class="fw-bold mb-3 heading-text">Fasilitas Lainnya</h5>
            <div class="d-flex flex-wrap gap-3 gap-md-4 text-muted mb-3 fw-medium icon-text">
                @foreach($kos['fasilitas_lain'] as $lain)
                    <span>{{ $lain }}</span>
                @endforeach
            </div>
            <button class="btn btn-light text-primary btn-sm fw-medium icon-text">Lihat lebih sedikit <i class="fa-solid fa-chevron-up ms-1"></i></button>
        </div>

        <div id="lokasi" class="border-bottom pb-4 mb-4 scroll-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 heading-text">Lokasi</h5>
                <button class="btn btn-light text-primary btn-sm fw-bold icon-text">Lihat peta</button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="bg-secondary rounded w-100" style="height: 250px; overflow: hidden;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15797.10646193754!2d113.7051936!3d-8.1751105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd69435bb1cc8ef%3A0x6339178cb71f7a!2sPoliteknik%20Negeri%20Jember!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="text-muted body-text lh-lg">{{ $kos['alamat_lengkap'] }}</p>
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
                        @foreach($kos['kebijakan'] as $kebijakan)
                        <div>
                            <h6 class="fw-bold mb-1 body-text" style="font-size: 1em;">{{ $kebijakan['judul'] }}</h6>
                            <p class="text-muted mb-0 body-text">{{ $kebijakan['deskripsi'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div id="tentang" class="border-bottom pb-4 mb-4 scroll-section">
            <h5 class="fw-bold mb-3 heading-text">Tentang {{ $kos['nama'] }}</h5>
            <div class="text-muted body-text lh-lg">
                <p>Kos Putri Muslimah berlokasi di Blindungan, Bondowoso yang dapat kalian temukan di aplikasi maupun website Re-Kost.</p>
                <p>Kamar ber-AC yang dilengkapi dengan meja belajar, TV, lemari dan kasur yang nyaman. Kamar mandi dalam yang bersih dan dilengkapi dengan berbagai fasilitas lain yang dapat kalian dapatkan di Kos Putri Muslim Blindungan.</p>
            </div>
        </div>

        <div class="mt-4 mb-2 text-center">
            <button class="btn btn-primary w-100 fw-bold py-3 shadow-sm heading-text">
                Tanya Pemilik Sebelum Sewa
            </button>
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
            if(targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>
</body>
</html>