<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed_pw, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_pw)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: dashboard_superadmin.php");
            }
            exit;
        }
    }

    $error = "Email atau password salah.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | HIMSI Pradita</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1c2b36, #3498db);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .login-box {
            background-color: #ffffff;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2c3e50;
        }

        .login-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .login-icon img {
            width: 60px;
            height: 60px;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        button {
            width: 100%;
            padding: 0.9rem;
            background-color: #3498db;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }

        .footer-text {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #666;
        }

        @media (max-width: 480px) {
            .login-box {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-icon">
        <img src="https://img.icons8.com/ios-filled/100/3498db/lock-2.png" alt="Login Icon">
    </div>

    <h2>Login Admin</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="email">Email Admin</label>
            <input type="email" name="email" id="email" required autocomplete="email">
        </div>

        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" id="password" required autocomplete="current-password">
        </div>

        <button type="submit">Masuk</button>
    </form>

    <div class="footer-text">
        Hak Cipta © <?= date('Y') ?> HIMSI Universitas Pradita
    </div>
</div>

</body>
</html>
