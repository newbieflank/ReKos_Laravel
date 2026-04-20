@extends('layouts.app') {{-- Pastikan Anda punya layout utama --}}

@section('content')
    <div class="container py-4">
        {{-- Alerts / Flasher Laravel Style --}}
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="flashMessage">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header border-bottom py-3">
                <h5 class="card-title mb-0">Informasi Pribadi</h5>
            </div>

            <div class="card-body p-4">
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#changeImageModal">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle border p-1 shadow-sm"
                                alt="Profile Image"
                                style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;">
                            <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow">
                                <i class="fas fa-camera"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="unknown"
                                    {{ old('gender', $user->userDetail->gender) == 'unknown' ? 'selected' : '' }}>Pilih
                                    Jenis
                                    Kelamin</option>
                                <option value="male"
                                    {{ old('gender', $user->userDetail->gender) == 'male' ? 'selected' : '' }}>Laki-Laki
                                </option>
                                <option value="female"
                                    {{ old('gender', $user->userDetail->gender) == 'female' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control datepicker" id="birth_date" name="birth_date"
                                value="{{ old('birth_date', $user->userDetail->birth_date) }}" placeholder="YYYY-MM-DD">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="occupation" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" id="occupation" name="occupation"
                                value="{{ old('occupation', $user->userDetail->occupation) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="institution" class="form-label">Nama Instansi</label>
                            <input type="text" class="form-control" id="institution" name="institution"
                                value="{{ old('institution', $user->userDetail->institution) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Kota Asal</label>
                            <input type="text" class="form-control" id="city" name="city"
                                value="{{ old('city', $user->userDetail->city) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="number" class="form-control" id="phone" name="phone"
                                value="{{ old('phone', $user->userDetail->phone) }}">
                        </div>

                        <div class="col-12 mb-4">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea name="address" id="address" rows="3" class="form-control" style="resize: none;">{{ old('address', $user->userDetail->address) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light border"
                            onclick="window.location.reload()">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ganti Foto Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih File Gambar (Max 2MB)</label>
                            <input type="file" class="form-control" name="avatar" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            background-color: #F3F2FF;
        }

        .card-header {
            background-color: #e5e4ff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Flatpickr (Tanggal)
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
            });

            // Auto hide alert
            const alert = document.getElementById('flashMessage');
            if (alert) {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 4000);
            }
        });
    </script>
@endpush
