<?php session_start(); ?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Laporan Banjir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #f8fafc
                );

            font-family: 'Segoe UI', sans-serif;

            overflow-x: hidden;
        }

        /* NAVBAR */

        .navbar{

            padding: 16px 0;

            background:
                rgba(15,23,42,0.92) !important;

            backdrop-filter: blur(10px);

            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .navbar-brand{

            font-size: 22px;

            font-weight: 700;

            color: white !important;
        }

        .btn-admin{

            border-radius: 12px;

            padding: 10px 18px;

            font-weight: 600;
        }

        /* HERO */

        .hero{

            padding: 70px 0 40px;
        }

        .hero-badge{

            display: inline-flex;

            align-items: center;

            gap: 8px;

            background: rgba(37,99,235,0.1);

            color: #2563eb;

            padding: 10px 16px;

            border-radius: 50px;

            font-size: 14px;

            font-weight: 600;

            margin-bottom: 20px;
        }

        .hero h1{

            font-size: 52px;

            font-weight: 800;

            color: #0f172a;

            line-height: 1.2;

            margin-bottom: 18px;
        }

        .hero p{

            font-size: 18px;

            color: #64748b;

            line-height: 1.8;

            max-width: 650px;
        }

        /* CARD */

        .main-card{

            background: white;

            border-radius: 28px;

            border: none;

            box-shadow: 0 10px 40px rgba(0,0,0,0.06);

            overflow: hidden;
        }

        .card-header-custom{

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            padding: 30px;

            color: white;
        }

        .card-header-custom h4{

            font-size: 28px;

            font-weight: 700;

            margin-bottom: 10px;
        }

        .card-header-custom p{

            opacity: 0.9;

            margin: 0;
        }

        .card-body-custom{

            padding: 35px;
        }

        /* FORM */

        .form-label{

            font-weight: 600;

            margin-bottom: 10px;

            color: #111827;
        }

        .form-control{

            height: 56px;

            border-radius: 16px;

            border: 1px solid #d1d5db;

            padding: 14px 18px;

            transition: 0.3s;
        }

        textarea.form-control{

            height: auto;
        }

        .form-control:focus{

            border-color: #2563eb;

            box-shadow: 0 0 0 4px rgba(37,99,235,0.12);
        }

        /* BUTTON */

        .btn-custom{

            height: 54px;

            border-radius: 14px;

            font-weight: 600;

            padding: 0 22px;
        }

        .btn-primary{

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            border: none;
        }

        .btn-primary:hover{

            transform: translateY(-2px);

            box-shadow: 0 10px 20px rgba(37,99,235,0.2);
        }

        /* LOKASI */

        .location-box{

            background: #f8fafc;

            border: 1px dashed #cbd5e1;

            padding: 18px;

            border-radius: 16px;
        }

        #loading-lokasi{

            display: none;

            color: #2563eb;

            font-weight: 500;
        }

        #status-lokasi{

            margin-top: 10px;

            font-size: 14px;
        }

        /* BERITA */

        .news-card{

            background: white;

            border-radius: 24px;

            padding: 28px;

            box-shadow: 0 10px 40px rgba(0,0,0,0.05);

            height: 100%;
        }

        .news-header{

            margin-bottom: 24px;
        }

        .news-header h4{

            font-weight: 700;

            color: #111827;
        }

        .berita-item{

            padding: 18px;

            border-radius: 18px;

            background: #f8fafc;

            margin-bottom: 16px;

            transition: 0.3s;

            border: 1px solid transparent;
        }

        .berita-item:hover{

            transform: translateY(-4px);

            border-color: #bfdbfe;

            background: white;

            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
        }

        .berita-item h5{

            font-size: 17px;

            font-weight: 700;

            margin-bottom: 10px;

            color: #0f172a;
        }

        .berita-item p{

            color: #64748b;

            margin-bottom: 8px;

            line-height: 1.7;
        }

        .berita-item small{

            color: #94a3b8;
        }

        /* ALERT */

        .alert{

            border-radius: 16px;
        }

        /* RESPONSIVE */

        @media(max-width:992px){

            .hero{

                padding-top: 40px;
            }

            .hero h1{

                font-size: 38px;
            }

            .card-body-custom{

                padding: 25px;
            }
        }

    </style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a class="navbar-brand" href="#">
            <i class="bi bi-water"></i>
            Sistem Laporan Banjir
        </a>

        <div class="ms-auto">

            <a href="admin/login_admin.php"
               class="btn btn-outline-light btn-admin">

                <i class="bi bi-shield-lock"></i>
                Login Admin

            </a>

        </div>

    </div>

