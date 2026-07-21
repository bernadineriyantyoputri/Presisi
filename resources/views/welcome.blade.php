<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PRESISI — Digitalisasi Laporan Realisasi Penerimaan Retribusi Daerah</title>
    <meta name="description"
        content="PRESISI — Sistem pelaporan realisasi penerimaan retribusi daerah Provinsi Lampung yang mudah, akurat, dan terintegrasi.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>


    <!-- ===================== HERO ===================== -->
    <section class="hero" id="top">
        <div class="wrap hero-grid">
            <div>
                <span class="eyebrow">Provinsi Lampung</span>
                <h1>Digitalisasi Laporan Realisasi Penerimaan Retribusi Daerah</h1>
                <p>Mewujudkan transparansi fiskal dan efisiensi pelaporan pendapatan daerah Provinsi Lampung melalui
                    sistem informasi terpadu yang presisi.</p>
                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">Masuk Ke Sistem</a>
                    <a href="{{ route('register') }}" class="btn btn-ghost">Daftar Akun</a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="{{ asset('images/logo-presisi.png') }}" alt="PRESISI — Realisasi Penerimaan Retribusi Daerah"
                    class="hero-logo">
            </div>
        </div>
    </section>

    <!-- ===================== FITUR ===================== -->
    <section class="section" id="fitur">
        <div class="wrap">
            <div class="section-head">
                <h2>Fitur Utama PRESISI<span class="rule"></span></h2>
                <p>PRESISI hadir untuk mendukung pengelolaan dan pelaporan retribusi daerah yang lebih mudah, akurat,
                    dan terintegrasi.</p>
            </div>
            <div class="features-grid">

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M7 3h10a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"
                                stroke="currentColor" stroke-width="1.7" />
                            <path d="M9 8h6M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3>Pelaporan Retribusi</h3>
                    <p>Menginput realisasi penerimaan retribusi daerah secara digital dengan mudah dan terstruktur.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M4 20V10M12 20V4M20 20v-7" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Monitoring Penerimaan</h3>
                    <p>Memantau perkembangan realisasi penerimaan retribusi daerah secara real-time melalui dashboard
                        yang informatif.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M6 4h9l5 5v11a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z" stroke="currentColor"
                                stroke-width="1.7" stroke-linejoin="round" />
                            <path d="M14 4v5h5" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Laporan Otomatis</h3>
                    <p>Menghasilkan laporan siap cetak dalam format PDF sesuai kebutuhan.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M12 3l7 3v6c0 5-3 8.5-7 9.5-4-1-7-4.5-7-9.5V6l7-3z" stroke="currentColor"
                                stroke-width="1.7" stroke-linejoin="round" />
                            <path d="M9.5 12l1.8 1.8L14.5 10" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Keamanan Data</h3>
                    <p>Data tersimpan aman dengan proses validasi dan hak akses berlapis.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.7" />
                            <path d="M12 8v4l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Riwayat Pelaporan</h3>
                    <p>Menyimpan riwayat perubahan data untuk memudahkan proses penelusuran dan audit.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M4 13a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" />
                            <rect x="3" y="13" width="4" height="6" rx="1.2" stroke="currentColor" stroke-width="1.7" />
                            <rect x="17" y="13" width="4" height="6" rx="1.2" stroke="currentColor"
                                stroke-width="1.7" />
                        </svg>
                    </div>
                    <h3>Bantuan Pengguna</h3>
                    <p>Tim administrator siap membantu apabila mengalami kendala penggunaan sistem.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ===================== CTA ===================== -->
    <section class="cta-section">
        <div class="wrap">
            <div class="cta-card">
                <h2>Siap Memulai Pelaporan?</h2>
                <p>Kelola dan sampaikan laporan realisasi penerimaan retribusi daerah secara cepat, akurat, dan
                    terintegrasi untuk mendukung tata kelola keuangan daerah di Provinsi Lampung.</p>
                <div class="cta-actions">
                    <a href="{{ route('login') }}" class="btn btn-dark">Masuk Akun</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-dark">Daftar Akun</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== KONTAK ===================== -->
    <section class="contact-section" id="kontak">
        <div class="wrap contact-grid">
            <div>
                <h2>Hubungi Kami</h2>
                <p>Memiliki pertanyaan atau kendala teknis? Tim kami siap membantu Anda setiap hari kerja.</p>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                            <path d="M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.5C5 14.9 12 21 12 21z" stroke="currentColor"
                                stroke-width="1.7" stroke-linejoin="round" />
                            <circle cx="12" cy="9.5" r="2.4" stroke="currentColor" stroke-width="1.7" />
                        </svg>
                    </div>
                    <div>
                        <h4>Kantor Pusat</h4>
                        <p>Jl. Sultan Hasanudin No.45, Gn. MAS, Kec. Tlk. Betung Utara,<br>Kota Bandar Lampung, Lampung
                            35211, Indonesia.</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M6 3h3l2 5-2.5 1.5a11 11 0 0 0 5 5L15 12l5 2v3a2 2 0 0 1-2 2A16 16 0 0 1 4 5a2 2 0 0 1 2-2z"
                                stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <h4>Telepon</h4>
                        <p><a href="tel:072148126">(0721) 481126</a></p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.7" />
                            <path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <h4>Email Resmi</h4>
                        <p><a href="mailto:bapenda@lampungprov.go.id">bapenda@lampungprov.go.id</a></p>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <form id="contactForm" novalidate>
                    <div class="field">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama anda" required>
                    </div>
                    <div class="field">
                        <label for="emailDinas">Email Dinas</label>
                        <input type="email" id="emailDinas" name="emailDinas" placeholder="nama@instansi.go.id"
                            required>
                    </div>
                    <div class="field">
                        <label for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" placeholder="Tuliskan pertanyaan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">Kirim Pesan</button>

                </form>
            </div>
        </div>
    </section>

    <!-- ===================== FOOTER ===================== -->
    <footer class="footer">
        <div class="wrap">
            <div class="footer-top">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo-bapenda.png') }}" alt="BAPENDA Provinsi Lampung">
                </div>

                <div class="footer-address">
                    <h5>BADAN PENDAPATAN DAERAH<br>Provinsi Lampung</h5>
                    <p>Jl. Hasanudin No. 45 Kelurahan Gunung Mas<br> Kecamatan Teluk Betung Utara<br>Kota Bandar Lampung
                    </p>
                    <p class="footer-phone">(0721) 481126</p>
                </div>

                <div class="footer-social">
                    <h5>Sosial Media</h5>
                    <div class="social-row">

                        <!-- Website -->
                        <a href="https://bapenda.lampungprov.go.id/konsep/index.php/profil/bapenda-lampung"
                            target="_blank" rel="noopener" aria-label="Website">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6" />
                                <path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18" stroke="currentColor"
                                    stroke-width="1.6" />
                            </svg>
                        </a>

                        <!-- Share -->
                        <a href="#" id="shareBtn" aria-label="Bagikan halaman">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <circle cx="6" cy="12" r="2.2" stroke="currentColor" stroke-width="1.6" />
                                <circle cx="18" cy="6" r="2.2" stroke="currentColor" stroke-width="1.6" />
                                <circle cx="18" cy="18" r="2.2" stroke="currentColor" stroke-width="1.6" />
                                <path d="M8 10.8l8-4.6M8 13.2l8 4.6" stroke="currentColor" stroke-width="1.6" />
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a href="https://www.instagram.com/bapenda_lampung/" target="_blank" rel="noopener"
                            aria-label="Instagram">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="18" height="18" rx="5" stroke="currentColor"
                                    stroke-width="1.6" />
                                <circle cx="12" cy="12" r="3.6" stroke="currentColor" stroke-width="1.6" />
                                <circle cx="17.2" cy="6.8" r="1" fill="currentColor" />
                            </svg>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/bapendaprovlampung/" target="_blank" rel="noopener"
                            aria-label="Facebook">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H9v3h2v6h3v-6h3l1-3h-4V9c0-.3.2-.5.5-.5z"
                                    fill="currentColor" />
                            </svg>
                        </a>

                        <!-- YouTube -->
                        <a href="https://www.youtube.com/@bapendalampung" target="_blank" rel="noopener"
                            aria-label="YouTube">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="6" width="18" height="12" rx="3" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M11 10l4 2-4 2v-4z" fill="currentColor" />
                            </svg>
                        </a>

                        <!-- Email -->
                        <a href="mailto:bapenda@lampungprov.go.id" aria-label="Email">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor"
                                    stroke-width="1.6" />
                                <path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.6" />
                            </svg>
                        </a>

                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <span>© 2026 Badan Pendapatan Daerah Provinsi Lampung. Seluruh Hak Cipta Dilindungi.</span>
                <span>
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Peta Situs</a>
                </span>
            </div>
        </div>
    </footer>

    <script>
        // Mobile nav toggle
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');
        navToggle.addEventListener('click', () => {
            navLinks.classList.toggle('open');
        });
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => navLinks.classList.remove('open'));
        });

        // Contact form (front-end only placeholder — hook up to your backend endpoint)
        const contactForm = document.getElementById('contactForm');
        const formNote = document.getElementById('formNote');
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!contactForm.checkValidity()) {
                contactForm.reportValidity();
                return;
            }
            // TODO: ganti bagian ini dengan pemanggilan API/endpoint backend anda
            formNote.textContent = 'Pesan terkirim. Terima kasih telah menghubungi kami.';
            formNote.style.color = '#1a4a8f';
            contactForm.reset();
        });
    </script>

    <script>
        const shareBtn = document.getElementById('shareBtn');

        if (shareBtn) {
            shareBtn.addEventListener('click', async function (e) {
                e.preventDefault();

                const shareData = {
                    title: 'PRESISI',
                    text: 'Digitalisasi Laporan Realisasi Penerimaan Retribusi Daerah',
                    url: window.location.href
                };

                if (navigator.share) {
                    try {
                        await navigator.share(shareData);
                    } catch (err) { }
                } else {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                        alert('Link berhasil disalin ke clipboard.');
                    } catch (err) {
                        alert(window.location.href);
                    }
                }
            });
        }
    </script>
</body>

</html>