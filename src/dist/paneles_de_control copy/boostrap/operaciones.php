<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Historial de Operaciones</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #eef2f7;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 0 40px 40px 40px;
    }
    h1 {
      color: #0d6efd;
      font-weight: 700;
      margin: 0;
      text-align: center;
    }
    .table-container {
      background: #ffffff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
    }
    .table-container:hover {
      box-shadow: 0 6px 25px rgba(0,0,0,0.12);
    }
    .badge-agregar { background-color: #198754; } /* verde */
    .badge-editar { background-color: #ffc107; color: #212529; } /* amarillo */
    .badge-eliminar { background-color: #dc3545; } /* rojo */
    .encabezado{
      width: 100%;
      height: 15vh;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding: 15px 0;
      z-index: 1000;
    }
    
  </style>
</head>
<body>

<?php
include '../controladores/conexion.php';
?>

<div class="encabezado">
  <h1>Historial de Operaciones</h1>
    <div></div>
  <!-- Botón para volver -->
  <a href="boostrap.php" class="btn btn-dark btn-login shadow-sm">⬅ Volver a Vendedores</a>
</div>

<div class="table-container">
  <table class="table table-hover align-middle">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Operación</th>
        <th>Vendedor</th>
        <th>Fecha y Hora</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql = "SELECT * FROM operaciones ORDER BY fecha DESC";
        $resultado = mysqli_query($conexion, $sql);

        if(mysqli_num_rows($resultado) > 0){
          while($fila = mysqli_fetch_assoc($resultado)){
            $id = $fila['id'];
            $operacion = $fila['operacion'];
            $vendedor = htmlspecialchars($fila['vendedor']);
            $fecha = $fila['fecha'];

            // Determinar el badge según operación
            $badgeClass = '';
            if($operacion == 'Agregar') $badgeClass = 'badge-agregar';
            elseif($operacion == 'Editar') $badgeClass = 'badge-editar';
            elseif($operacion == 'Eliminar') $badgeClass = 'badge-eliminar';

            echo "
              <tr>
                <td>$id</td>
                <td><span class='badge $badgeClass'>$operacion</span></td>
                <td>$vendedor</td>
                <td>$fecha</td>
              </tr>
            ";
          }
        } else {
          echo "<tr><td colspan='4' class='text-center text-muted'>No hay operaciones registradas.</td></tr>";
        }
      ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
