<?php
include 'paneles_de_control/controladores/conexion.php';

// --- AGREGAR ---
if (isset($_POST['guardar'])) {
    $vendedor = mysqli_real_escape_string($conexion, $_POST['vendedor']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);

    $insert = mysqli_query($conexion, "INSERT INTO ventas (vendedor, direccion, fecha) VALUES ('$vendedor', '$direccion', '$fecha')");
    if ($insert) {
        mysqli_query($conexion, "INSERT INTO operaciones (operacion, vendedor, fecha) VALUES ('Agregar', '$vendedor', NOW())");
        echo "<script>echo 'ok';</script>";
        exit;
    }
}

// --- EDITAR ---
if (isset($_POST['editar'])) {
    $id = intval($_POST['id']);
    $vendedor = mysqli_real_escape_string($conexion, $_POST['vendedor']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);

    $update = mysqli_query($conexion, "UPDATE ventas SET vendedor='$vendedor', direccion='$direccion' WHERE id=$id");
    if ($update) {
        mysqli_query($conexion, "INSERT INTO operaciones (operacion, vendedor, fecha) VALUES ('Editar', '$vendedor', NOW())");
        echo "<script>echo 'ok';</script>";
        exit;
    }
}

// --- ELIMINAR ---
if (isset($_POST['eliminar'])) {
    $id = intval($_POST['id']);
    $vendedor = mysqli_real_escape_string($conexion, $_POST['vendedor']);

    $delete = mysqli_query($conexion, "DELETE FROM ventas WHERE id=$id");
    if ($delete) {
        mysqli_query($conexion, "INSERT INTO operaciones (operacion, vendedor, fecha) VALUES ('Eliminar', '$vendedor', NOW())");
        echo "<script>echo 'ok';</script>";
        exit;
    }
}

// --- CONSULTA PRINCIPAL ---
$sql = "SELECT * FROM ventas ORDER BY id DESC";
$con_sql = mysqli_query($conexion, $sql);
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Vendedores</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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

        body,
        div,
        table,
        input,
        button {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Loader minimalista profesional */
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #4b5563;
            /* gris neutro */
            border-top: 5px solid #f9fafb;
            /* color claro */
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Check animado */
        #check {
            font-size: 3rem;
            color: #10b981;
            /* verde elegante */
            opacity: 0;
            transform: scale(0);
            transition: all 0.5s ease-in-out;
        }

        #check.active {
            opacity: 1;
            transform: scale(1);
        }
    </style>

    <script>
        // Tema oscuro
        (function() {
            const temaGuardado = localStorage.getItem('theme');
            if (temaGuardado === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.style.backgroundColor = '#111827';
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.backgroundColor = '#f3f4f6';
            }
        })();
    </script>
</head>

