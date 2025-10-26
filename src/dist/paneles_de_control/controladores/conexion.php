<?php
//INFO DE MI BD:
$_servidor = "db";//Configurado en docker otra opción es  $host = "localhost";
$_bd = "venta";
$_usuario = "Jesus16";  // Cambia si es necesario
$_contra = "jesus16";  // Cambia si es necesario

//Conexion con la base de datos
$conexion = new mysqli($_servidor, $_usuario, $_contra, $_bd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>