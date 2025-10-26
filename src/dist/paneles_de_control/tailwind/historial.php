<!doctype html>
<html lang="es" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial de Operaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>
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

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col items-center transition-colors duration-500">

    <?php
    include '../controladores/conexion.php';
    $sql = "SELECT * FROM operaciones ORDER BY id DESC";
    $con_sql = mysqli_query($conexion, $sql);
    ?>

    <!-- ENCABEZADO -->
    <header class="w-full bg-gray-800 dark:bg-gray-800 text-white shadow-md py-6 px-8 flex justify-between items-center transition-colors duration-500">
        <div class="flex items-center gap-2 text-sm font-medium">
            <i data-lucide="clock" class="w-5 h-5"></i>
            <span id="reloj"></span>
        </div>

        <h1 class="text-2xl md:text-3xl font-bold text-center flex-1 text-white">Historial de Operaciones</h1>

        <div class="flex items-center gap-3">
            <button id="darkModeBtn"
                class="flex items-center gap-2 bg-gray-700 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-500 text-white text-sm font-semibold px-3 py-2 rounded-lg shadow-md transition-all duration-200">
                <i data-lucide="moon" class="w-5 h-5"></i>
                <span id="modoTexto">Modo Claro</span>
            </button>

            <a href="../../tailwind.php"
                class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                <i data-lucide="arrow-left-circle" class="w-5 h-5"></i>
                <span>Volver</span>
            </a>
        </div>
    </header>

    <!-- CONTENIDO -->
    <main class="w-full max-w-5xl px-6 mt-10 flex flex-col items-center">
        <div class="w-full max-w-md mb-9">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-2.5 text-gray-500 w-5 h-5 pointer-events-none"></i>
                <input type="text" id="searchInput" placeholder="Buscar operación o vendedor..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-400 dark:border-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition duration-200 dark:bg-gray-800 dark:text-gray-200">
            </div>
        </div>

        <div class="w-full max-w-5xl overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 transition-colors duration-500">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300" id="historialTable">
                <thead class="bg-gray-800 dark:bg-gray-900 text-white uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Operación</th>
                        <th class="px-6 py-3">Vendedor</th>
                        <th class="px-6 py-3">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rows = mysqli_fetch_array($con_sql)) {
                        // Determinar color del botón según la operación
                        $operacion = strtolower($rows['operacion']);
                        $colorClass = "bg-gray-500 hover:bg-gray-600 text-white";
                        $icon = "circle";

                        if ($operacion == 'agregar') {
                            $colorClass = "bg-violet-900 hover:bg-violet-800";
                            $icon = "plus-circle";
                        } elseif ($operacion == 'editar') {
                            $colorClass = "bg-amber-600 hover:bg-amber-700";
                            $icon = "edit";
                        } elseif ($operacion == 'eliminar') {
                            $colorClass = "bg-red-600 hover:bg-red-700";
                            $icon = "trash-2";
                        }
                    ?>
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4"><?= $rows['id'] ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold text-white <?= $colorClass ?>">
                                    <i data-lucide="<?= $icon ?>" class="w-4 h-4"></i> <?= ucfirst($rows['operacion']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4"><?= $rows['vendedor'] ?></td>
                            <td class="px-6 py-4"><?= $rows['fecha'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="mt-10 py-4 text-center text-gray-600 dark:text-gray-400 text-sm transition-colors duration-500">
        © <?= date("Y") ?> Sistema de Gestión de Vendedores — Historial de Operaciones.
    </footer>

    <script>
        lucide.createIcons();

        // 🌙 Modo Oscuro
        const html = document.documentElement;
        const darkModeBtn = document.getElementById('darkModeBtn');
        const modoTexto = document.getElementById('modoTexto');

        if (localStorage.getItem('theme') === 'dark') {
            html.classList.add('dark');
            modoTexto.textContent = 'Dark';
        } else {
            html.classList.remove('dark');
            modoTexto.textContent = 'Light';
        }

        darkModeBtn.addEventListener('click', () => {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            modoTexto.textContent = isDark ? 'Dark' : 'Light';
        });

        // 🔍 Buscador
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('historialTable').getElementsByTagName('tbody')[0];
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = table.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                const operacion = rows[i].getElementsByTagName('td')[1];
                const vendedor = rows[i].getElementsByTagName('td')[2];
                if (operacion || vendedor) {
                    const texto = (operacion.textContent + vendedor.textContent).toLowerCase();
                    rows[i].style.display = texto.includes(filter) ? '' : 'none';
                }
            }
        });

        // 🔹 RELOJ
        function actualizarReloj() {
            const reloj = document.getElementById('reloj');
            const ahora = new Date();
            reloj.textContent = ahora.toLocaleTimeString();
        }
        setInterval(actualizarReloj, 1000);
        actualizarReloj();
    </script>

</body>

</html>