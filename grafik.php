<?php

session_start();

include 'koneksi.php';

$query = "SELECT status, COUNT(*) as total 
          FROM laporan 
          GROUP BY status";

$result = $conn->query($query);

$data = [];
$labels = [];

$totalLaporan = 0;

while($row = $result->fetch_assoc()){

    $labels[] = ucfirst($row['status']);

    $data[] = $row['total'];

    $totalLaporan += $row['total'];
}

// Cek admin login
$isAdmin = isset($_SESSION['admin_logged']) 
           && $_SESSION['admin_logged'] === true;

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Grafik Status Laporan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

            background: rgba(37,99,235,0.1);

            color: #2563eb;

            padding: 10px 18px;

            border-radius: 50px;

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

            max-width: 700px;

            font-size: 18px;
        }

        /* STATS */

        .stats-card{

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            border-radius: 28px;

            padding: 35px;

            color: white;

            box-shadow: 0 15px 40px rgba(37,99,235,0.2);

            margin-bottom: 30px;

            overflow: hidden;

            position: relative;
        }

        .stats-card::before{

            content: '';

            position: absolute;

            width: 200px;
            height: 200px;

            background: rgba(255,255,255,0.08);

            border-radius: 50%;

            top: -60px;
            right: -60px;
        }

        .stats-card h2{

            font-size: 50px;

            font-weight: 800;

            margin: 10px 0;
        }

        .stats-card p{

            opacity: 0.9;

            margin: 0;
        }

        .stats-icon{

            position: absolute;

            right: 30px;
            top: 30px;

            font-size: 60px;

            opacity: 0.2;
        }

        /* CHART */

        .chart-card{

            background: rgba(255,255,255,0.92);

            backdrop-filter: blur(14px);

            border-radius: 28px;

            padding: 35px;

            box-shadow: 0 10px 40px rgba(0,0,0,0.06);

            border: 1px solid rgba(255,255,255,0.4);
        }

        .chart-title{

            font-size: 24px;

            font-weight: 700;

            color: #0f172a;

            margin-bottom: 25px;
        }

        /* BUTTON */

        .btn-custom{

            height: 54px;

            border-radius: 14px;

            padding: 0 24px;

            font-weight: 600;

            display: inline-flex;

            align-items: center;

            gap: 10px;
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

        /* RESPONSIVE */

        @media(max-width:768px){

            .hero{

                padding-top: 40px;
            }

            .hero h1{

                font-size: 34px;
            }

            .chart-card,
            .stats-card{

                padding: 22px;
            }

            .stats-card h2{

                font-size: 38px;
            }
        }

    </style>

</head>

<body>

<div class="container">

    <!-- HERO -->

    <section class="hero">

        <div class="hero-badge">

            <i class="bi bi-bar-chart-line"></i>

            Statistik Laporan Realtime

        </div>

        <h1>
            Grafik Status Laporan Banjir
        </h1>

        <p>
            Pantau perkembangan dan distribusi status laporan
            banjir secara realtime untuk mendukung transparansi
            dan proses penanganan oleh BPBD.
        </p>

    </section>

    <!-- STATS -->

    <div class="stats-card">

        <div class="stats-icon">

            <i class="bi bi-clipboard-data"></i>

        </div>

        <small>Total Laporan Masuk</small>

        <h2><?= $totalLaporan ?></h2>

        <p>
            Data laporan masyarakat yang telah tercatat dalam sistem.
        </p>

    </div>

    <!-- CHART -->

    <div class="chart-card">

        <div class="chart-title">

            <i class="bi bi-graph-up-arrow"></i>

            Statistik Penanganan Laporan

        </div>

        <canvas id="statusChart"></canvas>

    </div>

    <!-- BUTTON -->

    <div class="mt-4 d-flex flex-wrap gap-3">

        <?php if($isAdmin): ?>

            <!-- ADMIN -->

            <a href="admin/dashboard_admin.php"
               class="btn btn-dark btn-custom">

                <i class="bi bi-arrow-left"></i>

                Dashboard Admin

            </a>

        <?php else: ?>

            <!-- USER -->

            <a href="index.php"
               class="btn btn-primary btn-custom">

                <i class="bi bi-plus-circle"></i>

                Laporkan Banjir

            </a>

            <a href="cek_status.php"
               class="btn btn-info text-white btn-custom">

                <i class="bi bi-search"></i>

                Cek Status

            </a>

        <?php endif; ?>

    </div>

</div>

<script>

    const ctx = document
        .getElementById('statusChart')
        .getContext('2d');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: <?= json_encode($labels) ?>,

            datasets: [{

                label: 'Jumlah Laporan',

                data: <?= json_encode($data) ?>,

                backgroundColor: [
                    '#6b7280',
                    '#0ea5e9',
                    '#f59e0b',
                    '#10b981'
                ],

                borderRadius: 12,

                borderSkipped: false
            }]
        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    display: false
                }
            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    },

                    grid: {

                        color: 'rgba(0,0,0,0.05)'
                    }
                },

                x: {

                    grid: {

                        display: false
                    }
                }
            }
        }
    });

</script>

</body>
</html>