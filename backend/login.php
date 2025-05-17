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
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #fff;
            padding: 2.5rem 3rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: #555;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: #3498db;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 8px;
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

        .bottom-text {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .bottom-text a {
            color: #3498db;
            text-decoration: none;
        }

        .bottom-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login Akun</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required autocomplete="email">
        </div>

        <div class="form-group">
            <label for="password">Kata Sandi:</label>
            <input type="password" name="password" id="password" required autocomplete="current-password">
        </div>

        <button type="submit">Masuk</button>
    </form>

    <div class="bottom-text">
        Belum punya akun? <a href="signup.php">Sign up sekarang</a>
    </div>
</div>

</body>
</html>
