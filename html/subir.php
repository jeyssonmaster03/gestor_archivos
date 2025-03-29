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


$permitidos = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
$extensiones_validas = ['jpg', 'jpeg', 'png', 'pdf'];
$archivo = $_FILES['archivo'];

if (
    isset($archivo) &&
    in_array($archivo['type'], $permitidos) &&
    in_array(strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION)), $extensiones_validas)
) {
    $nombre_original = basename($archivo['name']);
    $ruta_destino = uniqid() . "_" . $nombre_original;
    move_uploaded_file($archivo['tmp_name'], "uploads/" . $ruta_destino);

    $stmt = $conexion->prepare("INSERT INTO archivos (nombre_original, ruta, tipo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre_original, $ruta_destino, $archivo['type']);
    $stmt->execute();
} else {
    echo "<script>alert('Archivo no permitido. Solo se aceptan imágenes y PDFs.'); window.location.href='index.php';</script>";
    exit;
}

header("Location: index.php");
