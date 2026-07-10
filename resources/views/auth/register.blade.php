<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi PRESISI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body>

    <img src="{{ asset('images/logo-presisi.png') }}" class="logo" alt="Logo PRESISI">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="register-card">

            <div class="register-header">
                <h4></i>Pendaftaran Akun Perangkat Daerah</h4>
                <small>Bapenda Provinsi Lampung</small>
            </div>

            <div class="p-4 p-md-5">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row g-4">

                        {{-- KOLOM KIRI --}}
                        <div class="col-md-6">

                            <div class="section-title identitas">Identitas Perangkat Daerah</div>

                            <div class="mb-3">
                                <label>Nama Perangkat Daerah</label>
                                <input type="text" name="nama_perangkat"
                                    class="form-control @error('nama_perangkat') is-invalid @enderror"
                                    placeholder="Dinas Komunikasi, Informatika dan Statistik"
                                    value="{{ old('nama_perangkat') }}">
                                @error('nama_perangkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="section-title kepala mt-4">Kepala Perangkat Daerah</div>

                            <div class="mb-3">
                                <label>Nama Lengkap (beserta Gelar)</label>
                                <input type="text" name="kepala_perangkat"
                                    class="form-control @error('kepala_perangkat') is-invalid @enderror"
                                    placeholder="Dr. Ir. H. Achmad Maulana, M.T." value="{{ old('kepala_perangkat') }}">
                                @error('kepala_perangkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Pangkat/Golongan</label>

                                <select name="pangkat_golongan"
                                    class="form-control @error('pangkat_golongan') is-invalid @enderror">

                                    <option value="">-- Pilih Pangkat/Golongan --</option>

                                    <option value="Juru Muda (I/a)" {{ old('pangkat_golongan') == 'Juru Muda (I/a)' ? 'selected' : '' }}>Juru Muda (I/a)</option>
                                    <option value="Juru Muda Tingkat I (I/b)" {{ old('pangkat_golongan') == 'Juru Muda Tingkat I (I/b)' ? 'selected' : '' }}>Juru Muda Tingkat I (I/b)</option>
                                    <option value="Juru (I/c)" {{ old('pangkat_golongan') == 'Juru (I/c)' ? 'selected' : '' }}>Juru (I/c)</option>
                                    <option value="Juru Tingkat I (I/d)" {{ old('pangkat_golongan') == 'Juru Tingkat I (I/d)' ? 'selected' : '' }}>Juru Tingkat I (I/d)</option>

                                    <option value="Pengatur Muda (II/a)" {{ old('pangkat_golongan') == 'Pengatur Muda (II/a)' ? 'selected' : '' }}>Pengatur Muda (II/a)</option>
                                    <option value="Pengatur Muda Tingkat I (II/b)" {{ old('pangkat_golongan') == 'Pengatur Muda Tingkat I (II/b)' ? 'selected' : '' }}>Pengatur Muda Tingkat I (II/b)
                                    </option>
                                    <option value="Pengatur (II/c)" {{ old('pangkat_golongan') == 'Pengatur (II/c)' ? 'selected' : '' }}>Pengatur (II/c)</option>
                                    <option value="Pengatur Tingkat I (II/d)" {{ old('pangkat_golongan') == 'Pengatur Tingkat I (II/d)' ? 'selected' : '' }}>Pengatur Tingkat I (II/d)</option>

                                    <option value="Penata Muda (III/a)" {{ old('pangkat_golongan') == 'Penata Muda (III/a)' ? 'selected' : '' }}>Penata Muda (III/a)</option>
                                    <option value="Penata Muda Tingkat I (III/b)" {{ old('pangkat_golongan') == 'Penata Muda Tingkat I (III/b)' ? 'selected' : '' }}>Penata Muda Tingkat I (III/b)
                                    </option>
                                    <option value="Penata (III/c)" {{ old('pangkat_golongan') == 'Penata (III/c)' ? 'selected' : '' }}>Penata (III/c)</option>
                                    <option value="Penata Tingkat I (III/d)" {{ old('pangkat_golongan') == 'Penata Tingkat I (III/d)' ? 'selected' : '' }}>Penata Tingkat I (III/d)</option>

                                    <option value="Pembina (IV/a)" {{ old('pangkat_golongan') == 'Pembina (IV/a)' ? 'selected' : '' }}>Pembina (IV/a)</option>
                                    <option value="Pembina Tingkat I (IV/b)" {{ old('pangkat_golongan') == 'Pembina Tingkat I (IV/b)' ? 'selected' : '' }}>Pembina Tingkat I (IV/b)</option>
                                    <option value="Pembina Utama Muda (IV/c)" {{ old('pangkat_golongan') == 'Pembina Utama Muda (IV/c)' ? 'selected' : '' }}>Pembina Utama Muda (IV/c)</option>
                                    <option value="Pembina Utama Madya (IV/d)" {{ old('pangkat_golongan') == 'Pembina Utama Madya (IV/d)' ? 'selected' : '' }}>Pembina Utama Madya (IV/d)</option>
                                    <option value="Pembina Utama (IV/e)" {{ old('pangkat_golongan') == 'Pembina Utama (IV/e)' ? 'selected' : '' }}>Pembina Utama (IV/e)</option>

                                </select>

                                @error('pangkat_golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label>NIP</label>
                                <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                                    placeholder="19XXXXXXXXXXXXX" value="{{ old('nip') }}">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="col-md-6">

                            <div class="section-title bendahara">Bendahara Penerimaan</div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label>Nama Bendahara</label>
                                    <input type="text" name="bendahara_penerimaan"
                                        class="form-control @error('bendahara_penerimaan') is-invalid @enderror"
                                        placeholder="Nama Lengkap" value="{{ old('bendahara_penerimaan') }}">
                                    @error('bendahara_penerimaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label>No. Handphone</label>
                                    <input type="text" name="no_hp"
                                        class="form-control @error('no_hp') is-invalid @enderror"
                                        placeholder="0812XXXXXXXX" value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="section-title keamanan mt-4">Keamanan Akun</div>

                            <div class="mb-3">
                                <label>Email Instansi (Username)</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="instansi@lampungprov.go.id" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Kata Sandi</label>
                                <div class="input-icon-wrap">
                                    <span class="icon-left"> <i class="ti ti-lock"></i> </span>
                                    <input type="password" name="password" id="passwordReg"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Min. 8 karakter">
                                    <button type="button" class="icon-right" onclick="toggleReg()">
                                        <i class="ti ti-eye" id="eyeReg"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Konfirmasi Kata Sandi</label>
                                <div class="input-icon-wrap">
                                    <span class="icon-left"> <i class="ti ti-lock"></i> </span>
                                    <input type="password" name="password_confirmation" id="passwordConfirm"
                                        class="form-control" placeholder="Ulangi kata sandi">
                                    <button type="button" class="icon-right" onclick="toggleConfirm()">
                                        <i class="ti ti-eye" id="eyeConfirm"></i>
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- TOMBOL SUBMIT --}}
                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-presisi px-5">
                            Daftar Akun Baru </i>
                        </button>

                        <div class="mt-3 auth-foot">
                            Sudah memiliki akses?
                            <a href="{{ route('login') }}">Masuk</a>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <script>
        function toggleReg() {
            const input = document.getElementById('passwordReg');
            const icon = document.getElementById('eyeReg');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ti-eye', 'ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.replace('ti-eye-off', 'ti-eye');
            }
        }
        function toggleConfirm() {
            const input = document.getElementById('passwordConfirm');
            const icon = document.getElementById('eyeConfirm');
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