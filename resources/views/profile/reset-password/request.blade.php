@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0">Reset Password</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <h4 class="mb-3">Konfirmasi Reset Password</h4>
                    <p class="text-muted mb-4">
                        Apakah Anda yakin ingin mengatur ulang kata sandi Anda? <br>
                        Kami akan mengirimkan kode OTP ke email <strong>{{ auth()->user()->email }}</strong>.
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

                    <form action="{{ route('profile.reset-password.send') }}" method="POST">
                        @csrf
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">Ya, Kirim Kode OTP</button>
                            <a href="{{ route('profile.edit') }}" class="btn btn-light border py-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
