<?php
include '../controladores/conexion.php';
$id = $_GET['id'];
$consulta = mysqli_query($conexion, "SELECT * FROM ventas WHERE id='$id'");
$data = mysqli_fetch_assoc($consulta);

if (isset($_POST['actualizar'])) {
    $vendedor = $_POST['vendedor'];
    $direccion = $_POST['direccion'];
    $fecha = $_POST['fecha'];

    $update = mysqli_query($conexion, "UPDATE ventas SET vendedor='$vendedor', direccion='$direccion', fecha='$fecha' WHERE id='$id'");
    if ($update) {
        mysqli_query($conexion, "INSERT INTO operaciones (operacion, vendedor, fecha) VALUES ('Editar', '$vendedor', NOW())");
        echo "<script>alert('Vendedor actualizado correctamente.');window.location='../../tailwind.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar.');</script>";
    }
}
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Editar Vendedor</title>

<!-- Cargar Tailwind con dark mode habilitado -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
  };
</script>

<script src="https://unpkg.com/lucide@latest"></script>

<!-- Detectar y aplicar tema guardado -->
<script>
  // Si el tema guardado es 'dark', aplica la clase dark al HTML
  if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
</script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 flex justify-center items-center h-screen transition-colors duration-300">

<div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md transition-colors duration-300">
    <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2 text-gray-800 dark:text-gray-100">
        <i data-lucide="pencil" class="w-5 h-5 text-amber-600"></i> Editar Vendedor
    </h2>

    <form method="POST" class="space-y-4">
        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
            <input type="text" name="vendedor" value="<?= $data['vendedor'] ?>" required 
                   class="w-full border dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 
                   rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-400 transition-colors duration-300">
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
            <input type="text" name="direccion" value="<?= $data['direccion'] ?>" required 
                   class="w-full border dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 
                   rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-400 transition-colors duration-300">
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Fecha</label>
            <input type="date" name="fecha" value="<?= $data['fecha'] ?>" required 
                   class="w-full border dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 
                   rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-400 transition-colors duration-300">
        </div>

        <div class="flex justify-end gap-3">
            <a href="../../tailwind.php" 
               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-100 
               rounded-md font-semibold flex items-center gap-1 transition-colors duration-300">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Cancelar
            </a>

            <button type="submit" name="actualizar" 
                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-md font-semibold flex items-center gap-1 transition">
                <i data-lucide="save" class="w-4 h-4"></i> Guardar
            </button>
        </div>
    </form>
</div>

<script>lucide.createIcons();</script>
</body>
</html>
