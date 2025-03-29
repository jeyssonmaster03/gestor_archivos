<?php
$intentos = 5;
while ($intentos > 0) {
    $conexion = @new mysqli("base_de_datos2", "usuario", "clave", "sistema_archivos");
    if ($conexion->connect_errno == 0) break;
    sleep(1);
    $intentos--;
}

if ($conexion->connect_errno) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

$resultado = $conexion->query("SELECT * FROM archivos ORDER BY fecha_subida DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestor de Archivos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">📁 Gestor de Archivos</h2>

    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">Subir Archivo</h5>
        <form action="subir.php" method="POST" enctype="multipart/form-data" class="row g-3">
          <div class="col-auto">
            <input type="file" name="archivo" class="form-control" required>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-primary">Subir</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Archivos Subidos</h5>
        <ul class="list-group">
  <?php while($fila = $resultado->fetch_assoc()): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <a href="uploads/<?= $fila['ruta'] ?>" download><?= $fila['nombre_original'] ?></a>
        <br>
        <small class="text-muted"><?= $fila['tipo'] ?> - <?= $fila['fecha_subida'] ?></small>
        </div>
        <a href="eliminar.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-sm"
         onclick="return confirm('¿Estás seguro de que deseas eliminar este archivo?')">
         Eliminar
        </a>
        </li>
        <?php endwhile; ?>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
