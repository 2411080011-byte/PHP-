<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestión de Vendedores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #e6e6e6f6;
      padding: 0 0 40px 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }

    .encabezado {
      width: 100%;
      position: sticky;
      top: 0;
      display: flex;
      justify-content: space-around;
      align-items: center;
      margin-bottom: 20px;
      padding: 15px 0;
      background-color: #000939ff;
      z-index: 1000;
    }
    h1 {
      color: #fff;
      font-weight: 700;
      text-align: center;
      font-size: 1.8rem;
      text-transform: uppercase;
    }

    .table-container {
      background: #ffffff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
    }

    .table-container:hover {
      box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
    }

    .btn-login {
      display: flex;
      align-items: center;
      gap: 5px;
      background-color: #e4e4e4ff;
      color: black;
    }

    .search-input {
      max-width: 400px;
      margin-bottom: 20px;
      border-radius: 25px;
      padding-left: 20px;
      padding-right: 20px;
    }

    .modal-header,
    .modal-footer {
      border: none;
    }

    .btn-success,
    .btn-info,
    .btn-warning,
    .btn-danger,
    .btn-secondary {
      border-radius: 8px;
    }

    .btn-info:hover {
      background-color: #0dcaf0;
    }

    .btn-warning:hover {
      background-color: #ffc107;
    }

    .btn-danger:hover {
      background-color: #dc3545;
    }
    .btn-login:hover {
      background-color: white;
      color: black;
    }
    .relog {
      width: 130px;
      font-size: .8rem;
      border-radius: 100px;
      padding: 6px 20px;
      transition: .2s;
    }
    .relog:hover {
      transform: translateY(-1.4px);
      transition: .2s linear;
    }

    .btn {
      border-radius: 100px;
      transition: .2s;
    }

    .btn:hover {
      transform: translateY(-1.4px);
      transition: .2s linear;
    }
  </style>
  <script>
    setInterval(() => document.getElementById("relog").textContent = new Date().toLocaleTimeString(), 1000);
  </script>
</head>

<body class="position-relative">

  <?php
  include 'paneles_de_control/controladores/conexion.php';
  mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS operaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  operacion VARCHAR(50),
  vendedor VARCHAR(255),
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP
)");
  ?>

  <div class="encabezado">
    <!-- Botón del relog -->
    <div class="relog btn btn-secondary shadow-sm">
      <div id="relog" style="text-align: center;"></div>
    </div>

    <h1>Gestión de Vendedores</h1>

    <!-- Botón regresar con icono -->
    <a href="../index.php" class="btn btn-secondary shadow-sm">
      <i class="bi bi-arrow-left"></i> Salir al Login
    </a>
  </div>
  <div class="container text-center">
    <div class="d-flex justify-content-center mb-3 gap-2">
      <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAgregar">
        <i class="bi bi-person-plus"></i> Agregar Vendedor
      </button>
      <a href="operaciones.php" class="btn btn-secondary shadow-sm">
        <i class="bi bi-card-list"></i> Historial de Operaciones
      </a>
    </div>

    <input type="text" id="searchInput" class="form-control search-input mx-auto shadow-sm" placeholder="Buscar vendedor...">

    <div class="table-container mt-3">
      <table class="table table-hover table-striped align-middle" id="vendedoresTable">
        <thead class="table-primary">
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
                  <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#modalDetalle$id'>
                    <i class='bi bi-eye'></i> Detalle
                  </button>
                  <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar$id'>
                    <i class='bi bi-pencil'></i> Editar
                  </button>
                  <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modalEliminar$id'>
                    <i class='bi bi-trash'></i> Eliminar
                  </button>
                </td>
              </tr>

              <!-- Modal Detalle -->
              <div class='modal fade' id='modalDetalle$id' tabindex='-1'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header bg-info text-white'>
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
                      <div class='modal-header bg-warning'>
                        <h5 class='modal-title'><i class='bi bi-pencil'></i> Editar Vendedor</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                      </div>
                      <div class='modal-body'>
                        <input type='hidden' name='id' value='$id'>
                        <div class='mb-3'>
                          <label class='form-label'>Nombre</label>
                          <input type='text' name='vendedor' value='$vendedor' class='form-control' required>
                        </div>
                        <div class='mb-3'>
                          <label class='form-label'>Dirección</label>
                          <input type='text' name='direccion' value='$direccion' class='form-control' required>
                        </div>
                        <div class='mb-3'>
                          <label class='form-label'>Fecha</label>
                          <input type='date' name='fecha' value='$fecha' class='form-control' required>
                        </div>
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                        <button type='submit' name='editar' class='btn btn-warning'>Guardar</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Modal Eliminar -->
              <div class='modal fade' id='modalEliminar$id' tabindex='-1'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header bg-danger text-white'>
                      <h5 class='modal-title'><i class='bi bi-trash'></i> Eliminar Vendedor</h5>
                      <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                    </div>
                    <div class='modal-body'>
                      <p>¿Deseas eliminar al vendedor <strong>$vendedor</strong>?</p>
                    </div>
                    <div class='modal-footer'>
                      <button class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                      <a href='boostrap.php?eliminar=$id' class='btn btn-danger'>Eliminar</a>
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

  <!-- MODAL Agregar -->
  <div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title"><i class="bi bi-person-plus"></i> Agregar Nuevo Vendedor</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nombre del vendedor</label>
              <input type="text" name="vendedor" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Dirección</label>
              <input type="text" name="direccion" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Fecha</label>
              <input type="date" name="fecha" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" name="agregar" class="btn btn-success">Guardar</button>
          </div>
        </div>
      </form>
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
        if (vendedor) {
          rows[i].style.display = vendedor.textContent.toLowerCase().includes(filter) ? '' : 'none';
        }
      }
    });
  </script>

</body>

</html>