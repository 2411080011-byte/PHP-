<?php
include '../controladores/conexion.php';
$id = $_GET['id'];
$consulta = mysqli_query($conexion, "SELECT * FROM ventas WHERE id='$id'");
$data = mysqli_fetch_assoc($consulta);

if (isset($_POST['eliminar'])) {
    $delete = mysqli_query($conexion, "DELETE FROM ventas WHERE id='$id'");
    if ($delete) {
        mysqli_query($conexion, "INSERT INTO operaciones (operacion, vendedor, fecha) VALUES ('Eliminar', '{$data['vendedor']}', NOW())");
        echo "<script>alert('Vendedor eliminado correctamente.');window.location='tailwind.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar vendedor.');</script>";
    }
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Eliminar Vendedor</title>

<!-- ⚡️ El tema debe aplicarse ANTES de cargar Tailwind -->
<script>
  (function() {
    const theme = localStorage.getItem("theme");
    if (theme === "dark") {
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }
  })();
</script>

<!-- Tailwind y Lucide -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<!-- Configuración de Tailwind para dark mode -->
<script>
  tailwind.config = {
    darkMode: 'class'
  }
</script>

<style>
  body, div, input, button, a {
    transition: all 0.3s ease;
  }
</style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 flex justify-center items-center h-screen">

<div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md">
    <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2 text-rose-700 dark:text-rose-400">
        <i data-lucide="trash-2" class="w-5 h-5"></i> Eliminar Vendedor
    </h2>

    <p class="text-gray-700 dark:text-gray-300 mb-6">
        ¿Estás seguro de que deseas eliminar al vendedor 
        <span class="font-semibold text-rose-700 dark:text-rose-400">
            "<?= htmlspecialchars($data['vendedor']) ?>"
        </span>?
    </p>

    <form method="POST" class="flex justify-end gap-3">
        <a href="tailwind.php" 
           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 
                  dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-100 
                  rounded-md font-semibold flex items-center gap-1 transition">
            <i data-lucide="x" class="w-4 h-4"></i> Cancelar
        </a>

        <button type="submit" name="eliminar" 
                class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white 
                       rounded-md font-semibold flex items-center gap-1 transition">
            <i data-lucide="check" class="w-4 h-4"></i> Confirmar
        </button>
    </form>
</div>

<script>
  lucide.createIcons();

  // Detecta si el tema cambia desde otra pestaña
  window.addEventListener("storage", () => {
    if (localStorage.getItem("theme") === "dark") {
      document.documentElement.classList.add("dark");
    } else {
      document.documentElement.classList.remove("dark");
    }
  });
</script>

</body>
</html>
