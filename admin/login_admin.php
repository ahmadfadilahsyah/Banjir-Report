<?php
session_start();
require_once '../koneksi.php';

if(isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true){
    header("Location: dashboard_admin.php");
    exit();
}

$error = '';

// Generate captcha
if(!isset($_SESSION['captcha_code'])){
    $_SESSION['captcha_code'] = rand(1000, 9999);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $user_captcha = trim($_POST['captcha'] ?? '');

    // Validasi captcha
    if($user_captcha != $_SESSION['captcha_code']){

        $error = "Kode captcha salah!";
        $_SESSION['captcha_code'] = rand(1000, 9999);

    }else{

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if($admin && password_verify($password, $admin['password'])){

            $_SESSION['admin_logged'] = true;

            session_regenerate_id(true);

            header("Location: dashboard_admin.php");
            exit();

        }else{

            $error = "Username atau password salah!";
            $_SESSION['captcha_code'] = rand(1000, 9999);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin BPBD</title>

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

            min-height: 100vh;

            background:
                linear-gradient(
                    135deg,
                    #0f172a,
                    #1e293b,
                    #2563eb
                );

            font-family: 'Segoe UI', sans-serif;

            overflow-x: hidden;
        }

        .login-wrapper{

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 20px;
        }

        .login-card{

            width: 100%;
            max-width: 1100px;

            background: rgba(255,255,255,0.08);

            backdrop-filter: blur(15px);

            border: 1px solid rgba(255,255,255,0.1);

            border-radius: 30px;

            overflow: hidden;

            box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        }

        .left-panel{

            background:
                linear-gradient(
                    180deg,
                    rgba(37,99,235,0.95),
                    rgba(15,23,42,0.95)
                );

            color: white;

            padding: 60px;

            height: 100%;
        }

        .left-panel h1{

            font-size: 42px;

            font-weight: 800;

            margin-bottom: 20px;
        }

        .left-panel p{

            opacity: 0.9;

            line-height: 1.8;
        }

        .left-icon{

            width: 90px;
            height: 90px;

            border-radius: 25px;

            background: rgba(255,255,255,0.15);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 40px;

            margin-bottom: 30px;
        }

        .right-panel{

            background: white;

            padding: 50px;
        }

        .form-title{

            font-size: 30px;

            font-weight: 700;

            color: #111827;

            margin-bottom: 10px;
        }

        .form-subtitle{

            color: #6b7280;

            margin-bottom: 35px;
        }

        .form-control{

            height: 55px;

            border-radius: 14px;

            border: 1px solid #d1d5db;

            padding-left: 45px;

            font-size: 15px;

            transition: 0.3s;
        }

        .form-control:focus{

            border-color: #2563eb;

            box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
        }

        .input-group-custom{

            position: relative;
        }

        .input-group-custom i{

            position: absolute;

            top: 17px;
            left: 16px;

            color: #6b7280;

            z-index: 10;
        }

        .captcha-box{

            background: linear-gradient(
                135deg,
                #111827,
                #1e293b
            );

            color: white;

            padding: 14px;

            border-radius: 15px;

            text-align: center;

            font-size: 30px;

            letter-spacing: 8px;

            font-weight: bold;

            font-family: monospace;

            user-select: none;

            margin-bottom: 12px;
        }

        .btn-login{

            height: 55px;

            border-radius: 14px;

            background: linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            border: none;

            font-weight: 600;

            font-size: 16px;

            transition: 0.3s;
        }

        .btn-login:hover{

            transform: translateY(-2px);

            box-shadow: 0 10px 20px rgba(37,99,235,0.3);
        }

        .alert{

            border-radius: 14px;
        }

        .login-footer{

            margin-top: 25px;

            text-align: center;

            color: #6b7280;

            font-size: 14px;
        }

        .login-footer strong{

            color: #111827;
        }

        @media(max-width: 992px){

            .left-panel{
                display: none;
            }

            .right-panel{
                padding: 35px 25px;
            }
        }

    </style>

</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <div class="row g-0">

            <!-- LEFT SIDE -->

            <div class="col-lg-6">

                <div class="left-panel d-flex flex-column justify-content-center">

                    <div class="left-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>

                    <h1>BPBD Admin Panel</h1>

                    <p>
                        Sistem monitoring dan penanganan laporan banjir
                        berbasis digital untuk mendukung respon cepat,
                        pengelolaan data, dan pemantauan laporan secara realtime.
                    </p>

                </div>

            </div>

            <!-- RIGHT SIDE -->

            <div class="col-lg-6">

                <div class="right-panel">

                    <div class="form-title">
                        Login Administrator
                    </div>

                    <div class="form-subtitle">
                        Masukkan akun administrator untuk melanjutkan.
                    </div>

                    <?php if($error): ?>

                        <div class="alert alert-danger">

                            <i class="bi bi-exclamation-circle"></i>
                            <?= htmlspecialchars($error) ?>

                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <!-- USERNAME -->

                        <div class="mb-3 input-group-custom">

                            <i class="bi bi-person"></i>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                placeholder="Masukkan username"
                                required
                                autofocus
                            >

                        </div>

                        <!-- PASSWORD -->

                        <div class="mb-3 input-group-custom">

                            <i class="bi bi-lock"></i>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                            >

                        </div>

                        <!-- CAPTCHA -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Verifikasi Captcha
                            </label>

                            <div class="captcha-box">
                                <?= $_SESSION['captcha_code'] ?>
                            </div>

                            <input
                                type="text"
                                name="captcha"
                                class="form-control"
                                placeholder="Masukkan kode captcha"
                                required
                                maxlength="4"
                            >

                        </div>

                        <!-- BUTTON -->

                        <button type="submit"
                                class="btn btn-primary btn-login w-100">

                            <i class="bi bi-box-arrow-in-right"></i>
                            Login Sekarang

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>