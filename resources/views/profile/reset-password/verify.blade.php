@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title mb-0">Verifikasi OTP</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-4">
                        Masukkan 6 digit kode OTP yang telah kami kirimkan ke email Anda.
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

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.reset-password.verify-submit') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-center gap-2 mb-4">
                            @for ($i = 0; $i < 6; $i++)
                                <input type="text" name="otp[]" class="form-control text-center fs-4 fw-bold" 
                                    style="width: 50px; height: 60px;" maxlength="1" required 
                                    onkeyup="moveToNext(this, event)">
                            @endfor
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">Verifikasi OTP</button>
                            <a href="{{ route('profile.edit') }}" class="btn btn-light border py-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function moveToNext(current, event) {
        if (current.value.length >= 1) {
            let next = current.nextElementSibling;
            if (next && next.tagName === 'INPUT') {
                next.focus();
            }
        }
        if (event.key === 'Backspace') {
            let prev = current.previousElementSibling;
            if (prev && prev.tagName === 'INPUT') {
                prev.focus();
            }
        }
    }
</script>
@endsection
