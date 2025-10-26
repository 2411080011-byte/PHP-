<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Vendedores</title>

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

    <!-- Tailwind + Librerías -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <!-- Configuración Tailwind -->
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

    <style>
        .modal {
            display: none;
        }

        .modal.active {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-in-out;
        }

        /* Suaviza los cambios de tema */
        body,
        header,
        main,
        div,
        table,
        input,
        button {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col items-center transition-colors duration-500">

    <?php
    include '../controladores/conexion.php';
    $sql = "SELECT * FROM ventas ORDER BY id DESC";
    $con_sql = mysqli_query($conexion, $sql);
    ?>

    <!-- 🔸 ENCABEZADO -->
    <header class="w-full bg-gray-800 dark:bg-gray-800 text-white shadow-md py-6 px-8 flex justify-between items-center transition-colors duration-500">
        <div class="flex items-center gap-2 text-sm font-medium">
            <i data-lucide="clock" class="w-5 h-5"></i>
            <span id="reloj"></span>
        </div>

        <h1 class="text-2xl md:text-3xl font-bold text-center flex-1">Gestión de Vendedores</h1>

        <div class="flex items-center gap-3">
            <!-- Botón modo oscuro -->
            <button id="darkModeBtn"
                class="flex items-center gap-2 bg-gray-700 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-500 text-white text-sm font-semibold px-3 py-2 rounded-lg shadow-md transition-all duration-200">
                <i data-lucide="moon" class="w-5 h-5"></i>
                <span id="modoTexto">Modo Claro</span>
            </button>

            <a href="../index.php"
                class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-md transition-all duration-200">
                <i data-lucide="arrow-left-circle" class="w-5 h-5"></i>
                <span>Volver</span>
            </a>
        </div>
    </header>

    <!-- 🔸 CONTENIDO PRINCIPAL -->
    <main class="w-full max-w-5xl px-6 mt-10 flex flex-col items-center">

        <!-- BOTONES -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button id="openModalBtn"
                class="flex items-center gap-2 bg-violet-900 hover:bg-violet-800 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                <span>Agregar vendedor</span>
            </button>

            <a href="historial.php"
                class="flex items-center gap-2 bg-green-700 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                <span>Historial</span>
            </a>

            <button onclick="descargarPDF()"
                class="flex items-center gap-2 bg-red-700 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                <i data-lucide="download" class="w-5 h-5"></i>
                <span>Descargar PDF</span>
            </button>
        </div>

        <!-- BUSCADOR -->
        <div class="w-full max-w-md mb-6">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-2.5 text-gray-500 w-5 h-5 pointer-events-none"></i>
                <input type="text" id="searchInput" placeholder="Buscar vendedor..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-400 dark:border-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition duration-200 dark:bg-gray-800 dark:text-gray-200">
            </div>
        </div>

        <!-- TABLA -->
        <div id="tablaVendedores" class="w-full max-w-5xl overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 transition-colors duration-500">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300" id="vendedoresTable">
                <thead class="bg-gray-800 dark:bg-gray-900 text-white uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Vendedor</th>
                        <th class="px-6 py-3">Dirección</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rows = mysqli_fetch_array($con_sql)) { ?>
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4"><?= $rows['id'] ?></td>
                            <td class="px-6 py-4 font-medium"><?= $rows['vendedor'] ?></td>
                            <td class="px-6 py-4"><?= $rows['direccion'] ?></td>
                            <td class="px-6 py-4"><?= $rows['fecha'] ?></td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <button onclick="openEditar(<?= $rows['id'] ?>)"
                                    class="flex items-center gap-1 px-3 py-1 rounded-md bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold transition">
                                    <i data-lucide='pencil' class='w-4 h-4'></i> Editar
                                </button>
                                <button onclick="openDetalles(<?= $rows['id'] ?>)"
                                    class="flex items-center gap-1 px-3 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition">
                                    <i data-lucide='info' class='w-4 h-4'></i> Detalles
                                </button>
                                <button onclick="openEliminar(<?= $rows['id'] ?>)"
                                    class="flex items-center gap-1 px-3 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold transition">
                                    <i data-lucide='trash-2' class='w-4 h-4'></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- 🔸 MODAL AGREGAR -->
    <div id="modal" class="modal fixed inset-0 bg-black bg-opacity-50 justify-center items-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-11/12 max-w-md p-6 animate-fadeIn transition-colors duration-500">
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-5 h-5 text-indigo-600"></i> Nuevo Vendedor
                </h2>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <form action="" method="POST" class="mt-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre del vendedor</label>
                    <input type="text" name="vendedor" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dirección</label>
                    <input type="text" name="direccion" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha</label>
                    <input type="date" name="fecha" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                </div>
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" id="cancelModalBtn"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 rounded-md text-gray-800 dark:text-gray-200 font-semibold flex items-center gap-1">
                        <i data-lucide="x" class="w-4 h-4"></i> Cancelar
                    </button>
                    <button type="submit" name="guardar"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white font-semibold flex items-center gap-1">
                        <i data-lucide="save" class="w-4 h-4"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['guardar'])) {
        $vendedor = $_POST['vendedor'];
        $direccion = $_POST['direccion'];
        $fecha = $_POST['fecha'];
        $insert = mysqli_query($conexion, "INSERT INTO ventas (vendedor, direccion, fecha) VALUES ('$vendedor', '$direccion', '$fecha')");
        if ($insert) {
            mysqli_query($conexion, "INSERT INTO operaciones (operacion, vendedor, fecha) VALUES ('Agregar', '$vendedor', NOW())");
            echo "<script>alert('Vendedor agregado correctamente.');window.location='tailwind.php';</script>";
        } else {
            echo "<script>alert('Error al agregar vendedor.');</script>";
        }
    }
    ?>

    <footer class="mt-10 py-4 text-center text-gray-600 dark:text-gray-400 text-sm">
        © <?= date("Y") ?> Sistema de Gestión de Vendedores — Todos los derechos reservados.
    </footer>

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

        // 🔹 MODAL NUEVO VENDEDOR
        const modal = document.getElementById('modal');
        document.getElementById('openModalBtn').addEventListener('click', () => modal.classList.add('active'));
        document.getElementById('closeModalBtn').addEventListener('click', () => modal.classList.remove('active'));
        document.getElementById('cancelModalBtn').addEventListener('click', () => modal.classList.remove('active'));

        // 🔹 BUSCADOR
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('vendedoresTable').getElementsByTagName('tbody')[0];
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = table.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                const vendedor = rows[i].getElementsByTagName('td')[1];
                if (vendedor) {
                    const txtValue = vendedor.textContent || vendedor.innerText;
                    rows[i].style.display = txtValue.toLowerCase().includes(filter) ? '' : 'none';
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

        // 🔹 MODALES DE ACCIÓN
        function openEditar(id) {
            window.location = 'modal_editar.php?id=' + id;
        }

        function openDetalles(id) {
            window.location = 'modal_detalles.php?id=' + id;
        }

        function openEliminar(id) {
            window.location = 'modal_eliminar.php?id=' + id;
        }

        // 🔹 DESCARGAR PDF
        function descargarPDF() {
            const elemento = document.getElementById('tablaVendedores');
            html2pdf().from(elemento).set({
                margin: 10,
                filename: 'reporte_vendedores.pdf',
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4'
                }
            }).save();
        }
    </script>

</body>

</html>