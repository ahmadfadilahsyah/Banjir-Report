<?php
session_start();
require_once '../koneksi.php';

if(!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true){
    header("Location: login_admin.php");
    exit();
}

// Update status
if(isset($_GET['update_status']) && isset($_GET['id']) && isset($_GET['status'])){
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    $allowed = ['diterima','ditindaklanjuti','dikerjakan','selesai'];

    if(in_array($status, $allowed)){
        $stmt = $conn->prepare("UPDATE laporan SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
    }

    header("Location: dashboard_admin.php");
    exit();
}

// Ambil laporan
$result = $conn->query("SELECT * FROM laporan ORDER BY tanggal_laporan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin BPBD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* SIDEBAR */
        .sidebar{
            min-height: 100vh;
            background: linear-gradient(180deg, #1f2937, #111827);
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
        }

        .sidebar-header{
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-header h4{
            color: white;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .sidebar-header small{
            color: #9ca3af;
        }

        .sidebar .nav-link{
            color: #d1d5db;
            padding: 14px 22px;
            border-radius: 12px;
            margin: 6px 12px;
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

        /* CONTENT */
        .main-content{
            padding: 30px;
        }

        .topbar{
            background: white;
            padding: 20px 25px;
            border-radius: 18px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .topbar h2{
            margin: 0;
            font-weight: 700;
            color: #111827;
        }

        /* CARD */
        .dashboard-card{
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        }

        /* TABLE */
        .table{
            vertical-align: middle;
        }

        .table thead th{
            background: #111827;
            color: white;
            border: none;
            padding: 16px;
            font-size: 14px;
        }

        .table tbody tr{
            transition: 0.2s;
        }

        .table tbody tr:hover{
            background: #f9fafb;
        }

        .table td{
            padding: 16px;
        }

        /* FOTO */
        .report-img{
            width: 90px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* STATUS */
        .badge{
            padding: 8px 14px;
            font-size: 12px;
            border-radius: 30px;
        }

        /* BUTTON */
        .btn-group .btn{
            border-radius: 8px !important;
            margin: 2px;
            font-size: 12px;
        }

        .btn-map{
            margin-top: 8px;
            border-radius: 8px;
        }

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

            .dashboard-card{
                padding: 15px;
            }

            .btn-group{
                display: flex;
                flex-direction: column;
            }
        }

    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 p-0 sidebar">

            <div class="sidebar-header">
                <h4>BPBD Kota</h4>
                <small>Sistem Penanganan Banjir</small>
            </div>

            <nav class="nav flex-column mt-3">

                <a href="dashboard_admin.php" class="nav-link active">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>

                <a href="grafik_admin.php" class="nav-link">
                    <i class="bi bi-bar-chart-line"></i>
                    Grafik Laporan
                </a>

                <a href="logout.php" class="nav-link">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>

            </nav>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9 col-lg-10 main-content">

            <!-- TOPBAR -->
            <div class="topbar d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div>
                    <h2>
                        <i class="bi bi-water"></i>
                        Dashboard Laporan Banjir
                    </h2>
                </div>

                <span class="badge bg-primary">
                    <?= date('d M Y - H:i') ?>
                </span>

            </div>

            <!-- CARD -->
            <div class="dashboard-card">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelapor</th>
                                <th>Lokasi</th>
                                <th>Foto</th>
                                <th>GPS</th>
                                <th>Status</th>
                                <th width="250">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php while($row = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <strong>#<?= $row['id'] ?></strong>
                                </td>

                                <td>
                                    <strong><?= htmlspecialchars($row['nama_pelapor']) ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($row['email']) ?>
                                    </small>
                                </td>

                                <td>
                                    <?= htmlspecialchars($row['jalan']) ?>
                                </td>

                                <td>
                                    <img 
                                        src="../uploads/<?= $row['foto'] ?>" 
                                        class="report-img"
                                    >
                                </td>

                                <td>
                                    <small>
                                        <?= $row['gps_location'] ?>
                                    </small>

                                    <br>

                                    <a 
                                        href="https://www.google.com/maps?q=<?= urlencode($row['gps_location']) ?>" 
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary btn-map"
                                    >
                                        <i class="bi bi-geo-alt"></i>
                                        Lihat Peta
                                    </a>
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

                                    <div class="btn-group" role="group">

                                        <a href="?update_status&id=<?= $row['id'] ?>&status=diterima"
                                           class="btn btn-secondary btn-sm">
                                            Diterima
                                        </a>

                                        <a href="?update_status&id=<?= $row['id'] ?>&status=ditindaklanjuti"
                                           class="btn btn-info btn-sm text-white">
                                            Tindak
                                        </a>

                                        <a href="?update_status&id=<?= $row['id'] ?>&status=dikerjakan"
                                           class="btn btn-warning btn-sm">
                                            Kerjakan
                                        </a>

                                        <a href="?update_status&id=<?= $row['id'] ?>&status=selesai"
                                           class="btn btn-success btn-sm">
                                            Selesai
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>