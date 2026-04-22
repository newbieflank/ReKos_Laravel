@extends('layouts.pemilik')

@section('title', 'Tambah Properti Kost - RE-KOST')

@section('content')
<style>
    .container-fluid-custom { width: 100%; padding: 0 16px; max-width: 1000px; margin: 0 auto; }
    
    .back-link { font-size: 0.85rem; font-weight: 600; color: #0d6efd; text-decoration: none; display: flex; align-items: center; gap: 8px; margin-bottom: 8px; transition: color 0.2s; }
    .back-link:hover { color: #0b5ed7; }
    
    .form-section-card { background-color: #fff; border-radius: 16px; padding: 32px; margin-bottom: 24px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border: 1px solid #f1f3f5; }
    .section-title-wrap { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
    .section-icon-box { width: 40px; height: 40px; background-color: #e6f0ff; color: #0d6efd; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    
    .form-label-custom { font-size: 0.75rem; font-weight: 700; color: #495057; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    
    /* Input dan Textarea bergaya abu-abu */
    .form-control-custom { background-color: #f1f3f5; border: 1px solid #f1f3f5; border-radius: 8px; padding: 12px 16px; font-size: 0.9rem; color: #495057; transition: all 0.2s; }
    .form-control-custom:focus { background-color: #fff; border-color: #0d6efd; outline: none; box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1); }
    textarea.form-control-custom { resize: none; height: 120px; }

    /* Toggle Tipe Kost (Putra, Putri, Campur) */
    .toggle-radio { display: none; }
    .toggle-label { display: flex; align-items: center; justify-content: center; padding: 12px; background-color: #f1f3f5; border: 1px solid #f1f3f5; border-radius: 8px; cursor: pointer; font-size: 0.9rem; font-weight: 600; color: #6c757d; transition: all 0.2s; width: 100%; margin: 0; }
    .toggle-radio:checked + .toggle-label { background-color: #4a85f6; color: white; border-color: #4a85f6; }

    /* Checkbox Fasilitas Kost */
    .facility-check { display: none; }
    .facility-card { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; background-color: #f8f9fa; border: 1px solid #f1f3f5; border-radius: 12px; cursor: pointer; transition: all 0.2s; position: relative; height: 100%; min-height: 110px; gap: 12px; color: #6c757d; }
    .facility-card i { font-size: 1.5rem; }
    .facility-card span { font-size: 0.8rem; font-weight: 600; text-align: center; }
    .facility-check:checked + .facility-card { border-color: #0d6efd; background-color: #f4f8ff; color: #0d6efd; box-shadow: 0 4px 6px rgba(13, 110, 253, 0.1); }

    /* Kotak Upload Foto */
    .upload-box { border: 2px dashed #ced4da; border-radius: 12px; background-color: #f8f9fa; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; color: #6c757d; }
    .upload-box:hover { border-color: #0d6efd; background-color: #f4f8ff; color: #0d6efd; }
    .upload-main { height: 280px; }
    .upload-small { height: 130px; }

    /* Bottom Action Buttons */
    .btn-cancel { background-color: #e9ecef; color: #495057; border-radius: 8px; padding: 12px 32px; font-weight: 600; border: none; transition: 0.2s; text-decoration: none; }
    .btn-cancel:hover { background-color: #dee2e6; color: #212529; }
    .btn-primary-custom { background-color: #4a85f6; color: white; border-radius: 8px; padding: 12px 32px; font-weight: 600; border: none; transition: 0.2s; }
    .btn-primary-custom:hover { background-color: #3b71d8; }
</style>

<div class="container-fluid-custom pb-5">
    
    <a href="{{ route('pemilik.kost') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen kost
    </a>
    
    <h3 class="fw-bold text-dark mb-1 mt-2">Tambah Properti Kost</h3>
    <p class="text-secondary small mb-4">Lengkapi detail properti Anda untuk mulai mengelola hunian dengan standar eksklusif The Curated Estate.</p>

    <form action="{{ route('pemilik.kost.simpan') }}" method="POST">
        @csrf

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="form-section-card h-100 mb-0">
                    <div class="section-title-wrap">
                        <div class="section-icon-box"><i class="fa-solid fa-building-user"></i></div>
                        <h5 class="fw-bold mb-0">Identitas Kost</h5>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label-custom">NAMA KOST</label>
                        <input type="text" class="form-control form-control-custom w-100" placeholder="Contoh: Stanza Residence Menteng">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label-custom">TIPE KOST</label>
                        <div class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <input type="radio" name="tipe_kost" id="tipePutra" class="toggle-radio">
                                <label for="tipePutra" class="toggle-label">Putra</label>
                            </div>
                            <div class="flex-grow-1">
                                <input type="radio" name="tipe_kost" id="tipePutri" class="toggle-radio">
                                <label for="tipePutri" class="toggle-label">Putri</label>
                            </div>
                            <div class="flex-grow-1">
                                <input type="radio" name="tipe_kost" id="tipeCampur" class="toggle-radio" checked>
                                <label for="tipeCampur" class="toggle-label">Campur</label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="form-label-custom">RANGE HARGA (BULANAN)</label>
                        <div class="d-flex gap-3">
                            <input type="text" class="form-control form-control-custom w-50" placeholder="Harga Terendah">
                            <input type="text" class="form-control form-control-custom w-50" placeholder="Harga Tertinggi">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-section-card h-100 mb-0">
                    <div class="section-title-wrap">
                        <div class="section-icon-box"><i class="fa-solid fa-location-dot"></i></div>
                        <h5 class="fw-bold mb-0">Lokasi Properti</h5>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label-custom">KOTA / PROVINSI</label>
                        <input type="text" class="form-control form-control-custom w-100" placeholder="Jakarta Selatan, DKI Jakarta">
                    </div>
                    
                    <div>
                        <label class="form-label-custom">ALAMAT LENGKAP</label>
                        <textarea class="form-control form-control-custom w-100" style="height: 130px;" placeholder="Jl. Kemang Raya No. 12..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section-card mt-4">
            <div class="section-title-wrap">
                <div class="section-icon-box"><i class="fa-solid fa-file-lines"></i></div>
                <h5 class="fw-bold mb-0">Keterangan & Peraturan</h5>
            </div>
            
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label class="form-label-custom">DESKRIPSI PROPERTI</label>
                    <textarea class="form-control form-control-custom w-100" placeholder="Ceritakan keunggulan kost Anda..."></textarea>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label-custom">PERATURAN KOST</label>
                    <textarea class="form-control form-control-custom w-100" placeholder="Contoh: Dilarang membawa hewan peliharaan, Tamu maksimal jam 10 malam..."></textarea>
                </div>
            </div>
        </div>

        <div class="form-section-card">
            <div class="section-title-wrap">
                <div class="section-icon-box"><i class="fa-solid fa-building"></i></div>
                <h5 class="fw-bold mb-0">Fasilitas Kost</h5>
            </div>
            
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3">
                <div class="col">
                    <input type="checkbox" id="f_wifi" class="facility-check" checked>
                    <label for="f_wifi" class="facility-card"><i class="fa-solid fa-wifi"></i><span>Free WiFi</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_laundry" class="facility-check">
                    <label for="f_laundry" class="facility-card"><i class="fa-solid fa-shirt"></i><span>Laundry</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_parkir" class="facility-check">
                    <label for="f_parkir" class="facility-card"><i class="fa-solid fa-car"></i><span>Parkir Luas</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_keamanan" class="facility-check" checked>
                    <label for="f_keamanan" class="facility-card"><i class="fa-solid fa-shield-halved"></i><span>Keamanan 24j</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_dapur" class="facility-check">
                    <label for="f_dapur" class="facility-card"><i class="fa-solid fa-kitchen-set"></i><span>Dapur Bersama</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_ac" class="facility-check">
                    <label for="f_ac" class="facility-card"><i class="fa-solid fa-snowflake"></i><span>Full AC</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_roomservice" class="facility-check">
                    <label for="f_roomservice" class="facility-card"><i class="fa-solid fa-bell-concierge"></i><span>Room Service</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_gym" class="facility-check">
                    <label for="f_gym" class="facility-card"><i class="fa-solid fa-dumbbell"></i><span>Gym Area</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_kolam" class="facility-check">
                    <label for="f_kolam" class="facility-card"><i class="fa-solid fa-water-ladder"></i><span>Kolam Renang</span></label>
                </div>
                <div class="col">
                    <input type="checkbox" id="f_lainnya" class="facility-check">
                    <label for="f_lainnya" class="facility-card"><i class="fa-solid fa-ellipsis"></i><span>Lainnya</span></label>
                </div>
            </div>
        </div>

        <div class="form-section-card">
            <div class="section-title-wrap mb-4">
                <div class="section-icon-box"><i class="fa-regular fa-images"></i></div>
                <h5 class="fw-bold mb-0">Galeri Foto Kost</h5>
            </div>

            <div class="row g-4 mb-3">
                <div class="col-12 col-md-8">
                    <div class="upload-box upload-main">
                        <div class="bg-white shadow-sm p-3 rounded-circle mb-3 text-primary"><i class="fa-solid fa-cloud-arrow-up fs-4"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Unggah Foto Utama</h6>
                        <p class="small text-muted">Seret gambar atau klik untuk memilih</p>
                    </div>
                </div>
                <div class="col-12 col-md-4 d-flex flex-column gap-4">
                    <div class="upload-box upload-small">
                        <i class="fa-solid fa-camera mb-2 fs-5"></i>
                        <span class="small fw-bold">Tambah Detail</span>
                    </div>
                    <div class="upload-box upload-small">
                        <i class="fa-solid fa-camera mb-2 fs-5"></i>
                        <span class="small fw-bold">Tambah Fasilitas</span>
                    </div>
                </div>
            </div>
            <p class="text-muted small"><i class="fa-regular fa-circle-info me-1"></i> Rekomendasi ukuran foto minimal 1280x720 pixel dalam format JPG atau PNG.</p>
        </div>

        <div class="d-flex justify-content-end align-items-center gap-3 mt-2">
            <a href="{{ route('pemilik.kost') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-primary-custom"><i class="fa-regular fa-floppy-disk me-2"></i> Simpan Properti</button>
        </div>

    </form>
</div>
@endsection