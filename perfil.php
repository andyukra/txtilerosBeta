<?php
include 'DB.php';

session_start();
if (!$_SESSION['user']) {
  header('Location:index.html');
  die();
}
$me = $_SESSION['user'];
$query = "SELECT `foto` FROM `usuarios` WHERE `nombre` = '$me'";
$conn = dbConnect();

$res = mysqli_query($conn, $query);

if (!$res) die('No se pudo obtener los datos del usuario');
$user = mysqli_fetch_assoc($res);
function imgPerfil($user)
{
  if (!$user['foto']) {
    return '<ion-icon name="person-circle"></ion-icon>';
  } else {
    $foto = $user['foto'];
    return "<img src='{$foto}' alt='Foto de perfil'/>";
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
  <div class="loader">
    <div class="blob"></div>
  </div>
  <form id="changeAvatar">
    <input id="upAvatar" type="file" hidden accept="image/*">
    <label for="upAvatar">
      <?php echo imgPerfil($user); ?>
    </label>
    <h2><?php echo $me; ?></h2>
    <p>Estado</p>
  </form>
  <main>
    <h2>Mis publicaciones</h2>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
  <script src="perfil.js"> </script>
</body>

</html>