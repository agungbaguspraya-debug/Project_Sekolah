<x-guest-layout>
    <!-- Header Branding -->
    <div class="text-center mb-4">
        <div class="brand-icon-box">
            <i class="bi bi-rocket-takeoff-fill fs-2 text-white"></i>
        </div>
        <h4 class="fw-bold text-white mb-1 tracking-wide">SMKS WIRA HARAPAN</h4>
        <p class="text-white-50 small mb-0">Sistem Informasi Akademik & Portal Sekolah</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="alert alert-info border-0 py-2 small mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address Field -->
        <div class="mb-3">
            <label for="email" class="form-label text-white-50 fw-semibold small mb-1">Email / NIP / NIS</label>
            <div class="position-relative">
                <i class="bi bi-envelope-fill input-group-icon"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" 
                       class="form-control form-control-custom @error('email') is-invalid @enderror" 
                       placeholder="masukkan.email@sekolah.sch.id" required autofocus autocomplete="username">
            </div>
            @error('email')
                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label text-white-50 fw-semibold small mb-0">Kata Sandi (Password)</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-primary text-decoration-none small hover-underline">Lupa Password?</a>
                @endif
            </div>
            <div class="position-relative">
                <i class="bi bi-lock-fill input-group-icon"></i>
                <input id="password" type="password" name="password" 
                       class="form-control form-control-custom pe-5 @error('password') is-invalid @enderror" 
                       placeholder="••••••••" required autocomplete="current-password">
                <button type="button" class="btn text-white-50 position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent pe-3 toggle-password" data-target="password" title="Lihat / Sembunyikan Password">
                    <i class="bi bi-eye-slash-fill fs-5"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="form-check mb-4">
            <input class="form-check-input bg-dark border-secondary" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label text-white-50 small" for="remember_me">
                Ingat saya di perangkat ini
            </label>
        </div>

        <!-- Login Submit Button -->
        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Ke Akun
            </button>
        </div>

        <!-- Multi-role Info Badges -->
        <div class="text-center pt-3 border-top border-secondary border-opacity-25">
            <small class="text-white-50 d-block mb-2">Akses Portal Terintegrasi:</small>
            <div class="d-flex justify-content-center gap-2">
                <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-50 px-2 py-1 small">
                    <i class="bi bi-shield-lock me-1"></i> Admin
                </span>
                <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 px-2 py-1 small">
                    <i class="bi bi-person-workspace me-1"></i> Guru
                </span>
                <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-2 py-1 small">
                    <i class="bi bi-mortarboard me-1"></i> Siswa
                </span>
            </div>
        </div>
    </form>
</x-guest-layout>
