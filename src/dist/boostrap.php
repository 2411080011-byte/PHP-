<?php
session_start();
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>AdminLTE v4 | Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="color-scheme" content="dark">
  <meta name="theme-color" content="#1a1a1a">

  <!-- Fonts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">

  <!-- Plugins -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./css/adminlte.css">

  <!-- Dark Elegant Bootstrap Custom -->
  <style>
    body {
      background-color: #121212;
      color: #e0e0e0;
      font-family: 'Source Sans 3', sans-serif;
    }

    /* Header & Footer */
    .app-header,
    .app-footer {
      background-color: #1f1f1f;
      color: #f5f5f5;
    }

    .fw-light {
      color: white !important;
    }

    /* Navbar links */
    .navbar-nav .nav-link {
      color: #ffffff;
    }

    .navbar-nav .nav-link:hover {
      color: #d3d3d3ff;
    }

    /* Sidebar principal y sublinks */
    .sidebar-menu .nav-link {
      color: #ffffff !important;
      /* Fuerza letras blancas */
      border-radius: 0;
      padding: 0.65rem 1rem;
      transition: all 0.2s;
    }

    .sidebar-menu .nav-link.active {
      background-color: #2e2e2e !important;
    }

    .sidebar-menu .nav-link:hover {
      background-color: #333333 !important;
    }

    .sidebar-brand {
      padding: 28px 1rem;
    }


    /* Sub-links (treeview) */
    .nav-treeview .nav-link {
      padding-left: 2.5rem;
      color: #ffffff !important;
      /* Sub-links visibles */
      border-bottom: 1px solid #333333;
    }

    /* Íconos de la sidebar */
    .sidebar-menu .nav-icon {
      color: #ffffff !important;
      /* Hace visibles los íconos */
    }

    /* Dropdowns */
    .dropdown-menu {
      background-color: #2a2a2a;
      color: #ffffff;
      border-radius: 6px;
    }

    .dropdown-menu a {
      color: #ffffff;
    }

    .dropdown-menu a:hover {
      background-color: #3a3a3a;
    }

    /* Main content */
    .app-content {
      background-color: #1e1e1e;
      padding: 20px;
      border-radius: 12px;
      min-height: calc(100vh - 120px);
    }

    /* User image */
    .user-image {
      border: 2px solid #ffffff33;
    }

    /* Footer links */
    .app-footer a {
      color: #00bfff;
    }

    .app-footer a:hover {
      color: #ffffff;
      text-decoration: none;
    }

    /* Scrollbars */
    .os-scrollbar-horizontal,
    .os-scrollbar-vertical {
      background: #2a2a2a !important;
    }

    .os-scrollbar-handle {
      background: #00bfff !important;
    }
  </style>
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open">

  <div class="app-wrapper">

    <!-- Header -->
    <nav class="app-header navbar navbar-expand">
      <div class="container-fluid">

        <!-- Navbar Start Links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list" style="color: white"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
        </ul>

        <!-- Navbar End Links / User -->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
              <img src="./assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image">
              <span class="d-none d-md-inline">Bienvenido <?php echo $_SESSION["username"]; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
              <li class="user-header text-bg-primary">
                <img src="./assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image">
                <p>Alexander Pierce - Web Developer<br><small>Member since Nov. 2023</small></p>
              </li>
              <li class="user-footer d-flex justify-content-between">
                <a href="index.php" class="btn btn-outline-light btn-flat">Profile</a>
                <a href="logout.php" class="btn btn-outline-light btn-flat">Salir</a>
              </li>
            </ul>
          </li>
        </ul>

      </div>
    </nav>

    <!-- Sidebar -->
    <aside class="app-sidebar shadow">
      <div class="sidebar-brand">
        <a href="./index.html" class="brand-link">
          <img src="https://www.marefa.org/w/images/thumb/b/b2/Bootstrap_logo.svg/800px-Bootstrap_logo.svg.png" class="brand-image opacity-75 shadow" alt="AdminLTE Logo">
          <span class="brand-text fw-light">Boostrap</span>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <nav class="mt-3">
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard <i class="nav-arrow bi bi-chevron-right" style="top: 12px"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="tailwind.php" class="nav-link"><i class="nav-icon bi"></i> Tailwind</a></li>
                <li class="nav-item"><a href="boostrap.php" class="nav-link active"><i class="nav-icon bi"></i> Boostrap</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="index.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-box-arrow-right me-2"></i> Salir
              </a>
            </li>

          </ul>
        </nav>
      </div>
    </aside>

    <!-- Main -->
    <main class="app-main">
      <div class="app-content">
        <?php include 'paneles_de_control/boostrap/boostrap.php'; ?>
      </div>
    </main>

    <!-- Footer -->
    <footer class="app-footer">
      <div class="float-end d-none d-sm-inline">Anything you want</div>
      <strong>&copy; 2014-2025 <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
  <script src="./js/adminlte.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector('.sidebar-wrapper');
      if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: 'os-theme-dark',
            autoHide: 'leave',
            clickScroll: true
          }
        });
      }
    });
  </script>

</body>

</html>