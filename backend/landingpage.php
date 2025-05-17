<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin Himpunan</title>

  <!-- Boxicons -->
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #f4f6f9;
      display: flex;
    }

    #sidebar {
      position: fixed;
      left: 0;
      top: 0;
      height: 100vh;
      width: 260px;
      background-color: #1e293b; /* Dark navy */
      padding-top: 30px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
      transition: 0.3s;
    }

    #sidebar .brand {
      font-size: 22px;
      color: #ffffff;
      text-align: center;
      display: block;
      margin-bottom: 30px;
      font-weight: 600;
      letter-spacing: 1px;
    }

    #sidebar .side-menu {
      list-style: none;
      padding: 0;
    }

    #sidebar .side-menu li {
      margin-bottom: 15px;
    }

    #sidebar .side-menu li a {
      display: flex;
      align-items: center;
      color: #cbd5e1;
      text-decoration: none;
      padding: 12px 20px;
      border-radius: 8px;
      transition: background-color 0.2s;
    }

    #sidebar .side-menu li a i {
      font-size: 20px;
      margin-right: 12px;
    }

    #sidebar .side-menu li.active a,
    #sidebar .side-menu li a:hover {
      background-color: #3b82f6;
      color: #ffffff;
    }

    #sidebar .side-menu li.active a i,
    #sidebar .side-menu li a:hover i {
      color: #ffffff;
    }

    #sidebar .side-menu li.logout a {
      color: #ef4444;
      font-weight: bold;
    }

    @media (max-width: 768px) {
      #sidebar {
        width: 200px;
      }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="#" class="brand">
      Admin Himpunan
    </a>
    <ul class="side-menu top">
      <li class="active">
        <a href="#">
          <i class='bx bxs-dashboard'></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="profilhimpunan.php">
          <i class='bx bxs-bank'></i>
          <span>Profil Himpunan</span>
        </a>
      </li>
      <li>
        <a href="divisihimpunan.php">
          <i class='bx bxs-network-chart'></i>
          <span>Divisi Himpunan</span>
        </a>
      </li>
      <li>
        <a href="dashboardkabinet.php">
          <i class='bx bxs-user-badge'></i>
          <span>Profil Kabinet</span>
        </a>
      </li>
      <li>
        <a href="faq.php">
          <i class='bx bxs-help-circle'></i>
          <span>FAQ</span>
        </a>
      </li>
      <li>
        <a href="inputvisimisi.php">
          <i class='bx bxs-bullseye'></i>
          <span>Visi & Misi</span>
        </a>
      </li>
      <li class="logout">
        <a href="signout.php">
          <i class='bx bx-log-out'></i>
          <span>Keluar</span>
        </a>
      </li>
    </ul>
  </section>

</body>
</html>