<body class="bg-gray-900 text-gray-200">

    <main class="w-full max-w-5xl px-6 mt-10 flex flex-col items-center text-gray-100">

        <!-- TÍTULO PRINCIPAL -->
        <h1 class="text-3xl md:text-4xl font-extrabold text-center mb-8 
             bg-gradient-to-r from-violet-400 to-indigo-400 bg-clip-text text-transparent
             drop-shadow-md tracking-wide">
            Gestión de Vendedores
        </h1>

        <!-- BOTONES -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button onclick="openModal('agregar')"
                class="flex items-center gap-2 bg-violet-800 hover:bg-violet-700 
                   text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                <i data-lucide="user-plus" class="w-5 h-5"></i> Agregar vendedor
            </button>

            <a href="paneles_de_control/tailwind/historial.php"
                class="flex items-center gap-2 bg-green-700 hover:bg-green-600 
              text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                <i data-lucide="clipboard-list" class="w-5 h-5"></i> Historial
            </a>

            <button onclick="descargarPDF()"
                class="flex items-center gap-2 bg-red-700 hover:bg-red-600 
                   text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition-all">
                <i data-lucide="download" class="w-5 h-5"></i> Descargar PDF
            </button>
        </div>

        <!-- BUSCADOR -->
        <div class="w-full max-w-md mb-6">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-2.5 text-gray-400 w-5 h-5 pointer-events-none"></i>
                <input type="text" id="searchInput" placeholder="Buscar vendedor..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-700 
               bg-gray-800 shadow-sm focus:outline-none focus:ring-2 
               focus:ring-indigo-400 text-gray-200 placeholder-gray-400">
            </div>
        </div>

        <!-- TABLA -->
        <div class="w-full max-w-5xl overflow-x-auto bg-gray-800 rounded-xl shadow-lg border border-gray-700" id="tablaPDF">
            <table class="w-full text-sm text-left text-gray-200" id="vendedoresTable">
                <thead class="bg-gray-700 text-white uppercase text-xs">
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
                        <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                            <td class="px-6 py-4"><?= $rows['id'] ?></td>
                            <td class="px-6 py-4 font-medium"><?= $rows['vendedor'] ?></td>
                            <td class="px-6 py-4"><?= $rows['direccion'] ?></td>
                            <td class="px-6 py-4"><?= $rows['fecha'] ?></td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <button onclick="openModal('editar', {id:<?= $rows['id'] ?>,vendedor:'<?= $rows['vendedor'] ?>',direccion:'<?= $rows['direccion'] ?>'})"
                                    class="flex items-center gap-1 px-3 py-1 rounded-md bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold">
                                    <i data-lucide='pencil' class='w-4 h-4'></i> Editar
                                </button>
                                <button onclick="openModal('eliminar', {id:<?= $rows['id'] ?>,vendedor:'<?= $rows['vendedor'] ?>'})"
                                    class="flex items-center gap-1 px-3 py-1 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold">
                                    <i data-lucide='trash-2' class='w-4 h-4'></i> Eliminar
                                </button>
                                <button onclick="openModal('detalles', {id:<?= $rows['id'] ?>,vendedor:'<?= $rows['vendedor'] ?>',direccion:'<?= $rows['direccion'] ?>',fecha:'<?= $rows['fecha'] ?>'})"
                                    class="flex items-center gap-1 px-3 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold">
                                    <i data-lucide='info' class='w-4 h-4'></i> Detalles
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </main>


    <!-- MODAL DE ACCIONES -->
    <div id="modalAccion" class="modal fixed inset-0 bg-black bg-opacity-60 justify-center items-center z-50">
        <div class="bg-gray-900 rounded-xl shadow-2xl w-11/12 max-w-md p-6 border border-gray-700">
            <div class="flex justify-between items-center border-b border-gray-700 pb-3">
                <h2 id="modalTitulo" class="text-xl font-semibold text-gray-100 flex items-center gap-2"></h2>
                <button id="closeModalAccion" class="text-gray-400 hover:text-gray-200 text-2xl leading-none">&times;</button>
            </div>
            <div id="modalContenido" class="mt-4 space-y-4 text-gray-200"></div>
        </div>
    </div>

    <!-- MODAL DE CARGA SOBRIA -->
    <div id="modalCarga" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 hidden">
        <div class="bg-gray-900 rounded-xl p-6 flex flex-col items-center gap-4 w-40">
            <div class="loader"></div>
            <p class="text-gray-200 text-center text-sm">Procesando...</p>
            <div id="check">✓</div>
        </div>
    </div>

    <footer class="mt-10 py-4 text-center text-gray-400 text-sm">
        © <?= date("Y") ?> Sistema de Gestión de Vendedores — Todos los derechos reservados.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            lucide.createIcons();

            const modal = document.getElementById('modalAccion');
            const modalContent = modal.querySelector('div');

            window.openModal = function(tipo, datos = {}) {
                modal.classList.add('active');
                modalContent.classList.remove('animate-fadeIn');
                void modalContent.offsetWidth;
                modalContent.classList.add('animate-fadeIn');

                const titulo = document.getElementById('modalTitulo');
                const contenido = document.getElementById('modalContenido');
                titulo.innerHTML = contenido.innerHTML = '';

                if (tipo === 'agregar') {
                    titulo.innerHTML = `<i data-lucide="user-plus" class="w-5 h-5 text-indigo-500"></i> Nuevo Vendedor`;
                    contenido.innerHTML = `<form method="POST">
                <input type="hidden" name="guardar" value="1">
                <input type="text" name="vendedor" placeholder="Nombre" required class="w-full px-4 py-2 mb-2 border rounded-md bg-gray-800 border-gray-700 text-gray-200">
                <input type="text" name="direccion" placeholder="Dirección" required class="w-full px-4 py-2 mb-2 border rounded-md bg-gray-800 border-gray-700 text-gray-200">
                <input type="date" name="fecha" required class="w-full px-4 py-2 mb-2 border rounded-md bg-gray-800 border-gray-700 text-gray-200">
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md text-gray-200">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-white">Guardar</button>
                </div>
            </form>`;
                } else if (tipo === 'editar') {
                    titulo.innerHTML = `<i data-lucide="pencil" class="w-5 h-5 text-yellow-500"></i> Editar Vendedor`;
                    contenido.innerHTML = `<form method="POST">
                <input type="hidden" name="editar" value="1">
                <input type="hidden" name="id" value="${datos.id}">
                <input type="text" name="vendedor" value="${datos.vendedor}" placeholder="Nombre" required class="w-full px-4 py-2 mb-2 border rounded-md bg-gray-800 border-gray-700 text-gray-200">
                <input type="text" name="direccion" value="${datos.direccion}" placeholder="Dirección" required class="w-full px-4 py-2 mb-2 border rounded-md bg-gray-800 border-gray-700 text-gray-200">
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md text-gray-200">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 rounded-md text-white">Guardar</button>
                </div>
            </form>`;
                } else if (tipo === 'eliminar') {
                    titulo.innerHTML = `<i data-lucide="trash-2" class="w-5 h-5 text-red-500"></i> Eliminar Vendedor`;
                    contenido.innerHTML = `<form method="POST">
                <input type="hidden" name="eliminar" value="1">
                <input type="hidden" name="id" value="${datos.id}">
                <input type="hidden" name="vendedor" value="${datos.vendedor}"
                <p>¿Seguro que deseas eliminar al vendedor <strong name="vendedor">${datos.vendedor}</strong>?</p>
                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md text-gray-200">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-md text-white">Eliminar</button>
                </div>
            </form>`;
                } else if (tipo === 'detalles') {
                    titulo.innerHTML = `<i data-lucide="info" class="w-5 h-5 text-blue-500"></i> Detalles del Vendedor`;
                    contenido.innerHTML = `
                <p><strong>ID:</strong> ${datos.id}</p>
                <p><strong>Vendedor:</strong> ${datos.vendedor}</p>
                <p><strong>Dirección:</strong> ${datos.direccion}</p>
                <p><strong>Fecha:</strong> ${datos.fecha}</p>
                <div class="flex justify-end pt-3">
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md text-gray-200">Cerrar</button>
                </div>`;
                }

                lucide.createIcons();
            }

            window.cerrarModal = function() {
                modal.classList.remove('active');
            }
            document.getElementById('closeModalAccion').addEventListener('click', window.cerrarModal);

            // Buscador
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('vendedoresTable')?.getElementsByTagName('tbody')[0];
            if (searchInput && table) {
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = table.getElementsByTagName('tr');
                    for (let i = 0; i < rows.length; i++) {
                        const vendedor = rows[i].getElementsByTagName('td')[1];
                        rows[i].style.display = vendedor && vendedor.textContent.toLowerCase().includes(filter) ? '' : 'none';
                    }
                });
            }

            // Formulario con animación de carga profesional
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.closest('#modalContenido')) {
                    e.preventDefault();
                    const modalCarga = document.getElementById('modalCarga');
                    const loader = modalCarga.querySelector('.loader');
                    const check = document.getElementById('check');

                    modalCarga.classList.remove('hidden');
                    loader.style.display = 'block';
                    check.classList.remove('active');

                    const formData = new FormData(form);
                    fetch(window.location.href, {
                            method: 'POST',
                            body: formData
                        })
                        .then(() => {
                            setTimeout(() => {
                                loader.style.display = 'none';
                                check.classList.add('active');
                                setTimeout(() => {
                                    window.location = 'tailwind.php';
                                }, 1200);
                            }, 800);
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Error en el proceso');
                            modalCarga.classList.add('hidden');
                        });
                }
            });

            // FUNCION DESCARGAR PDF
            window.descargarPDF = function() {
                const element = document.getElementById('tablaPDF');
                const opt = {
                    margin: 0.5,
                    filename: 'vendedores.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'letter',
                        orientation: 'landscape'
                    }
                };
                html2pdf().set(opt).from(element).save();
            }

        });
    </script>

</body>

</html>