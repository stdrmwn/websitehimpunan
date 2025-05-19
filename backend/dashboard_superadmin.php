<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$stmt = $conn->prepare("SELECT email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $role);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Super Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #1e1e2f;
            padding-top: 1rem;
            color: white;
            position: fixed;
            width: 240px;
            top: 0;
            left: 0;
            z-index: 1050;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar h4 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 2rem;
        }
        .sidebar a {
            color: #cbd3da;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover,
        .sidebar a.bg-primary {
            background-color: #0d6efd;
            color: white;
        }
        .content {
            margin-left: 240px;
            padding: 2rem;
            transition: margin-left 0.3s ease-in-out;
        }
        .navbar {
            background-color: #2c3e50;
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .navbar h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        .profile-icon {
            width: 40px;
            height: 40px;
            background-color: #3498db;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            position: relative;
        }
        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            border-radius: 8px;
            overflow: hidden;
            z-index: 100;
        }
        .dropdown a {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
        }
        .dropdown a:hover {
            background-color: #f0f0f0;
        }
        .profile-container {
            position: relative;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 700px;
            margin: 2rem auto;
            text-align: center;
        }
        .close-sidebar {
            display: none;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
            .mobile-toggle {
                display: inline-block;
            }
            .close-sidebar {
                display: block;
                text-align: right;
                padding: 0.5rem 1rem;
                font-size: 2rem;
                cursor: pointer;
                color: #fff;
            }
        }
    </style>
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("show");
        }

        function toggleDropdown() {
            const dropdown = document.getElementById("profileDropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        window.onclick = function(event) {
            if (!event.target.closest('.profile-container')) {
                const dropdown = document.getElementById("profileDropdown");
                if (dropdown && dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                }
            }
        }
    </script>
</head>
<body>

<!-- Toggle Button (Mobile Only) -->
<div class="d-md-none p-2 bg-white shadow-sm">
    <button class="btn btn-outline-dark mobile-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i> Menu
    </button>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="close-sidebar d-md-none" onclick="toggleSidebar()">×</div>
    <h4>Super Admin</h4>
    <a href="dashboard_superadmin.php" class="bg-primary"><i class="bi bi-house-door-fill"></i> Home Page</a>
    <a href="kelolauser.php"><i class="bi bi-people-fill"></i> Kelola User</a>
    <a href="logout.php" style="color: #ff9999;">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

<!-- Navbar -->
<div class="navbar">
    <h1>Super Admin</h1>
    <div class="profile-container">
        <div class="profile-icon" onclick="toggleDropdown()">
            <?= strtoupper(substr($email, 0, 1)) ?>
        </div>
        <div class="dropdown" id="profileDropdown">
            <a href="edit_profile.php">Edit Profil</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<!-- Konten -->
<div class="content">
    <div class="card">
        <h2>Selamat Datang, <?= htmlspecialchars($email) ?>!</h2>
        <p>Anda login sebagai <strong>Super Admin</strong>.</p>
        <p>Gunakan sidebar di sebelah kiri untuk mengakses fitur Super Admin seperti mengelola user.</p>
    </div>
</div>

</body>
</html>
