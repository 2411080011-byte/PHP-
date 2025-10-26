<!doctype html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Historial de Operaciones</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* ======== ESTILOS GENERALES ======== */
    body {
      background-color: #141414; /* negro grisáceo suave */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #e8e8e8;
      margin: 0;
      padding-bottom: 60px;
    }

    /* ======== ENCABEZADO ======== */
    header.encabezado {
      position: sticky;
      top: 0;
      width: 100%;
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      justify-items: center;
      padding: 18px 40px;
      background: #1a1a1a;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.6);
      z-index: 1000;
    }

    .reloj {
      justify-self: start;
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 1rem;
      color: #ccc;
    }

    .reloj i {
      color: #9a9a9a;
      font-size: 1.2rem;
    }

    .encabezado h1 {
      color: #ffffff;
      font-weight: 700;
      margin: 0;
      font-size: 1.8rem;
      text-align: center;
    }

    .btn-volver {
      justify-self: end;
      display: flex;
      align-items: center;
      gap: 6px;
      font-weight: 500;
      color: #f5f5f5;
      background: linear-gradient(135deg, #2a2a2a, #1d1d1d);
      border: 1px solid #333;
      border-radius: 8px;
      padding: 8px 14px;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .btn-volver:hover {
      background: linear-gradient(135deg, #333, #2a2a2a);
      border-color: #444;
      color: #fff;
      transform: translateY(-1px);
    }

    /* ======== BUSCADOR ======== */
    .search-box {
      display: flex;
      justify-content: center;
      margin: 30px 0;
    }

    .search-box input {
      background-color: #1e1e1e;
      border: 1px solid #333;
      color: #f0f0f0;
      padding: 10px 15px;
      border-radius: 8px;
      width: 320px;
      transition: all 0.3s ease;
      text-align: center;
    }

    .search-box input:focus {
      background-color: #252525;
      border-color: #555;
      outline: none;
    }

    /* ======== TABLA ======== */
    .table-container {
      background: #181818;
      border-radius: 12px;
      padding: 25px;
      width: 90%;
      margin: auto;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.5);
      transition: all 0.3s ease;
    }

    .table {
      background-color: #fdfdfd;
      border-radius: 10px;
      overflow: hidden;
      color: #222;
      border-collapse: separate;
      border-spacing: 0;
    }

    .table thead th {
      background-color: #202020;
      color: #f5f5f5;
      text-transform: uppercase;
      font-size: 0.9rem;
      letter-spacing: 0.5px;
      border-bottom: 2px solid #333;
      padding: 14px;
    }

    .table tbody td {
      border-top: 1px solid #e0e0e0;
      padding: 12px 14px;
    }

    .table-hover tbody tr:hover {
      background-color: #f2f2f2;
      transition: all 0.2s ease-in-out;
    }

    .badge-agregar {
      background-color: #085b04ff;
      padding: 5px 10px;
    }

    .badge-editar {
      background-color: #f67f00ff;
      color: #ffffffe5;
      padding: 5px 10px;
    }

    .badge-eliminar {
      background-color: #a20000ff;
      padding: 5px 10px;
    }

    /* ======== RESPONSIVE ======== */
    @media (max-width: 768px) {
      header.encabezado {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 10px;
      }

      .reloj, .btn-volver {
        justify-self: center;
      }

      .table-container {
        width: 100%;
      }
    }
  </style>
</head>

<body>

<?php
include '../controladores/conexion.php';
?>

<!-- ======== ENCABEZADO ======== -->
<header class="encabezado">
  <div class="reloj">
    <i class="bi bi-clock"></i>
    <span id="hora"></span>
  </div>

  <h1>Historial de Operaciones</h1>

  <a href="../../boostrap.php" class="btn-volver">
    <i class="bi bi-arrow-left-circle"></i> Volver
  </a>
</header>

<!-- ======== BUSCADOR ======== -->
<div class="search-box">
  <input type="text" id="buscador" placeholder="Buscar por vendedor u operación...">
</div>

<!-- ======== TABLA ======== -->
<div class="table-container">
  <table class="table table-hover align-middle text-center shadow-sm" id="tablaOperaciones">
    <thead>
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
          echo "<tr><td colspan='4' class='text-center text-secondary py-4'>No hay operaciones registradas.</td></tr>";
        }
      ?>
    </tbody>
  </table>
</div>

<!-- ======== SCRIPTS ======== -->
<script>
  document.getElementById('buscador').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    let filas = document.querySelectorAll('#tablaOperaciones tbody tr');

    filas.forEach(fila => {
      let texto = fila.textContent.toLowerCase();
      fila.style.display = texto.includes(filtro) ? '' : 'none';
    });
  });

  function actualizarHora() {
    const ahora = new Date();
    let horas = ahora.getHours();
    const minutos = ahora.getMinutes().toString().padStart(2, '0');
    const segundos = ahora.getSeconds().toString().padStart(2, '0');
    const ampm = horas >= 12 ? 'PM' : 'AM';
    horas = horas % 12 || 12;
    document.getElementById('hora').textContent = `${horas}:${minutos}:${segundos} ${ampm}`;
  }

  setInterval(actualizarHora, 1000);
  actualizarHora();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
