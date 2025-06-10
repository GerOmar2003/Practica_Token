<?php
include("jwt_utils.php");

if (!isset($_COOKIE['token'])) {
    header("Location: index.html");
    exit();
}

$token = $_COOKIE['token'];
$datos = verificarJWT($token);

if (!$datos) {
    echo "Token inválido o expirado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel - Bienvenido</title>
  
  <link rel="stylesheet" href="estilo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="login-box">

    <h2><i class="fas fa-user-circle"></i> Bienvenido, <?php echo htmlspecialchars($datos->user); ?>.</h2>
<p class="codigo">
  <i class="fas fa-key"></i> Código de acceso: 
  <strong id="codigoTexto"><?php echo $datos->codigo; ?></strong>
  <i class="fas fa-eye toggle-password" id="togglePassword" style="cursor:pointer; margin-left:10px;"></i>
</p>

    <p class="subtext">
      <i class="fas fa-clock"></i> Token válido hasta: <span id="horaExpira"></span>
    </p>

    <p class="subtext">
      <i class="fas fa-hourglass-half"></i> Tiempo restante: <span id="contador"></span>
    </p>

    <button onclick="cerrarSesion()">
      <i class="fas fa-sign-out-alt"></i> Cerrar sesión
    </button>
  </div>

  <script>
    const exp = <?php echo $datos->exp * 1000; ?>;
    const horaSpan = document.getElementById("horaExpira");
    const contadorSpan = document.getElementById("contador");

    function actualizarContador() {
      const ahora = Date.now();
      const diferencia = exp - ahora;

      if (diferencia <= 0) {
        contadorSpan.textContent = "Expirado";
        alert("Tu sesión ha expirado.");
        location.href = "logout.php";
        return;
      }

      const fecha = new Date(exp);
      horaSpan.textContent = fecha.toLocaleTimeString();

      const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
      const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

      contadorSpan.textContent = `${minutos} min ${segundos < 10 ? "0" + segundos : segundos} seg`;

      setTimeout(actualizarContador, 1000);
    }

    function cerrarSesion() {
      window.location.href = "logout.php";
    }

    actualizarContador();
  </script>

  <!-- Script para mostrar/ocultar código -->
  <script>
  const togglePassword = document.getElementById('togglePassword');
  const codigoTexto = document.getElementById('codigoTexto');
  const codigoReal = "<?php echo $datos->codigo; ?>";
  let oculto = true;

  // Iniciar oculto
  codigoTexto.textContent = "••••";

  togglePassword.addEventListener('click', function () {
    if (oculto) {
      codigoTexto.textContent = codigoReal;
      this.classList.remove('fa-eye');
      this.classList.add('fa-eye-slash');
    } else {
      codigoTexto.textContent = "••••";
      this.classList.remove('fa-eye-slash');
      this.classList.add('fa-eye');
    }
    oculto = !oculto;
  });
</script>

</body>
</html>
