<?php
include("db.php");
include("jwt_utils.php");

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $jwt = crearJWT($username);

    // Enviar el JWT al cliente en cookie
    setcookie("token", $jwt, time() + 3600, "/");

    header("Location: dashboard.php");
} else {
    echo "Credenciales inválidas.";
}
?>
