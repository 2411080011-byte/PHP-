<?php
session_start();
if (!isset($_SESSION['username'])) {
  $_SESSION['username'] = 'Usuario';
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <title>AdminLTE v4 | Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <meta name="color-scheme" content="light dark" />
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
  <meta name="supported-color-schemes" content="light dark" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" media="print" onload="this.media='all'" crossorigin="anonymous" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'media',
      theme: {
        extend: {
          colors: {
            'brand-blue': '#0d6efd',
            'brand-green': '#20c997',
            'body-terr': '#f8fafc'
          },
          boxShadow: {
            'card': '0 6px 18px rgba(15,23,42,0.08)'
          }
        }
      }
    }
  </script>

  <style>
    .img-size-50 {
      width: 50px;
      height: 50px;
      object-fit: cover;
    }

    .user-image {
      width: 32px;
      height: 32px;
      object-fit: cover;
    }

    .dropdown-fade {
      transition: opacity .15s ease, transform .15s ease;
      transform-origin: top right;
    }

    .sidebar-scroll {
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
    }

    html {
      scroll-behavior: smooth;
    }

    button.no-focus:focus,
    a.no-focus:focus {
      outline: none !important;
      box-shadow: none !important;
    }

    #sidebar {
      transition: transform 300ms ease, width 300ms ease, flex-basis 300ms ease;
      width: 16rem;
      flex: 0 0 16rem;
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 0;
      height: 100vh;
    }

    #sidebar.collapsed {
      transform: translateX(-100%);
      width: 0 !important;
      flex: 0 0 0 !important;
      min-width: 0 !important;
      overflow: hidden !important;
      pointer-events: none;
    }

    #sidebar .sidebar-brand {
      flex-shrink: 0;
    }

    @media (max-width: 768px) {
      #sidebar {
        position: relative;
        z-index: 30;
        height: auto;
      }

      #sidebar.collapsed {
        transform: translateX(-100%);
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
      }
    }
  </style>
</head>

<body class="antialiased bg-body-terr text-gray-800 dark:bg-gray-900 dark:text-gray-100">
  <div id="app" class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="w-64 bg-gray-100 dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
      <div class="sidebar-brand p-4 flex items-center gap-3 border-b border-gray-200 dark:border-gray-700">
        <a href="./index.html" class="flex items-center gap-3">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/Tailwind_CSS_Logo.svg/1024px-Tailwind_CSS_Logo.svg.png?20230715030042" alt="AdminLTE Logo" class="w-12 h-8 opacity-90 shadow-sm" />
          <span class="text-sm font-light dark:text-gray-100">Tailwind</span>
        </a>
      </div>
      <div class="sidebar-scroll p-3 flex-1">
        <nav class="mt-3">
          <ul class="space-y-1">
            <li>
              <div class="group">
                <a href="#" class="flex items-center justify-between px-3 py-2 rounded-md bg-indigo-50 dark:bg-gray-700 text-indigo-700 dark:text-indigo-200">
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                    </svg>
                    <span class="text-sm">Dashboard</span>
                  </div>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                  </svg>
                </a>
                <ul class="mt-1 ml-4 space-y-1">
                  <li>
                    <a href="tailwind.php" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-gray-200 dark:bg-gray-700">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="4" />
                      </svg>
                      Tailwind
                    </a>
                  </li>
                  <li>
                    <a href="boostrap.php" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm hover:bg-gray-200 dark:hover:bg-gray-700">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="4" />
                      </svg>
                      Boostrap
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <a href="index.php"
                class="flex items-center gap-2 px-3 py-2 rounded-md 
            hover:bg-gray-200 dark:hover:bg-gray-700 
            text-sm text-gray-800 dark:text-gray-200 transition-colors">
                <!-- Icono de salir -->
                <svg xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.8"
                  stroke="currentColor"
                  class="h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M18 12H9m9 0-3-3m3 3-3 3" />
                </svg>
                Salir
              </a>
            </li>

          </ul>
        </nav>
      </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">
      <!-- HEADER / NAVBAR -->
      <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
              <button id="btn-sidebar-toggle-2" class="md:hidden p-2 rounded-md text-gray-600 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 no-focus" aria-label="Toggle sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
              <button id="btn-sidebar-toggle-home" class="p-2 no-focus" aria-label="Toggle sidebar (Home)">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
              <nav class="hidden md:flex items-center gap-4">
                <a href="#" class="text-sm text-gray-700 dark:text-gray-200 hover:underline">Home</a>
                <a href="#" class="text-sm text-gray-700 dark:text-gray-200 hover:underline">Contact</a>
              </nav>
            </div>

            <div class="flex items-center gap-3">
              <button id="btn-search-top" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-200 no-focus" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
              </button>

              <div class="relative" id="user-menu-wrapper">
                <button id="btn-user-menu" class="flex items-center gap-3 rounded-md p-1 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none no-focus" aria-haspopup="true" aria-expanded="false">
                  <img src="./assets/img/user2-160x160.jpg" class="user-image rounded-full shadow-sm" alt="User Image" />
                  <span class="hidden md:inline">Bienvenido <?php echo $_SESSION["username"]; ?></span>
                </button>
                <div id="user-menu-panel" class="origin-top-right absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg py-2 dropdown-fade hidden z-20">
                  <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                      <img src="./assets/img/user2-160x160.jpg" alt="User" class="w-12 h-12 rounded-full shadow-sm" />
                      <div>
                        <div class="font-semibold">Alexander Pierce - Web Developer</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Member since Nov. 2023</div>
                      </div>
                    </div>
                  </div>
                  <div class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300 grid grid-cols-3 gap-2 text-center">
                    <a href="#" class="hover:underline">Followers</a>
                    <a href="#" class="hover:underline">Sales</a>
                    <a href="#" class="hover:underline">Friends</a>
                  </div>
                  <div class="border-t border-gray-100 dark:border-gray-700 mt-2"></div>
                  <div class="px-3 py-2 flex items-center justify-between">
                    <a href="#" class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 rounded-md">Profile</a>
                    <a href="logout.php" class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 rounded-md">Salir</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <main class="flex overflow-y-auto p-6 bg-white dark:bg-gray-900">
        <div class="max-w-screen-2xl mx-auto">
          <?php include 'paneles_de_control/tailwind/tailwind.php'; ?>
        </div>
      </main>

      <footer class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-300">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
          <div class="text-right hidden sm:block">Anything you want</div>
          <div>
            <strong>Copyright &copy; 2014-2025&nbsp;
              <a href="https://adminlte.io" class="text-indigo-600 dark:text-indigo-400 hover:underline">AdminLTE.io</a>.
            </strong> All rights reserved.
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      if (!sidebar) return;
      sidebar.classList.toggle('collapsed');
      window.dispatchEvent(new Event('resize'));
    }
    document.getElementById('btn-sidebar-toggle-2')?.addEventListener('click', toggleSidebar);
    document.getElementById('btn-sidebar-toggle-home')?.addEventListener('click', function(e) {
      e.currentTarget.blur();
      toggleSidebar();
    });

    document.getElementById('btn-user-menu')?.addEventListener('click', function(e) {
      e.stopPropagation();
      const panel = document.getElementById('user-menu-panel');
      if (panel) panel.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
      if (!document.getElementById('user-menu-wrapper').contains(e.target)) {
        document.getElementById('user-menu-panel')?.classList.add('hidden');
      }
    });
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        document.getElementById('user-menu-panel')?.classList.add('hidden');
      }
    });
  </script>
</body>

</html>