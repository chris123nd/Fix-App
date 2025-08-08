@extends('auth.layouts.main')

@section('container')

<div class="row text-center justify-content-center">
    <div class="col-lg-6">
        <main class="form-signin w-100 m-auto">

            {{-- Pesan Flash Data Jika Berhasil Register --}}
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ $message }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h1 class="h3 fw-normal mb-5">PT Wide Technologies New</h1>

            {{-- Gabungkan semua pesan error --}}
            @php
                $isThrottlingError = session()->has('countdown_seconds');
                $errorMessage = $isThrottlingError ? session('error') : (session('error') ?? $errors->first('email') ?? $errors->first('password'));
            @endphp

            @if ($errorMessage)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span>{{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @if($isThrottlingError)
                        <p id="countdown" class="mt-2"></p>
                    @endif
                </div>
            @endif

            <form action="/" method="POST">
                @csrf
                
                <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name="email" value="{{ old('email') }}" @if($isThrottlingError) disabled @endif>
                    <label for="floatingInput">Email address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" name="password" @if($isThrottlingError) disabled @endif>
                    <label for="floatingPassword">Password</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                <button class="w-100 btn btn-lg btn-primary" type="submit" @if($isThrottlingError) disabled @endif>Login</button>
            </form>

            <div class="text-center">
                <p class="mt-5 mb-3 text-body-secondary">Copyright &copy; PT Wide Technologies {{ date('Y') }}</p>
            </div>
        </main>
    </div>
</div>

@endsection

@if(session()->has('countdown_seconds'))
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let seconds = {{ session('countdown_seconds') }};
            const countdownElement = document.getElementById('countdown');
            const formInputs = document.querySelectorAll('form input, form button');
            
            if (countdownElement) {
                function updateCountdown() {
                    if (seconds > 0) {
                        const minutes = Math.floor(seconds / 60);
                        const remainingSeconds = seconds % 60;
                        countdownElement.textContent = `Silakan coba lagi dalam ${minutes} menit ${remainingSeconds} detik.`;
                        seconds--;
                    } else {
                        countdownElement.textContent = `Anda bisa mencoba lagi.`;
                        clearInterval(timer);
                        location.reload(); // Reload halaman untuk mengaktifkan form
                    }
                }

                updateCountdown();
                const timer = setInterval(updateCountdown, 1000);
            }
        });
    </script>
@endsection
@endif