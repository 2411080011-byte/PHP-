<?php
include 'paneles_de_control/controladores/conexion.php';
mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS operaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  operacion VARCHAR(50),
  vendedor VARCHAR(255),
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP
)");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Tema Oscuro Elegante</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #121212;
      color: #e0e0e0;
      font-family: 'Source Sans 3', sans-serif;
    }

    .contenedor-general {
      padding: 20px 0;
    }

    h1 {
      color: #fff;
      font-weight: 700;
      text-align: center;
      font-size: 1.8rem;
      text-transform: uppercase;
      margin-bottom: 1.5rem;
    }

    /* Tabla y contenedor oscuro elegante */
    .table-container {
      background: #1f1f23;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
      transition: all 0.3s ease;
    }

    .table-container:hover {
      box-shadow: 0 6px 25px rgba(0,0,0,0.5);
    }

    table {
      color: #e0e0e0;
    }

    thead {
      background: linear-gradient(90deg, #2b2b2f, #3a3a3f);
      color: #fff;
    }

    tbody tr {
      background-color: #242428;
      transition: background 0.3s ease;
    }

    tbody tr:hover {
      background-color: #303036;
    }

    /* Buscador oscuro */
    .search-input {
      max-width: 400px;
      margin-bottom: 20px;
      border-radius: 25px;
      padding-left: 20px;
      padding-right: 20px;
      background-color: #2a2a2f;
      color: #e0e0e0;
      border: 1px solid #555;
    }

    .search-input::placeholder {
      color: #aaa;
    }

    /* Botones */
    .btn-login, .btn-success, .btn-info, .btn-warning, .btn-danger, .btn-secondary {
      border-radius: 8px;
      transition: .2s;
    }

    .btn:hover {
      transform: translateY(-1.4px);
      transition: .2s linear;
    }

    .relog {
      width: 130px;
      font-size: .8rem;
      border-radius: 100px;
      padding: 6px 20px;
      background: linear-gradient(90deg, #4e54c8, #8f94fb);
      color: #fff;
      text-align: center;
      transition: .2s;
    }

    .relog:hover {
      transform: translateY(-1.4px);
    }

    /* === MODALES MODO OSCURO ELEGANTE === */
    .modal-content {
      background-color: #1f1f23;
      color: #e0e0e0;
      border: 1px solid #2d2d33;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
      animation: fadeIn 0.25s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
      border: none;
      border-bottom: 1px solid #2d2d33;
      background-color: #25252a;
      color: #fff;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }

    .modal-title {
      font-weight: 600;
    }

    .modal-body {
      background-color: #1f1f23;
      color: #dcdcdc;
      border-radius: 0 0 12px 12px;
    }

    .modal-footer {
      border: none;
      border-top: 1px solid #2d2d33;
      background-color: #25252a;
      border-bottom-left-radius: 12px;
      border-bottom-right-radius: 12px;
    }

    .modal-footer .btn {
      min-width: 90px;
      border-radius: 8px;
    }

    /* Botones dentro del modal */
    .modal-footer .btn-secondary {
      background-color: #2e2e33;
      border: none;
      color: #ddd;
    }

    .modal-footer .btn-secondary:hover {
      background-color: #3a3a3f;
    }

    .modal-footer .btn-success {
      background-color: #00c97e;
      border: none;
      color: #fff;
    }

    .modal-footer .btn-success:hover {
      background-color: #00b370;
    }

    .modal-footer .btn-warning {
      background-color: #f5c400;
      border: none;
      color: #222;
    }

    .modal-footer .btn-warning:hover {
      background-color: #ffcc33;
    }

    .modal-footer .btn-danger {
      background-color: #d63c3c;
      border: none;
    }

    .modal-footer .btn-danger:hover {
      background-color: #e24b4b;
    }

    .btn-close-white {
      filter: invert(1);
    }

    .form-control {
      background-color: #2b2b30;
      border: 1px solid #444;
      color: #f0f0f0;
      border-radius: 6px;
    }

    .form-control:focus {
      background-color: #323238;
      border-color: #666;
      box-shadow: none;
    }
  </style>

  <script>
    setInterval(() => document.getElementById("relog").textContent = new Date().toLocaleTimeString(), 1000);
  </script>
</head>
<body>

<div class="contenedor-general">
  <div class="container text-center">
    <h1>Gestión de Vendedores</h1>

    <div class="d-flex justify-content-center mb-3 gap-2">
      <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAgregar" style='background-color: #085b04ff'>
        <i class="bi bi-person-plus"></i> Agregar Vendedor
      </button>
      <a href="paneles_de_control/boostrap/operaciones.php" class="btn btn-secondary shadow-sm" style='background-color: #6a6a6aff'>
        <i class="bi bi-card-list"></i> Historial de Operaciones
      </a>
    </div>

    <input type="text" id="searchInput" class="form-control search-input mx-auto shadow-sm" placeholder="Buscar vendedor..." style="color: white;">

    <div class="table-container mt-3">
      <table class="table table-hover table-striped align-middle" id="vendedoresTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Vendedor</th>
            <th>Dirección</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM ventas ORDER BY id DESC";
          $resultado = mysqli_query($conexion, $sql);

          if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
              $id = $fila['id'];
              $vendedor = htmlspecialchars($fila['vendedor']);
              $direccion = htmlspecialchars($fila['direccion']);
              $fecha = $fila['fecha'];

              echo "
              <tr>
                <td>$id</td>
                <td>$vendedor</td>
                <td>$direccion</td>
                <td>$fecha</td>
                <td class='d-flex gap-2 justify-content-center'>
                  <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#modalDetalle$id' style='background-color: #007babff; color:white'>
                    <i class='bi bi-eye'></i> Detalle
                  </button>
                  <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar$id' style='background-color: #f67f00ff; color:white'>
                    <i class='bi bi-pencil'></i> Editar
                  </button>
                  <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modalEliminar$id' style='background-color: #a20000ff; color:white'>
                    <i class='bi bi-trash'></i> Eliminar
                  </button>
                </td>
              </tr>

              <!-- Modal Detalle -->
              <div class='modal fade' id='modalDetalle$id' tabindex='-1'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header' style='background-color: #007babff'>
                      <h5 class='modal-title'><i class='bi bi-eye'></i> Detalle de Vendedor</h5>
                      <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                    </div>
                    <div class='modal-body text-start'>
                      <p><strong>ID:</strong> $id</p>
                      <p><strong>Vendedor:</strong> $vendedor</p>
                      <p><strong>Dirección:</strong> $direccion</p>
                      <p><strong>Fecha:</strong> $fecha</p>
                    </div>
                    <div class='modal-footer'>
                      <button class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal Editar -->
              <div class='modal fade' id='modalEditar$id' tabindex='-1'>
                <div class='modal-dialog'>
                  <form method='POST'>
                    <div class='modal-content'>
                      <div class='modal-header' style='background-color: #f67f00ff'>
                        <h5 class='modal-title'><i class='bi bi-pencil'></i> Editar Vendedor</h5>
                        <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                      </div>
                      <div class='modal-body'>
                        <input type='hidden' name='id' value='$id'>
                        <div class='mb-3'>
                          <label class='form-label'>Nombre</label>
                          <input type='text' name='vendedor' value='$vendedor' class='form-control' required style='color: white'>
                        </div>
                        <div class='mb-3'>
                          <label class='form-label'>Dirección</label>
                          <input type='text' name='direccion' value='$direccion' class='form-control' required style='color: white'>
                        </div>
                        <div class='mb-3'>
                          <label class='form-label'>Fecha</label>
                          <input type='date' name='fecha' value='$fecha' class='form-control' required style='color: white'>
                        </div>
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                        <button type='submit' name='editar' class='btn' style='background-color: #f67f00ff; color:white'>Guardar</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Modal Eliminar -->
              <div class='modal fade' id='modalEliminar$id' tabindex='-1'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header' style='background-color: #a20000ff'>
                      <h5 class='modal-title'><i class='bi bi-trash'></i> Eliminar Vendedor</h5>
                      <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' ></button>
                    </div>
                    <div class='modal-body'>
                      <p>¿Deseas eliminar al vendedor <strong>$vendedor</strong>?</p>
                    </div>
                    <div class='modal-footer'>
                      <button class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                      <a href='boostrap.php?eliminar=$id' class='btn' style='background-color: #a20000ff; color:white'>Eliminar</a>
                    </div>
                  </div>
                </div>
              </div>
            ";
            }
          } else {
            echo "<tr><td colspan='5' class='text-center text-muted'>No hay vendedores registrados.</td></tr>";
          }

          if (isset($_GET['eliminar'])) {
            $id = intval($_GET['eliminar']);
            $vendedor_el = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT vendedor FROM ventas WHERE id='$id'"))['vendedor'];
            mysqli_query($conexion, "DELETE FROM ventas WHERE id='$id'");
            mysqli_query($conexion, "INSERT INTO operaciones (operacion, vendedor) VALUES ('Eliminar','$vendedor_el')");
            echo "<script>alert('Vendedor eliminado correctamente'); window.location='boostrap.php';</script>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Agregar -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header" style='background-color: #085b04ff'>
            <h5 class="modal-title"><i class="bi bi-person-plus"></i> Agregar Nuevo Vendedor</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nombre del vendedor</label>
              <input type="text" name="vendedor" class="form-control" required style="color: white;">
            </div>
            <div class="mb-3">
              <label class="form-label">Dirección</label>
              <input type="text" name="direccion" class="form-control" required style="color: white;">
            </div>
            <div class="mb-3">
              <label class="form-label">Fecha</label>
              <input type="date" name="fecha" class="form-control" required style="color: white;">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" name="agregar" class="btn btn-success" style='background-color: #085b04ff'>Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
if (isset($_POST['agregar'])) {
  $vendedor = mysqli_real_escape_string($conexion, $_POST['vendedor']);
  $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
  $fecha = $_POST['fecha'];
  mysqli_query($conexion, "INSERT INTO ventas (vendedor,direccion,fecha) VALUES ('$vendedor','$direccion','$fecha')");
  mysqli_query($conexion, "INSERT INTO operaciones (operacion,vendedor) VALUES ('Agregar','$vendedor')");
  echo "<script>alert('Vendedor agregado exitosamente'); window.location='boostrap.php';</script>";
}

if (isset($_POST['editar'])) {
  $id = intval($_POST['id']);
  $vendedor = mysqli_real_escape_string($conexion, $_POST['vendedor']);
  $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
  $fecha = $_POST['fecha'];
  mysqli_query($conexion, "UPDATE ventas SET vendedor='$vendedor',direccion='$direccion',fecha='$fecha' WHERE id='$id'");
  mysqli_query($conexion, "INSERT INTO operaciones (operacion,vendedor) VALUES ('Editar','$vendedor')");
  echo "<script>alert('Vendedor editado exitosamente'); window.location='boostrap.php';</script>";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const searchInput = document.getElementById('searchInput');
  const table = document.getElementById('vendedoresTable').getElementsByTagName('tbody')[0];

  searchInput.addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = table.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
      const vendedor = rows[i].getElementsByTagName('td')[1];
      rows[i].style.display = vendedor && vendedor.textContent.toLowerCase().includes(filter) ? '' : 'none';
    }
  });
</script>
