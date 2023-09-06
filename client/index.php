<?php
  $base_url = 'http://localhost/sharing-vision-test/client/';

  $request  = $_SERVER['REQUEST_URI'];
  $pageDir  = '/pages/';

  $mod = isset($_GET['mod']) ? $_GET['mod'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <base href="<?= $base_url ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sharing Vision Test</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="assets/styles/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>

<body>

  <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="dashboard" class="brand"><i class='bx bxs-smile icon'></i> SV-Test</a>
    <ul class="side-menu">
      <li><a href="dashboard" class="<?= $mod == '' || $mod == 'dashboard' ? 'active' : '' ?>"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>
      <li class="divider" data-text="main">Main</li>
      <li><a href="posts" class="<?= $mod == 'posts' ? 'active' : '' ?>"><i class='bx bxs-notepad icon'></i> Posts</a></li>
    </ul>
  </section>
  <!-- SIDEBAR -->

  <!-- NAVBAR -->
  <section id="content">
    <!-- NAVBAR -->
    <nav>
      <i class='bx bx-menu toggle-sidebar'></i>
      <div class="profile">
        <img
          src="assets/images/hadi.png"
          alt="">
        <ul class="profile-link">
          <li><a href="#"><i class='bx bxs-user-circle icon'></i> Profile</a></li>
          <li><a href="#"><i class='bx bxs-cog'></i> Settings</a></li>
          <li><a href="#"><i class='bx bxs-log-out-circle'></i> Logout</a></li>
        </ul>
      </div>
    </nav>
    <!-- NAVBAR -->

    <!-- MAIN -->
    <main>
      <h1 class="title"><?= $mod != '' ? ucwords($mod) : 'Dashboard' ?></h1>
      <ul class="breadcrumbs">
        <li><a href="#">Home</a></li>
        <li class="divider"</li>
          <li><a href="#" class="active"><?= $mod != '' ? ucwords($mod) : 'Dashboard' ?></a></li>
      </ul>
      <div class="info-data">
        <?php
          switch ($mod) {
            case '':
            case 'dashboard':
              require __DIR__ . $pageDir . 'dashboard/index.php';
              break;

            case 'posts':
              require __DIR__ . $pageDir . 'posts/index.php';
              break;
            
            default:
              http_response_code(404);
              break;
          }
        ?>
      </div>
    </main>
    <!-- MAIN -->
  </section>
  <!-- NAVBAR -->

  <script src="assets/styles/script.js"></script>
</body>
