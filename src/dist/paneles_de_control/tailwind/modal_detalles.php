<?php
include '../controladores/conexion.php';

// Obtener el ID desde la URL
$id = $_GET['id'];

// Consultar los datos del vendedor
$consulta = mysqli_query($conexion, "SELECT * FROM ventas WHERE id='$id'");
$data = mysqli_fetch_assoc($consulta);
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Detalles del Vendedor</title>

  <!-- Tailwind con dark mode -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' };
  </script>

  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

  <!-- Detectar tema guardado -->
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 flex justify-center items-center min-h-screen transition-colors duration-300">

  <div id="detalleVendedor" class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md transition-colors duration-300">
    <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2 text-gray-800 dark:text-gray-100">
      <i data-lucide="user-circle-2" class="w-6 h-6 text-blue-600"></i>
      Detalles del Vendedor
    </h2>

    <div class="space-y-4 text-gray-700 dark:text-gray-300">
      <p class="flex items-center gap-2">
        <i data-lucide="hash" class="w-5 h-5 text-gray-600 dark:text-gray-400"></i> 
        <span class="font-semibold">ID:</span> <?= htmlspecialchars($data['id']) ?>
      </p>
      <p class="flex items-center gap-2">
        <i data-lucide="user" class="w-5 h-5 text-gray-600 dark:text-gray-400"></i> 
        <span class="font-semibold">Vendedor:</span> <?= htmlspecialchars($data['vendedor']) ?>
      </p>
      <p class="flex items-center gap-2">
        <i data-lucide="map-pin" class="w-5 h-5 text-gray-600 dark:text-gray-400"></i> 
        <span class="font-semibold">Dirección:</span> <?= htmlspecialchars($data['direccion']) ?>
      </p>
      <p class="flex items-center gap-2">
        <i data-lucide="calendar-days" class="w-5 h-5 text-gray-600 dark:text-gray-400"></i> 
        <span class="font-semibold">Fecha:</span> <?= htmlspecialchars($data['fecha']) ?>
      </p>
    </div>

    <div class="flex justify-between mt-8">
      <a href="../../tailwind.php" 
         class="px-4 py-2 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 
         text-white rounded-md font-semibold flex items-center gap-2 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Regresar
      </a>

      <button onclick="descargarPDF()" 
              class="px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 
              text-white rounded-md font-semibold flex items-center gap-2 transition">
        <i data-lucide="download" class="w-4 h-4"></i> Descargar PDF
      </button>
    </div>
  </div>

  <script>
    lucide.createIcons();

    function descargarPDF() {
      const elemento = document.getElementById('detalleVendedor');
      const opciones = {
        margin: 10,
        filename: 'detalle_vendedor_<?= htmlspecialchars($data['vendedor']) ?>.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
      };
      html2pdf().from(elemento).set(opciones).save();
    }
  </script>

</body>
</html>
