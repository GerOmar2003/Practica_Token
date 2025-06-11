<?php
$host = "sql10.freesqldatabase.com";
$usuario = "sql10784141";
$contrasena = "qJGyAkYjWf";
$basedatos = "sql10784141";
$puerto = 3306;

$conn = new mysqli($host, $usuario, $contrasena, $basedatos, $puerto);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
