<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Donasiku</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
</head>

<body>

<!-- ═══════════════════════════════
     NAVBAR
═══════════════════════════════ -->
<nav class="navbar navbar-expand-lg navbar-custom" id="mainNav">
    <div class="container px-4">

        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="#">
            <img src="{{ asset('assets/img/Logodonasi.png') }}" style="width:38px; height:38px; object-fit:contain;" alt="Logo">
            <span class="navbar-brand-name">DONASIKU</span>
        </a>

        <button class="navbar-toggler navbar-toggler-custom" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <li class="nav-item"><a class="nav-link nav-link-custom active" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link nav-link-custom" href="#cara-kerja">Cara Kerja</a></li>

                @guest
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link nav-link-custom nav-btn-outline" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item ms-lg-1">
                        <a class="nav-link nav-link-custom nav-btn-filled" href="{{ route('register') }}">Daftar</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link nav-link-custom nav-btn-filled" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endauth
            </ul>
        </div>

    </div>
</nav>


<!-- ═══════════════════════════════
     HERO
═══════════════════════════════ -->
<header class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-noise"></div>

        <div class="container px-4">
        <div class="row align-items-center justify-content-center text-center g-5">

            <!-- Center Content -->
            <div class="col-lg-6 hero-content text-center">
                <h1 class="hero-title">Donasi Mudah Bersama DONASIKU.</h1>
                <p class="hero-subtitle">
                    Platform donasi barang layak pakai untuk warga RW 03. Salurkan barang layak pakai Anda dengan mudah, transparan, dan tepat sasaran.
                </p>
            </div>
        </div>
    </div>
</header>


<!-- ═══════════════════════════════
     ABOUT
═══════════════════════════════ -->
<section class="about-section" id="tentang">
    <div class="container px-4">
        <div class="row align-items-center g-5">

            <div class="col-lg-5 reveal">
                <div class="about-image-wrap">
                    <div class="about-image-box">
                        <img src="{{ asset('assets/img/Logodonasi.png') }}" 
                            alt="About Image" 
                            class="img-fluid about-img">
                    </div>
                </div>
            </div>

            <div class="col-lg-6 offset-lg-1 reveal reveal-delay-1">
                <span class="section-eyebrow">Tentang Kami</span>
                <h2 class="section-title">Platform donasi barang layak pakai</h2>
                <p class="section-lead">
                    Donasiku menghubungkan donatur dengan penerima manfaat secara langsung dan transparan. Kami memastikan setiap barang sampai ke tangan yang tepat.
                </p>
                <ul class="check-list">
                    <li>Proses donasi cepat, hanya beberapa langkah mudah</li>
                    <li>Verifikasi penerima manfaat oleh tim relawan</li>
                    <li>Laporan penyaluran real-time dan transparan</li>
                    <li>Jangkauan ke seluruh wilayah Rw 03</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<section class="how-section" id="cara-kerja">
    <div class="container px-4">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center reveal">
                <span class="section-eyebrow">Cara Kerja</span>
                <h2 class="section-title">Bagaimana Sistem Kami Bekerja?</h2>
            </div>
        </div>

        <div class="how-grid">

            <div class="how-step reveal">
                <span class="how-step-tag" style="background:var(--accent-light); color:var(--accent);">Langkah 01</span>
                <div class="how-num" style="background:var(--accent-light); color:var(--accent);">
                    <i class="bi bi-upload"></i>
                </div>
                <h5>Unggah Donasi</h5>
                <p>Masukkan detail dan foto barang layak pakai.</p>
            </div>

            <div class="how-step reveal reveal-delay-1">
                <span class="how-step-tag" style="background:var(--teal-light); color:var(--teal);">Langkah 02</span>
                <div class="how-num" style="background:var(--teal-light); color:var(--teal);">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h5>Verifikasi Admin</h5>
                <p>Admin melakukan pengecekan dan validasi.</p>
            </div>

            <div class="how-step reveal reveal-delay-2">
                <span class="how-step-tag" style="background:#E8F4FD; color:#2563EB;">Langkah 03</span>
                <div class="how-num" style="background:#E8F4FD; color:#2563EB;">
                    <i class="bi bi-truck"></i>
                </div>
                <h5>Distribusi</h5>
                <p>Barang disalurkan kepada penerima.</p>
            </div>
        </div>
    </div>
</section>

<footer class="footer-custom">
    <div class="container px-4">
        <div class="row g-5">

            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset('assets/img/Logodonasi.png') }}" style="width:32px; height:32px; object-fit:contain;" alt="Logo">
                    <div class="footer-brand">Donasiku</div>
                </div>
                <p class="footer-tagline">Platform donasi barang layak pakai untuk menghubungkan donatur dengan masyarakat yang membutuhkan.</p>
            </div>

            <div class="col-6 col-lg-2 offset-lg-2">
                <div class="footer-heading">Platform</div>
                <ul class="footer-links">
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#cara-kerja">Cara Kerja</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <div class="footer-heading">Akun</div>
                <ul class="footer-links">
                    <li><a href="{{ route('login') }}">Masuk</a></li>
                    <li><a href="{{ route('register') }}">Daftar</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <div class="footer-heading">Legal</div>
                <ul class="footer-links">
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat Layanan</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>

        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
            <p class="footer-copy">© {{ date('Y') }} Donasiku. Semua hak dilindungi.</p>
            <div class="footer-socials">
                <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>
</footer>


<!-- ═══════════════════════════════
     SCRIPTS
═══════════════════════════════ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ─── Navbar scroll effect
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 40);
    });

    // ─── Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    reveals.forEach(el => observer.observe(el));
</script>

</body>
</html>