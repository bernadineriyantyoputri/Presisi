<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login PRESISI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body>

    <img src="{{ asset('images/logo-presisi.png') }}" class="logo" alt="Logo PRESISI">

    <div class="d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="auth-card">

            <div class="auth-header">
                <i></i>
                Masuk ke Sistem
            </div>

            <div class="auth-body">

                <div class="auth-title">Selamat Datang</div>
                <div class="auth-sub">Silakan masuk menggunakan akun resmi Anda</div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    @if (session('success'))
                        <div class="alert alert-success py-2 px-3 mb-3" style="font-size: 13px;">
                            <i class="ti ti-circle-check me-1"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger py-2 px-3 mb-3" style="font-size: 13px;">
                            <i class="ti ti-alert-circle me-1"></i>{{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label>Nama Pengguna (Username)</label>
                        <div class="input-icon-wrap has-icon-l">
                            <i class="ti ti-user icon-left"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan username" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="label-row">
                            <label>Kata Sandi (Password)</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">Lupa Kata Sandi?</a>
                            @endif
                        </div>
                        <div class="input-icon-wrap has-icon-l">
                            <i class="ti ti-lock icon-left"></i>
                            <input type="password" name="password" id="passwordInput" class="form-control"
                                placeholder="Min. 8 karakter">
                            <button type="button" class="icon-right" onclick="togglePassword()">
                                <i class="ti ti-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-presisi w-100">
                        Masuk ke Sistem
                    </button>
                </form>
                <hr class="auth-divider">

                <div class="auth-foot">
                    Belum memiliki akses?
                    <a href="{{ route('register') }}">Daftar Akun Baru</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ti-eye', 'ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.replace('ti-eye-off', 'ti-eye');
            }
        }
    </script>
</body>
</html>