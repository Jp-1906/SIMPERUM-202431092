<?php
session_start();
include 'config/koneksi.php';

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn,"
        SELECT * FROM users
        WHERE email='$email'
        AND password='$password'
    ");

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        if($data['role'] == 'admin'){
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/dashboard.php");
        }

        exit;

    } else {
        $error = "Email atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIMPERUM</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f8fafc;
            font-family: inherit;
            padding: 16px;
            box-sizing: border-box;
        }

        .login-box {
            width: 100%;
            max-width: 360px;
            background: white;
            padding: 35px 30px;
            border-radius: 18px;
            border-top: 4px solid #d4af37;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            animation: fadeIn 0.6s ease-in-out;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin: 0 0 5px 0;
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #64748b;
            margin-bottom: 24px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        .error {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fee2e2;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            text-align: center;
            margin-bottom: 16px;
            font-weight: 500;
        }

        button {
            width: 100%;
            margin-top: 8px;
            padding: 11px !important;
            font-size: 14px !important;
            box-sizing: border-box;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #64748b;
        }

        .register-link a {
            color: #b89322;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Penyesuaian responsif layar kecil */
        @media (max-width: 480px) {
            .login-box {
                padding: 24px 16px;
            }
            h2 {
                font-size: 24px;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>SIMPERUM</h2>
    <div class="subtitle">Real Estate Management System</div>

    <?php if(isset($error)) { ?>
        <div class="error"><?= $error; ?></div>
    <?php } ?>

    <form method="POST">

        <label>Email Anda</label>
        <input type="email" name="email" placeholder="contoh@email.com" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>

        <button class="btn" type="submit" name="login">
            Masuk ke Sistem
        </button>

    </form>

    <div class="register-link">
        Belum memiliki akun? <a href="register.php">Daftar Sekarang</a>
    </div>

</div>

</body>
</html>