<?php
include 'DB.php';

session_start();
$me = $_SESSION['user'] ?? '';
$user = null;

if(isset($_GET)) {

  $userPerfil = $_GET['user'] ?? '';
  if(!$userPerfil) die('No se especifico un usuario');
  $query = "SELECT `foto`, `portada`, `nombre` FROM `usuarios` WHERE `nombre` = '$userPerfil'";
  $conn = dbConnect();
  $res = mysqli_query($conn, $query);
  if (!$res) die('No se pudo obtener los datos del usuario');
  $user = mysqli_fetch_assoc($res);
  if(!$user) die('El usuario no existe');

}

//H A N D L E R S

function imgPerfil($user)
{
  if (!$user['foto']) {
    return '<ion-icon name="person-circle"></ion-icon>';
  } else {
    $foto = $user['foto'];
    return "<img src='{$foto}' alt='Foto de perfil'/>";
  }
}
function imgPortada($user)
{
  if (!$user['portada']) {
    return '';
  } else {
    $foto = $user['portada'];
    return "<img src='{$foto}' hidden id='portada'/>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
  <link rel="stylesheet" href="public/perfil.css">
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
  <p id="usuario" hidden>
    <?php echo $user['nombre'] ?>
  </p>
  <p id="yo" hidden>
    <?php echo $me; ?>
  </p>
  <div class="loader">
    <div class="blob"></div>
  </div>
  <header>
    <?php echo imgPortada($user); ?>
    <input type="file" id="upPortada" hidden accept="image/*">
    <input id="upAvatar" type="file" hidden accept="image/*">
    <label class="upPortada" for="upPortada">
    </label>
    <label class="upAvatar" for="upAvatar">
      <?php echo imgPerfil($user); ?>
    </label>
    <h2><?php echo $user['nombre']; ?></h2>
  </header>
  <main>
    <h2>MIS PUBLICACIONES</h2>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
  <script src="perfil.js"> </script>
</body>

</html>