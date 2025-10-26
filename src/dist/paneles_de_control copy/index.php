<?php
session_start();

// Credenciales válidas (usuario => contraseña)
$usuarios = [
    "admin" => "admin123",
    "user" => "user123"
];

// Destinos válidos
$destinos = [
    "tailwind" => "tailwind/tailwind.php",
    "boostrap" => "boostrap/boostrap.php"
];

$error = "";

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = trim($_POST['clave'] ?? '');
    $destino = trim($_POST['destino'] ?? '');

    if (!isset($usuarios[$usuario]) || $usuarios[$usuario] !== $clave) {
        $error = "Usuario o contraseña incorrecta.";
    } elseif (!isset($destinos[$destino])) {
        $error = "Destino inválido. Solo tailwind o boostrap.";
    } else {
        header("Location: " . $destinos[$destino]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Profesional</title>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

    <!-- 🔹 Detectar tema antes de cargar Tailwind -->
    <script>
        (function() {
            const temaGuardado = localStorage.getItem('theme');
            if (temaGuardado === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.style.backgroundColor = '#111827'; // gris oscuro
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.backgroundColor = '#f3f4f6'; // gris claro
            }
        })();
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        #darkModeBtn{
            position: absolute;
            top: 0;
            right: 0;
            margin: 25px;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300 relative">

    <!-- Botón de modo oscuro -->
    <button id="darkModeBtn"
        class="flex items-center gap-2 bg-gray-700 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-500 text-white text-sm font-semibold px-3 py-2 rounded-lg shadow-md transition-all duration-200">
        <i data-lucide="moon" class="w-5 h-5"></i>
        <span id="modoTexto">Modo Claro</span>
    </button>

    <div class="bg-white dark:bg-gray-800 p-10 rounded-3xl shadow-xl w-full max-w-sm border border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <h1 class="text-3xl font-semibold text-center mb-6 text-gray-800 dark:text-gray-100">Acceso al Sistema</h1>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-100 text-center p-3 rounded mb-4 border border-red-300 dark:border-red-500 transition-colors duration-300">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Usuario</label>
                <input type="text" name="usuario" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 outline-none text-gray-800 dark:text-gray-100 dark:bg-gray-700 transition-colors duration-300">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Contraseña</label>
                <input type="password" name="clave" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 outline-none text-gray-800 dark:text-gray-100 dark:bg-gray-700 transition-colors duration-300">
            </div>

            <div>
                <label class="block text-gray-700 dark:text-gray-200 text-sm font-medium mb-1">Destino</label>
                <select name="destino" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 outline-none text-gray-800 dark:text-gray-100 dark:bg-gray-700 transition-colors duration-300">
                    <option value="">Selecciona el panel</option>
                    <option value="tailwind" <?= (isset($destino) && $destino === 'tailwind') ? 'selected' : '' ?>>Tailwind Panel</option>
                    <option value="boostrap" <?= (isset($destino) && $destino === 'boostrap') ? 'selected' : '' ?>>Bootstrap Panel</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 transition-colors py-2 rounded-lg text-white font-medium shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-400">
                Ingresar
            </button>
        </form>

        <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-6">© <?= date('Y') ?> Todos los derechos reservados</p>
    </div>

    <script>
        lucide.createIcons();

        // 🔹 MODO OSCURO
        const html = document.documentElement;
        const darkModeBtn = document.getElementById('darkModeBtn');
        const modoTexto = document.getElementById('modoTexto');

        function aplicarTema() {
            const temaGuardado = localStorage.getItem('theme');
            if (temaGuardado === 'dark') {
                html.classList.add('dark');
                modoTexto.textContent = 'Dark';
            } else {
                html.classList.remove('dark');
                modoTexto.textContent = 'Light';
            }
        }

        aplicarTema();

        darkModeBtn.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            modoTexto.textContent = isDark ? 'Dark' : 'Light';
        });
    </script>

</body>

</html>