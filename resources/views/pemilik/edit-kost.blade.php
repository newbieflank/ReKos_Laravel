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

        <h3 class="fw-bold text-dark mb-1 mt-2">Edit Properti Kost</h3>
        <p class="text-secondary small mb-4">Perbarui detail properti Anda.</p>

        <form action="{{ route('pemilik.kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="form-section-card h-100 mb-0">
                        <div class="section-title-wrap">
                            <div class="section-icon-box"><i class="fa-solid fa-building-user"></i></div>
                            <h5 class="fw-bold mb-0">Identitas Kost</h5>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">NAMA KOST</label>
                            <input type="text" name="boarding_house_name" value="{{ $kost->boarding_house_name }}"
                                class="form-control form-control-custom w-100" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">TIPE KOST</label>
                            <div class="d-flex gap-2">
                                <div class="flex-grow-1">
                                    <input type="radio" name="boarding_house_type" value="male" id="tipePutra"
                                        class="toggle-radio" {{ $kost->boarding_house_type === 'male' ? 'checked' : '' }}>
                                    <label for="tipePutra" class="toggle-label">Putra</label>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="radio" name="boarding_house_type" value="female" id="tipePutri"
                                        class="toggle-radio" {{ $kost->boarding_house_type === 'female' ? 'checked' : '' }}>
                                    <label for="tipePutri" class="toggle-label">Putri</label>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="radio" name="boarding_house_type" value="mixed" id="tipeCampur"
                                        class="toggle-radio" {{ $kost->boarding_house_type === 'mixed' ? 'checked' : '' }}>
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

                        <input type="hidden" name="latitude" id="input_lat" value="{{ $kost->latitude }}">
                        <input type="hidden" name="longitude" id="input_lng" value="{{ $kost->longitude }}">

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
                                value="{{ $kost->alamat }}">
                            <p class="text-muted small mt-1 mb-0"><i class="fa-solid fa-circle-info me-1"></i>Detail ini
                                akan digabung dengan alamat peta secara otomatis.</p>
                        </div>

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
                        <textarea name="description" class="form-control form-control-custom w-100" required>{{ $kost->description }}</textarea>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label-custom">PERATURAN KOST</label>
                        <textarea name="house_rule" class="form-control form-control-custom w-100" required>{{ $kost->house_rule }}</textarea>
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
                        <input type="checkbox" name="facilities[]" value="Free WiFi" id="f_wifi"
                            class="facility-check" {{ in_array('Free WiFi', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_wifi" class="facility-card"><i class="fa-solid fa-wifi"></i><span>Free
                                WiFi</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Laundry" id="f_laundry"
                            class="facility-check" {{ in_array('Laundry', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_laundry" class="facility-card"><i
                                class="fa-solid fa-shirt"></i><span>Laundry</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Parkir Luas" id="f_parkir"
                            class="facility-check"
                            {{ in_array('Parkir Luas', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_parkir" class="facility-card"><i class="fa-solid fa-car"></i><span>Parkir
                                Luas</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Keamanan 24j" id="f_keamanan"
                            class="facility-check"
                            {{ in_array('Keamanan 24j', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_keamanan" class="facility-card"><i
                                class="fa-solid fa-shield-halved"></i><span>Keamanan 24j</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Dapur Bersama" id="f_dapur"
                            class="facility-check"
                            {{ in_array('Dapur Bersama', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_dapur" class="facility-card"><i class="fa-solid fa-kitchen-set"></i><span>Dapur
                                Bersama</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Full AC" id="f_ac"
                            class="facility-check" {{ in_array('Full AC', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_ac" class="facility-card"><i class="fa-solid fa-snowflake"></i><span>Full
                                AC</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Room Service" id="f_roomservice"
                            class="facility-check"
                            {{ in_array('Room Service', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_roomservice" class="facility-card"><i
                                class="fa-solid fa-bell-concierge"></i><span>Room Service</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Gym Area" id="f_gym"
                            class="facility-check" {{ in_array('Gym Area', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_gym" class="facility-card"><i class="fa-solid fa-dumbbell"></i><span>Gym
                                Area</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Kolam Renang" id="f_kolam"
                            class="facility-check"
                            {{ in_array('Kolam Renang', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_kolam" class="facility-card"><i class="fa-solid fa-water-ladder"></i><span>Kolam
                                Renang</span></label>
                    </div>
                    <div class="col">
                        <input type="checkbox" name="facilities[]" value="Lainnya" id="f_lainnya"
                            class="facility-check" {{ in_array('Lainnya', $kost->facilities ?? []) ? 'checked' : '' }}>
                        <label for="f_lainnya" class="facility-card"><i
                                class="fa-solid fa-ellipsis"></i><span>Lainnya</span></label>
                    </div>
                </div>
            </div>
            
            <div class="form-section-card mt-4">
                <div class="section-title-wrap">
                    <div class="section-icon-box"><i class="fa-regular fa-image"></i></div>
                    <h5 class="fw-bold mb-0">Galeri Foto Kost</h5>
                </div>
                
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label class="upload-box upload-small w-100" style="min-height: 200px; cursor: pointer;">
                            <input type="file" name="main_image" class="d-none" accept="image/*" onchange="previewImage(this, 'preview-1')">
                            <div id="preview-1" class="d-flex flex-column align-items-center justify-content-center w-100 h-100 p-3 text-center">
                                @if($kost->main_image)
                                    <img src="{{ asset($kost->main_image) }}" class="w-100 h-100 object-fit-cover rounded" alt="Main Image">
                                @else
                                    <div class="bg-white shadow-sm p-3 rounded-circle mb-3 text-primary"><i class="fa-solid fa-cloud-arrow-up fs-4"></i></div>
                                    <h6 class="fw-bold text-dark mb-1">Foto Utama Kost</h6>
                                    <p class="small text-muted mb-0">Klik untuk mengganti</p>
                                @endif
                            </div>
                        </label>
                    </div>

                    @php 
                        $otherImages = $kost->other_images ? json_decode($kost->other_images, true) : [];
                        $img2 = isset($otherImages[0]) ? $otherImages[0] : null;
                        $img3 = isset($otherImages[1]) ? $otherImages[1] : null;
                        $img4 = isset($otherImages[2]) ? $otherImages[2] : null;
                    @endphp

                    <div class="col-12 col-md-6">
                        <label class="upload-box upload-small w-100" style="min-height: 200px; cursor: pointer;">
                            <input type="file" name="other_image_1" class="d-none" accept="image/*" onchange="previewImage(this, 'preview-2')">
                            <div id="preview-2" class="d-flex flex-column align-items-center justify-content-center w-100 h-100 p-3 text-center">
                                @if($img2)
                                    <img src="{{ asset($img2) }}" class="w-100 h-100 object-fit-cover rounded" alt="Foto Tampak Depan">
                                @else
                                    <i class="fa-solid fa-building mb-2 fs-3 text-secondary"></i>
                                    <h6 class="fw-bold text-dark mb-1">Foto Tampak Depan</h6>
                                    <p class="small text-muted mb-0">Klik untuk menambahkan</p>
                                @endif
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="upload-box upload-small w-100" style="min-height: 200px; cursor: pointer;">
                            <input type="file" name="other_image_2" class="d-none" accept="image/*" onchange="previewImage(this, 'preview-3')">
                            <div id="preview-3" class="d-flex flex-column align-items-center justify-content-center w-100 h-100 p-3 text-center">
                                @if($img3)
                                    <img src="{{ asset($img3) }}" class="w-100 h-100 object-fit-cover rounded" alt="Foto Fasilitas Bersama">
                                @else
                                    <i class="fa-solid fa-couch mb-2 fs-3 text-secondary"></i>
                                    <h6 class="fw-bold text-dark mb-1">Foto Fasilitas Bersama</h6>
                                    <p class="small text-muted mb-0">Klik untuk menambahkan</p>
                                @endif
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="upload-box upload-small w-100" style="min-height: 200px; cursor: pointer;">
                            <input type="file" name="other_image_3" class="d-none" accept="image/*" onchange="previewImage(this, 'preview-4')">
                            <div id="preview-4" class="d-flex flex-column align-items-center justify-content-center w-100 h-100 p-3 text-center">
                                @if($img4)
                                    <img src="{{ asset($img4) }}" class="w-100 h-100 object-fit-cover rounded" alt="Foto Lainnya">
                                @else
                                    <i class="fa-solid fa-image mb-2 fs-3 text-secondary"></i>
                                    <h6 class="fw-bold text-dark mb-1">Foto Lainnya</h6>
                                    <p class="small text-muted mb-0">Klik untuk menambahkan</p>
                                @endif
                            </div>
                        </label>
                    </div>
                </div>
                
                <p class="text-muted small mt-3"><i class="fa-solid fa-circle-info me-1"></i> Rekomendasi ukuran foto minimal 1280x720 pixel dalam format JPG atau PNG. Mengunggah foto baru akan menimpa foto lama jika diisi.</p>
            </div>


            <div class="d-flex justify-content-end align-items-center gap-3 mt-2">
                <a href="{{ route('pemilik.kost') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-primary-custom"><i class="fa-regular fa-floppy-disk me-2"></i> Update
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
                        container.innerHTML = '<img src="' + e.target.result + '" class="w-100 h-100 object-fit-cover rounded" alt="Preview">';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            function updateCount(input, textId) {
                var count = input.files ? input.files.length : 0;
                document.getElementById(textId).innerText = count + ' file dipilih';
            }

            const defaultLat = {{ $kost->latitude }};
            const defaultLng = {{ $kost->longitude }};

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
                document.getElementById('input_alamat').value = detail ? `${detail}, ${fromMap}` : fromMap;
            }

            document.getElementById('input_detail').addEventListener('input', combineAddress);

            marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                updateAddress(pos.lat, pos.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateAddress(e.latlng.lat, e.latlng.lng);
            });

            updateAddress(defaultLat, defaultLng);
        </script>
    @endpush
@endsection