</nav>

<!-- HERO -->

<section class="hero">

    <div class="container">

        <div class="hero-badge">

            <i class="bi bi-broadcast"></i>

            Sistem Pelaporan Cepat & Realtime

        </div>

        <h1>
            Laporkan Kejadian Banjir
            Secara Cepat dan Akurat
        </h1>

        <p>
            Platform pelaporan banjir digital untuk membantu masyarakat
            mengirimkan informasi lokasi terdampak secara realtime
            kepada BPBD agar proses penanganan lebih cepat dan efisien.
        </p>

    </div>

</section>

<!-- CONTENT -->

<div class="container pb-5">

    <div class="row g-4">

        <!-- FORM -->

        <div class="col-lg-7">

            <div class="main-card">

                <div class="card-header-custom">

                    <h4>
                        <i class="bi bi-file-earmark-text"></i>
                        Form Laporan Banjir
                    </h4>

                    <p>
                        Lengkapi data laporan dengan benar.
                    </p>

                </div>

                <div class="card-body-custom">

                    <?php if(isset($_SESSION['success'])): ?>

                        <div class="alert alert-success">

                            <i class="bi bi-check-circle"></i>

                            <?= $_SESSION['success']; unset($_SESSION['success']); ?>

                        </div>

                    <?php endif; ?>

                    <form action="proses_laporan.php"
                          method="POST"
                          enctype="multipart/form-data"
                          id="formLaporan">

                        <!-- NAMA -->

                        <div class="mb-4">

                            <label class="form-label">
                                Nama Pelapor
                            </label>

                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   placeholder="Masukkan nama lengkap"
                                   required>

                        </div>

                        <!-- EMAIL -->

                        <div class="mb-4">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   placeholder="Masukkan email aktif"
                                   required>

                        </div>

                        <!-- JALAN -->

                        <div class="mb-4">

                            <label class="form-label">
                                Nama Jalan / Lokasi
                            </label>

                            <input type="text"
                                   name="jalan"
                                   class="form-control"
                                   placeholder="Contoh: Jl. Merdeka No. 10"
                                   required>

                        </div>

                        <!-- FOTO -->

                        <div class="mb-4">

                            <label class="form-label">
                                Upload Foto Banjir
                            </label>

                            <input type="file"
                                   name="foto"
                                   class="form-control"
                                   accept="image/*"
                                   required>

                        </div>

                        <!-- KETERANGAN -->

                        <div class="mb-4">

                            <label class="form-label">
                                Keterangan Tambahan
                            </label>

                            <textarea name="keterangan"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Tambahkan informasi kondisi banjir..."></textarea>

                        </div>

                        <!-- GPS -->

                        <input type="hidden"
                               name="gps"
                               id="gps_input"
                               value="">

                        <div class="location-box mb-4">

                            <button type="button"
                                    id="ambilLokasiBtn"
                                    class="btn btn-secondary btn-custom">

                                <i class="bi bi-geo-alt"></i>

                                Dapatkan Lokasi Saya

                            </button>

                            <div id="loading-lokasi" class="mt-3">

                                <i class="bi bi-arrow-repeat"></i>

                                Mengambil lokasi GPS...

                            </div>

                            <div id="status-lokasi"
                                 class="text-muted"></div>

                        </div>

                        <!-- BUTTON -->

                        <div class="d-flex flex-wrap gap-3">

                            <button type="submit"
                                    class="btn btn-primary btn-custom"
                                    id="submitBtn">

                                <i class="bi bi-send"></i>

                                Kirim Laporan

                            </button>

                            <a href="cek_status.php"
                               class="btn btn-info text-white btn-custom d-flex align-items-center">

                                <i class="bi bi-search me-2"></i>

                                Cek Status

                            </a>

                            <a href="grafik.php"
                               class="btn btn-dark btn-custom d-flex align-items-center">

                                <i class="bi bi-bar-chart me-2"></i>

                                Grafik

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <!-- NEWS -->

        <div class="col-lg-5">

            <div class="news-card">

                <div class="news-header">

                    <h4>
                        <i class="bi bi-megaphone"></i>
                        Informasi Terkini
                    </h4>

                </div>

                <div class="berita-item">

                    <h5>⚠️ Siaga Banjir – 25 Mei 2026</h5>

                    <p>
                        Curah hujan tinggi masih terjadi di beberapa wilayah.
                        Warga sekitar bantaran sungai diimbau tetap waspada.
                    </p>

                    <small>BPBD Kota</small>

                </div>

                <div class="berita-item">

                    <h5>🚨 Posko Pengungsian Dibuka</h5>

                    <p>
                        Posko utama di Balai Kota dan beberapa titik tambahan
                        siap menerima masyarakat terdampak banjir.
                    </p>

                    <small>2 Jam Lalu</small>

                </div>

                <div class="berita-item">

                    <h5>📞 Kontak Darurat BPBD</h5>

                    <p>
                        Hubungi call center darurat:
                        112 / 021-1234567 jika membutuhkan bantuan cepat.
                    </p>

                    <small>Update Terbaru</small>

                </div>

                <div class="berita-item">

                    <h5>🎒 Tips Menghadapi Banjir</h5>

                    <p>
                        Simpan dokumen penting di tempat aman,
                        matikan listrik, dan lakukan evakuasi
                        jika air mulai meningkat.
                    </p>

                    <small>Penting</small>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

    const gpsInput = document.getElementById('gps_input');

    const statusDiv = document.getElementById('status-lokasi');

    const loadingDiv = document.getElementById('loading-lokasi');

    const ambilBtn = document.getElementById('ambilLokasiBtn');

    const submitBtn = document.getElementById('submitBtn');

    function getLocation(){

        if(!navigator.geolocation){

            statusDiv.innerHTML =
                '<span class="text-danger">Browser tidak mendukung GPS.</span>';

            submitBtn.disabled = true;

            return;
        }

        loadingDiv.style.display = 'block';

        statusDiv.innerHTML = '';

        navigator.geolocation.getCurrentPosition(
            success,
            error,
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    function success(position){

        const lat = position.coords.latitude;

        const lng = position.coords.longitude;

        const gpsString = `${lat}, ${lng}`;

        gpsInput.value = gpsString;

        loadingDiv.style.display = 'none';

        statusDiv.innerHTML =
            `<span class="text-success">
                ✅ Lokasi berhasil didapatkan:
                <strong>${gpsString}</strong>
            </span>`;

        submitBtn.disabled = false;
    }

    function error(err){

        loadingDiv.style.display = 'none';

        let pesan = '';

        switch(err.code){

            case err.PERMISSION_DENIED:
                pesan = 'Izin lokasi ditolak.';
                break;

            case err.POSITION_UNAVAILABLE:
                pesan = 'Lokasi tidak tersedia.';
                break;

            case err.TIMEOUT:
                pesan = 'Permintaan lokasi timeout.';
                break;

            default:
                pesan = 'Terjadi kesalahan.';
        }

        statusDiv.innerHTML =
            `<span class="text-danger">
                ❌ ${pesan}
            </span>`;

        submitBtn.disabled = true;
    }

    ambilBtn.addEventListener('click', getLocation);

    window.addEventListener('load', getLocation);

</script>

</body>
</html>