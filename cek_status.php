<?php

include 'koneksi.php';

$laporan = [];

if(isset($_POST['cek'])){

    $email = trim($_POST['email']);

    $sql = "SELECT * FROM laporan 
            WHERE email = ? 
            ORDER BY tanggal_laporan DESC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $laporan = $result->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cek Status Laporan</title>

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

            min-height: 100vh;
        }

        /* HERO */

        .hero{

            padding: 70px 0 40px;
        }

        .hero-badge{

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 10px 16px;

            border-radius: 50px;

            background: rgba(37,99,235,0.1);

            color: #2563eb;

            font-weight: 600;

            margin-bottom: 20px;
        }

        .hero h1{

            font-size: 48px;

            font-weight: 800;

            color: #0f172a;

            margin-bottom: 18px;
        }

        .hero p{

            color: #64748b;

            line-height: 1.8;

            max-width: 650px;

            font-size: 18px;
        }

        /* CARD */

        .main-card{

            background: rgba(255,255,255,0.92);

            backdrop-filter: blur(14px);

            border-radius: 28px;

            padding: 35px;

            box-shadow: 0 10px 40px rgba(0,0,0,0.06);

            border: 1px solid rgba(255,255,255,0.4);
        }

        /* FORM */

        .form-label{

            font-weight: 600;

            margin-bottom: 10px;

            color: #111827;
        }

        .form-control{

            height: 58px;

            border-radius: 16px;

            border: 1px solid #d1d5db;

            padding: 14px 18px;

            transition: 0.3s;
        }

        .form-control:focus{

            border-color: #2563eb;

            box-shadow: 0 0 0 4px rgba(37,99,235,0.12);
        }

        /* BUTTON */

        .btn-custom{

            height: 54px;

            border-radius: 14px;

            padding: 0 22px;

            font-weight: 600;
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

        /* TABLE */

        .table-wrapper{

            margin-top: 35px;
        }

        .table{

            vertical-align: middle;
        }

        .table thead th{

            background: #0f172a;

            color: white;

            border: none;

            padding: 18px;

            font-size: 14px;
        }

        .table tbody tr{

            transition: 0.3s;
        }

        .table tbody tr:hover{

            background: #f8fafc;
        }

        .table td{

            padding: 18px;
        }

        /* FOTO */

        .report-image{

            width: 95px;

            height: 75px;

            object-fit: cover;

            border-radius: 14px;

            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        /* STATUS */

        .badge{

            padding: 10px 16px;

            border-radius: 30px;

            font-size: 12px;

            font-weight: 600;
        }

        /* EMPTY STATE */

        .empty-state{

            text-align: center;

            padding: 50px 20px;
        }

        .empty-state i{

            font-size: 70px;

            color: #cbd5e1;

            margin-bottom: 20px;
        }

        .empty-state h4{

            color: #0f172a;

            font-weight: 700;

            margin-bottom: 10px;
        }

        .empty-state p{

            color: #64748b;
        }

        /* RESPONSIVE */

        @media(max-width:768px){

            .hero{

                padding-top: 40px;
            }

            .hero h1{

                font-size: 34px;
            }

            .main-card{

                padding: 22px;
            }
        }

    </style>

</head>

<body>

<div class="container">

    <!-- HERO -->

    <section class="hero">

        <div class="hero-badge">

            <i class="bi bi-search"></i>

            Tracking Laporan Realtime

        </div>

        <h1>
            Cek Status Laporan Banjir Anda
        </h1>

        <p>
            Masukkan email pelapor untuk melihat progres
            penanganan laporan banjir secara realtime
            oleh tim BPBD.
        </p>

    </section>

    <!-- CARD -->

    <div class="main-card">

        <!-- FORM -->

        <form method="POST">

            <div class="row g-3 align-items-end">

                <div class="col-lg-9">

                    <label class="form-label">
                        Email Pelapor
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Masukkan email yang digunakan saat pelaporan"
                           required>

                </div>

                <div class="col-lg-3 d-grid">

                    <button type="submit"
                            name="cek"
                            class="btn btn-primary btn-custom">

                        <i class="bi bi-search"></i>

                        Cek Status

                    </button>

                </div>

            </div>

        </form>

        <!-- RESULT -->

        <?php if(isset($_POST['cek'])): ?>

            <div class="table-wrapper">

                <?php if(count($laporan) > 0): ?>

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>

                                    <th>ID</th>
                                    <th>Lokasi</th>
                                    <th>Foto</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>

                                </tr>

                            </thead>

                            <tbody>

                            <?php foreach($laporan as $row): ?>

                                <tr>

                                    <td>

                                        <strong>
                                            #<?= $row['id'] ?>
                                        </strong>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($row['jalan']) ?>

                                    </td>

                                    <td>

                                        <img src="uploads/<?= $row['foto'] ?>"
                                             class="report-image">

                                    </td>

                                    <td>

                                        <?php

                                            $status = $row['status'];

                                            $badge = '';

                                            if($status == 'diterima'){
                                                $badge = 'secondary';
                                            }
                                            elseif($status == 'ditindaklanjuti'){
                                                $badge = 'info';
                                            }
                                            elseif($status == 'dikerjakan'){
                                                $badge = 'warning';
                                            }
                                            else{
                                                $badge = 'success';
                                            }

                                        ?>

                                        <span class="badge bg-<?= $badge ?>">

                                            <?= ucfirst($status) ?>

                                        </span>

                                    </td>

                                    <td>

                                        <?= date(
                                            'd M Y - H:i',
                                            strtotime($row['tanggal_laporan'])
                                        ) ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php else: ?>

                    <!-- EMPTY -->

                    <div class="empty-state">

                        <i class="bi bi-inbox"></i>

                        <h4>
                            Data Tidak Ditemukan
                        </h4>

                        <p>
                            Tidak ada laporan yang terdaftar
                            menggunakan email tersebut.
                        </p>

                    </div>

                <?php endif; ?>

            </div>

        <?php endif; ?>

        <!-- BUTTON -->

        <div class="mt-4">

            <a href="index.php"
               class="btn btn-dark btn-custom">

                <i class="bi bi-arrow-left"></i>

                Kembali ke Beranda

            </a>

        </div>

    </div>

</div>

</body>
</html>