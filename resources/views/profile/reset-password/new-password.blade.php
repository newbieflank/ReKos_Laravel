@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0">Atur Ulang Kata Sandi</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-4">
                        Masukkan kata sandi baru Anda.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger text-start">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.reset-password.update') }}" method="POST">
                        @csrf
                        <div class="mb-3 text-start">
                            <label class="form-label fw-semibold">Kata Sandi Baru</label>
                            <input type="password" name="password" class="form-control py-2" placeholder="Minimal 8 karakter" required>
                        </div>
                        
                        <div class="mb-4 text-start">
                            <label class="form-label fw-semibold">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" class="form-control py-2" placeholder="Ulangi kata sandi" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">Simpan Kata Sandi</button>
                            <a href="{{ route('profile.edit') }}" class="btn btn-light border py-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
