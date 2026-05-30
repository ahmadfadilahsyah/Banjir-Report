<?php
session_start();
require_once '../koneksi.php';

if(!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true){
    header("Location: login_admin.php");
    exit();
}

$query = "SELECT status, COUNT(*) as total FROM laporan GROUP BY status";
$result = $conn->query($query);

$data = [];
$labels = [];
$totalSemua = 0;

while($row = $result->fetch_assoc()){

    $labels[] = ucfirst($row['status']);
    $data[] = $row['total'];

    $totalSemua += $row['total'];
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grafik Laporan - Admin BPBD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

        body{
            background: #f4f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* SIDEBAR */

        .sidebar{
            min-height: 100vh;
            background: linear-gradient(180deg, #111827, #1f2937);
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
        }

        .brand{
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand h4{
            color: white;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .brand small{
            color: #9ca3af;
        }

        .sidebar .nav-link{
            color: #d1d5db;
            padding: 14px 20px;
            margin: 6px 12px;
            border-radius: 12px;
            transition: 0.3s;
            font-weight: 500;
        }

        .sidebar .nav-link i{
            margin-right: 10px;
        }

        .sidebar .nav-link:hover{
            background: rgba(255,255,255,0.08);
            color: white;
        }

        .sidebar .nav-link.active{
            background: #2563eb;
            color: white;
        }

        /* MAIN CONTENT */

        .main-content{
            padding: 30px;
        }

        .topbar{
            background: white;
            padding: 22px 28px;
            border-radius: 20px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        .topbar h2{
            font-weight: 700;
            margin: 0;
            color: #111827;
        }

        /* STATS CARD */

        .stats-card{
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(37,99,235,0.2);
            margin-bottom: 25px;
        }

        .stats-card h3{
            font-size: 38px;
            font-weight: 700;
            margin: 10px 0;
        }

        .stats-card p{
            margin: 0;
            opacity: 0.9;
        }

        .stats-icon{
            font-size: 45px;
            opacity: 0.3;
        }

        /* CHART CARD */

        .chart-card{
            background: white;
            border-radius: 22px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        }

        .chart-title{
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #111827;
        }

        /* BUTTON */

        .btn-back{
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
        }

        /* RESPONSIVE */

        @media(max-width:768px){

            .sidebar{
                min-height: auto;
            }

            .main-content{
                padding: 15px;
            }

            .topbar{
                padding: 18px;
            }

            .chart-card{
                padding: 20px;
            }
        }

    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->

        <div class="col-md-3 col-lg-2 p-0 sidebar">

            <div class="brand">
                <h4>BPBD Kota</h4>
                <small>Sistem Penanganan Banjir</small>
            </div>

            <nav class="nav flex-column mt-3">

                <a href="dashboard_admin.php" class="nav-link">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>

                <a href="grafik_admin.php" class="nav-link active">
                    <i class="bi bi-bar-chart-line"></i>
                    Grafik Laporan
                </a>

                <a href="logout.php" class="nav-link">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>

            </nav>

        </div>

        <!-- MAIN CONTENT -->

        <div class="col-md-9 col-lg-10 main-content">

            <!-- TOPBAR -->

            <div class="topbar d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div>
                    <h2>
                        <i class="bi bi-graph-up-arrow"></i>
                        Statistik Laporan Banjir
                    </h2>
                </div>

                <span class="badge bg-primary fs-6 px-3 py-2">
                    <?= date('d M Y - H:i') ?>
                </span>

            </div>

            <!-- STATS -->

            <div class="stats-card d-flex justify-content-between align-items-center">

                <div>
                    <p>Total Seluruh Laporan</p>
                    <h3><?= $totalSemua ?></h3>
                    <small>Data laporan banjir masuk</small>
                </div>

                <div class="stats-icon">
                    <i class="bi bi-clipboard-data"></i>
                </div>

            </div>

            <!-- CHART -->

            <div class="chart-card">

                <div class="chart-title">
                    Grafik Status Penanganan
                </div>

                <canvas id="statusChart"></canvas>

            </div>

        </div>
    </div>
</div>

<script>

    const ctx = document.getElementById('statusChart');

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