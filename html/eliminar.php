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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    
    $resultado = $conexion->query("SELECT * FROM archivos WHERE id = $id LIMIT 1");
    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $ruta = "uploads/" . $fila['ruta'];

        
        if (file_exists($ruta)) {
            unlink($ruta);
        }

        
        $conexion->query("DELETE FROM archivos WHERE id = $id");
    }
}

header("Location: index.php");
