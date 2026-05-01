@extends('layouts.pemilik')

@section('title', 'Tambah Properti Kost - RE-KOST')

@section('content')
    <style>
        .container-fluid-custom {
            width: 100%;
            padding: 0 16px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .back-link {
            font-size: 0.85rem;
            font-weight: 600;
            color: #0d6efd;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #0b5ed7;
        }

        .form-section-card {
            background-color: #fff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            border: 1px solid #f1f3f5;
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .section-icon-box {
            width: 40px;
            height: 40px;
            background-color: #e6f0ff;
            color: #0d6efd;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .form-label-custom {
            font-size: 0.75rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Input dan Textarea bergaya abu-abu */
        .form-control-custom {
            background-color: #f1f3f5;
            border: 1px solid #f1f3f5;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #495057;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            background-color: #fff;
            border-color: #0d6efd;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        }

        textarea.form-control-custom {
            resize: none;
            height: 120px;
        }

        /* Toggle Tipe Kost (Putra, Putri, Campur) */
        .toggle-radio {
            display: none;
        }

        .toggle-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            background-color: #f1f3f5;
            border: 1px solid #f1f3f5;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.2s;
            width: 100%;
            margin: 0;
        }

        .toggle-radio:checked+.toggle-label {
            background-color: #4a85f6;
            color: white;
            border-color: #4a85f6;
        }

        /* Checkbox Fasilitas Kost */
        .facility-check {
            display: none;
        }

        .facility-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #f1f3f5;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            height: 100%;
            min-height: 110px;
            gap: 12px;
            color: #6c757d;
        }

        .facility-card i {
            font-size: 1.5rem;
        }

        .facility-card span {
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
        }

        .facility-check:checked+.facility-card {
            border-color: #0d6efd;
            background-color: #f4f8ff;
            color: #0d6efd;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.1);
        }

        /* Kotak Upload Foto */
        .upload-box {
            border: 2px dashed #ced4da;
            border-radius: 12px;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #6c757d;
        }

        .upload-box:hover {
            border-color: #0d6efd;
            background-color: #f4f8ff;
            color: #0d6efd;
        }

        .upload-main {
            height: 280px;
        }

        .upload-small {
            height: 130px;
        }

        /* Bottom Action Buttons */
        .btn-cancel {
            background-color: #e9ecef;
            color: #495057;
            border-radius: 8px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
            transition: 0.2s;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #dee2e6;
            color: #212529;
        }

        .btn-primary-custom {
            background-color: #4a85f6;
            color: white;
            border-radius: 8px;
            padding: 12px 32px;
            font-weight: 600;
            border: none;
            transition: 0.2s;
        }

        .btn-primary-custom:hover {
            background-color: #3b71d8;
        }
    </style>

    <div class="container-fluid-custom pb-5">

        <a href="{{ route('pemilik.kost') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Manajemen kost
        </a>

        <h3 class="fw-bold text-dark mb-1 mt-2">Tambah Properti Kost</h3>
        <p class="text-secondary small mb-4">Lengkapi detail properti Anda untuk mulai mengelola hunian dengan standar
            eksklusif The Curated Estate.</p>

        <form action="{{ route('pemilik.kost.simpan') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm(this)">
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
                            <input type="text" name="boarding_house_name" class="form-control form-control-custom w-100"
                                placeholder="Contoh: Stanza Residence Menteng" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">TIPE KOST</label>
                            <div class="d-flex gap-2">
                                <div class="flex-grow-1">
                                    <input type="radio" name="boarding_house_type" value="male" id="tipePutra"
                                        class="toggle-radio">
                                    <label for="tipePutra" class="toggle-label">Putra</label>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="radio" name="boarding_house_type" value="female" id="tipePutri"
                                        class="toggle-radio">
                                    <label for="tipePutri" class="toggle-label">Putri</label>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="radio" name="boarding_house_type" value="mixed" id="tipeCampur"
                                        class="toggle-radio" checked>
                                    <label for="tipeCampur" class="toggle-label">Campur</label>
                                </div>
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

                        <div class="mb-3">
                            <label class="form-label-custom">PIN LOKASI DI PETA</label>
                            <p class="text-muted small mb-2">Klik pada peta untuk menentukan lokasi kost Anda di Bondowoso.
                            </p>
                            <div id="map" style="height: 220px; border-radius: 10px; border: 1px solid #dee2e6;">
                            </div>
                        </div>

                        <input type="hidden" name="latitude" id="input_lat" value="-7.9107">
                        <input type="hidden" name="longitude" id="input_lng" value="113.8204">

                        <div class="mb-3">
                            <label class="form-label-custom">ALAMAT DARI PETA</label>
                            <textarea id="input_alamat_maps" class="form-control form-control-custom w-100" style="height: 70px;"
                                placeholder="Klik peta untuk mengisi alamat otomatis..." readonly></textarea>
                        </div>

                        <div>
                            <label class="form-label-custom">DETAIL LOKASI <span class="text-muted fw-normal"
                                    style="text-transform:none;letter-spacing:0;">(RT/RW, Blok, No. Rumah,
                                    dll)</span></label>
                            <input type="text" id="input_detail" class="form-control form-control-custom w-100"
                                placeholder="Contoh: RT 03/RW 02, Blok B No. 12">
                            <p class="text-muted small mt-1 mb-0"><i class="fa-solid fa-circle-info me-1"></i>Detail ini
                                akan digabung dengan alamat peta secara otomatis.</p>
                        </div>

                        {{-- Field yang dikirim ke server: gabungan keduanya --}}
                        <input type="hidden" name="alamat" id="input_alamat">
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
                        <textarea name="description" class="form-control form-control-custom w-100"
                            placeholder="Ceritakan keunggulan kost Anda..." required></textarea>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">PERATURAN KOST</label>
                        <textarea name="house_rule" class="form-control form-control-custom w-100"
                            placeholder="Contoh: Dilarang membawa hewan peliharaan, Tamu maksimal jam 10 malam..." required></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section-card">
                <div class="section-title-wrap">
                    <div class="section-icon-box"><i class="fa-solid fa-building"></i></div>
                    <h5 class="fw-bold mb-0">Fasilitas Kost</h5>
                </div>

                <p class="text-muted small mb-3"><i class="fa-solid fa-circle-info text-primary me-1"></i> Centang
                    fasilitas yang tersedia di kost Anda.</p>

                {{-- Fasilitas Umum Dasar --}}
                <h6 class="fw-semibold text-dark mb-3 mt-2"><i
                        class="fa-solid fa-house-chimney-window text-primary me-2"></i>Fasilitas Umum Dasar</h6>
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3 mb-4">
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Area Parkir" id="f_parkir"
                            class="facility-check">
                        <label for="f_parkir" class="facility-card"><i class="fa-solid fa-car"></i><span>Area
                                Parkir</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Dapur Bersama" id="f_dapur"
                            class="facility-check">
                        <label for="f_dapur" class="facility-card"><i class="fa-solid fa-kitchen-set"></i><span>Dapur
                                Bersama</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Kamar Mandi Luar" id="f_km_luar"
                            class="facility-check">
                        <label for="f_km_luar" class="facility-card"><i class="fa-solid fa-shower"></i><span>Kamar Mandi
                                Luar</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Area Jemur" id="f_jemur"
                            class="facility-check">
                        <label for="f_jemur" class="facility-card"><i class="fa-solid fa-wind"></i><span>Area Jemur
                                Pakaian</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Wi-Fi" id="f_wifi"
                            class="facility-check">
                        <label for="f_wifi" class="facility-card"><i class="fa-solid fa-wifi"></i><span>Wi-Fi /
                                Internet</span></label>
                    </div>
                </div>

                {{-- Fasilitas Keamanan --}}
                <h6 class="fw-semibold text-dark mb-3"><i class="fa-solid fa-shield-halved text-danger me-2"></i>Fasilitas
                    Keamanan</h6>
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3 mb-4">
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="CCTV" id="f_cctv"
                            class="facility-check">
                        <label for="f_cctv" class="facility-card"><i
                                class="fa-solid fa-camera"></i><span>CCTV</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Penjaga Kost" id="f_satpam"
                            class="facility-check">
                        <label for="f_satpam" class="facility-card"><i
                                class="fa-solid fa-user-shield"></i><span>Satpam</span></label>
                    </div>
                </div>

                {{-- Fasilitas Kenyamanan & Ekstra --}}
                <h6 class="fw-semibold text-dark mb-3"><i class="fa-solid fa-star text-warning me-2"></i>Fasilitas
                    Kenyamanan & Ekstra</h6>
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3">
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Ruang Tamu" id="f_ruangtamu"
                            class="facility-check">
                        <label for="f_ruangtamu" class="facility-card"><i class="fa-solid fa-couch"></i><span>Ruang
                                Tamu</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Peralatan Elektronik" id="f_elektronik"
                            class="facility-check">
                        <label for="f_elektronik" class="facility-card"><i class="fa-solid fa-plug"></i><span>Peralatan
                                Elektronik</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Mesin Cuci" id="f_mesin_cuci"
                            class="facility-check">
                        <label for="f_mesin_cuci" class="facility-card"><i
                                class="fa-solid fa-jug-detergent"></i><span>Mesin Cuci</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Kulkas" id="f_kulkas"
                            class="facility-check">
                        <label for="f_kulkas" class="facility-card"><i
                                class="fa-solid fa-temperature-low"></i><span>Kulkas</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Ruang Belajar" id="f_belajar"
                            class="facility-check">
                        <label for="f_belajar" class="facility-card"><i class="fa-solid fa-book-open"></i><span>Rak
                                Buku</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Mushola" id="f_mushola"
                            class="facility-check">
                        <label for="f_mushola" class="facility-card"><i
                                class="fa-solid fa-place-of-worship"></i><span>Mushola</span></label>
                    </div>
                </div>
            </div>
            <div class="form-section-card">
                <div class="section-title-wrap">
                    <div class="section-icon-box"><i class="fa-regular fa-image"></i></div>
                    <h5 class="fw-bold mb-0">Galeri Foto Kost</h5>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label class="upload-box upload-small w-100" style="min-height: 200px; cursor: pointer;">
                            <input type="file" name="main_image" class="d-none" accept="image/*"
                                onchange="previewImage(this, 'preview-1')">
                            <div id="preview-1"
                                class="d-flex flex-column align-items-center justify-content-center w-100 h-100 p-3 text-center">
                                <div class="bg-white shadow-sm p-3 rounded-circle mb-3 text-primary"><i
                                        class="fa-solid fa-cloud-arrow-up fs-4"></i></div>
                                <h6 class="fw-bold text-dark mb-1">Foto Utama Kost</h6>
                                <p class="small text-muted mb-0">Wajib diisi</p>
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="upload-box upload-small w-100" style="min-height: 200px; cursor: pointer;">
                            <input type="file" name="other_image_1" class="d-none" accept="image/*"
                                onchange="previewImage(this, 'preview-2')">
                            <div id="preview-2"
                                class="d-flex flex-column align-items-center justify-content-center w-100 h-100 p-3 text-center">
                                <i class="fa-solid fa-building mb-2 fs-3 text-secondary"></i>
                                <h6 class="fw-bold text-dark mb-1">Foto Tampak Depan</h6>
                                <p class="small text-muted mb-0">Opsional</p>
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="upload-box upload-small w-100" style="min-height: 200px; cursor: pointer;">
                            <input type="file" name="other_image_2" class="d-none" accept="image/*"
                                onchange="previewImage(this, 'preview-3')">
                            <div id="preview-3"
                                class="d-flex flex-column align-items-center justify-content-center w-100 h-100 p-3 text-center">
                                <i class="fa-solid fa-couch mb-2 fs-3 text-secondary"></i>
                                <h6 class="fw-bold text-dark mb-1">Foto Fasilitas Bersama</h6>
                                <p class="small text-muted mb-0">Opsional</p>
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="upload-box upload-small w-100" style="min-height: 200px; cursor: pointer;">
                            <input type="file" name="other_image_3[]" id="file_other_3" multiple class="d-none"
                                accept="image/*" onchange="appendImages(this, 'preview-4')">
                            <div id="preview-4"
                                class="d-flex flex-column align-items-center justify-content-center w-100 h-100 p-3 text-center">
                                <i class="fa-solid fa-image mb-2 fs-3 text-secondary"></i>
                                <h6 class="fw-bold text-dark mb-1">Foto Lainnya</h6>
                                <p class="small text-muted mb-0">Opsional</p>
                            </div>
                        </label>
                    </div>
                </div>
                <p class="text-muted small mt-3"><i class="fa-solid fa-circle-info me-1"></i> Rekomendasi ukuran foto
                    minimal 1280x720 pixel dalam format JPG atau PNG.</p>
            </div>

            <div class="d-flex justify-content-end align-items-center gap-3 mt-2">
                <a href="{{ route('pemilik.kost') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-primary-custom"><i class="fa-regular fa-floppy-disk me-2"></i> Simpan
                    Properti</button>
            </div>

        </form>
    </div>

    @push('scripts')
        <script>
            function previewImage(input, previewId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var container = document.getElementById(previewId);
                        container.innerHTML = '<img src="' + e.target.result +
                            '" class="w-100 h-100 object-fit-cover rounded" alt="Preview">';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            var dtOther3 = new DataTransfer();

            function appendImages(input, previewId) {
                if (input.files && input.files.length > 0) {
                    for (let i = 0; i < input.files.length; i++) {
                        dtOther3.items.add(input.files[i]);
                    }
                    input.files = dtOther3.files;
                    renderMiniPreviews(previewId);
                }
            }

            function renderMiniPreviews(previewId) {
                var container = document.getElementById(previewId);
                container.innerHTML = '';
                container.classList.remove('flex-column', 'align-items-center', 'justify-content-center');
                container.classList.add('flex-row', 'flex-wrap', 'gap-2', 'p-2', 'align-items-start', 'overflow-y-auto');

                if (dtOther3.files.length === 0) {
                    container.classList.add('flex-column', 'align-items-center', 'justify-content-center');
                    container.classList.remove('flex-row', 'flex-wrap', 'gap-2', 'p-2', 'align-items-start', 'overflow-y-auto');
                    container.innerHTML =
                        '<i class="fa-solid fa-image mb-2 fs-3 text-secondary"></i><h6 class="fw-bold text-dark mb-1">Foto Lainnya</h6><p class="small text-muted mb-0">Klik untuk tambah</p>';
                    return;
                }

                for (let i = 0; i < dtOther3.files.length; i++) {
                    let file = dtOther3.files[i];
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let div = document.createElement('div');
                        div.style.width = '70px';
                        div.style.height = '70px';
                        div.className = 'position-relative';
                        div.innerHTML = '<img src="' + e.target.result +
                            '" class="w-100 h-100 object-fit-cover rounded border">' +
                            '<button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle p-0 d-flex align-items-center justify-content-center" style="width:18px;height:18px;transform:translate(30%, -30%);" onclick="event.preventDefault(); event.stopPropagation(); removeImg(' +
                            i + ', \'' + previewId +
                            '\')"><i class="fa-solid fa-times" style="font-size:9px;"></i></button>';
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }

                let addBtn = document.createElement('div');
                addBtn.style.width = '70px';
                addBtn.style.height = '70px';
                addBtn.className =
                    'd-flex flex-column align-items-center justify-content-center rounded border border-dashed text-primary bg-light';
                addBtn.innerHTML = '<i class="fa-solid fa-plus mb-1"></i><span style="font-size:0.6rem;">Tambah</span>';
                container.appendChild(addBtn);
            }

            function removeImg(index, previewId) {
                var dtNew = new DataTransfer();
                for (let i = 0; i < dtOther3.files.length; i++) {
                    if (i !== index) dtNew.items.add(dtOther3.files[i]);
                }
                dtOther3 = dtNew;
                document.getElementById('file_other_3').files = dtOther3.files;
                renderMiniPreviews(previewId);
            }

            function updateCount(input, textId) {
                var count = input.files ? input.files.length : 0;
                document.getElementById(textId).innerText = count + ' file dipilih';
            }

            // Inisialisasi peta Leaflet (OpenStreetMap, gratis tanpa API key)
            const defaultLat = -7.9107;
            const defaultLng = 113.8204;

            const map = L.map('map').setView([defaultLat, defaultLng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            function updateAddress(lat, lng) {
                document.getElementById('input_lat').value = lat.toFixed(6);
                document.getElementById('input_lng').value = lng.toFixed(6);

                // Reverse geocoding via Nominatim (gratis)
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('input_alamat_maps').value = data.display_name;
                            combineAddress();
                        }
                    })
                    .catch(() => {
                        document.getElementById('input_alamat_maps').value =
                            `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
                        combineAddress();
                    });
            }

            function combineAddress() {
                const fromMap = document.getElementById('input_alamat_maps').value.trim();
                const detail = document.getElementById('input_detail').value.trim();
                // Gabungkan: detail dulu, lalu alamat dari peta
                document.getElementById('input_alamat').value = detail ? `${detail}, ${fromMap}` : fromMap;
            }

            // Saat user mengetik detail lokasi
            document.getElementById('input_detail').addEventListener('input', combineAddress);

            // Saat marker digeser
            marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                updateAddress(pos.lat, pos.lng);
            });

            // Saat klik peta
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateAddress(e.latlng.lat, e.latlng.lng);
            });

            // Load alamat awal
            updateAddress(defaultLat, defaultLng);

            function validateForm(form) {
                const inputs = form.querySelectorAll('input[required]:not(.d-none), textarea[required]:not(.d-none), select[required]:not(.d-none)');
                for(let input of inputs) {
                    if(!input.checkValidity()) {
                        input.reportValidity();
                        return false;
                    }
                }
                
                const mainImage = form.querySelector('input[name="main_image"]');
                if(mainImage && mainImage.files.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Foto Utama Belum Diunggah',
                        text: 'Silakan unggah foto utama kost terlebih dahulu.',
                        confirmButtonColor: '#0d6efd'
                    });
                    return false;
                }

                return true;
            }
        </script>
    @endpush
@endsection
