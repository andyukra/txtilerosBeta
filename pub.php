<?php

include 'DB.php';
session_start();

$me = $_SESSION['user'] ?? '';
$user = null;
$pub = null;
$conn = dbConnect();

if ($me) {
  $query = "SELECT `foto` FROM `usuarios` WHERE `nombre` = '$me'";
  $res = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($res);
}

if (isset($_GET)) {

  $pubId = $_GET['pubId'];
  if (!$pubId) die('No se encontro la publicacion');
  $query = "SELECT publicaciones.*, usuarios.foto FROM publicaciones, usuarios WHERE publicaciones.id = '$pubId' limit 1";
  $res = mysqli_query($conn, $query);
  $pub = mysqli_fetch_assoc($res);

  if (!$pub) echo '<h1>No se encontro la publicacion</h1>';
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

function navFilter($me, $user)
{
  if ($me) {
    echo '<div class="navIcons">';
    echo '<ion-icon name="search"></ion-icon>';
    echo '<ion-icon name="notifications"></ion-icon>';
    echo "<a href='perfil.php?user={$me}' >";
    echo imgPerfil($user);
    echo '</a>';
    echo '</div>';
  } else {
    echo '<a href="registro.html">Registrarme</a>';
  }
}

function autorFilter($pub) {
  $foto = $pub['foto'] ?? '';
  if($foto) {
    echo "<img src='{$foto}' alt='imagen de la publicacion'>";
  } else {
    echo '<ion-icon name="person-circle"></ion-icon>';
  }

}

function filterCuerpo($pub) {
  $texto = $pub['texto'] ?? '';
  $img = $pub['imagen'] ?? '';
  $doc = $pub['documento'] ?? '';
  $docName = preg_replace('/.*\/.*\//', '', $doc) ?? '';
  if($texto) echo "<p>{$texto}</p>";
  if($img) echo "<img src='{$img}' alt='Imagen de la publicacion'/>";
  if($doc) echo "<div class='document'>
                  <a href='{$doc}' download>{$docName}</a>
                  <ion-icon name='arrow-down-circle'></ion-icon>
                </div>";

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Txtileros</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <link rel="stylesheet" href="public/pub.css">
</head>

<body>
  <header>
    <nav>
      <a href="index.html">
        <h1>TX</h1>
      </a>
      <?php echo navFilter($me, $user); ?>
    </nav>
  </header>
  <main>
    <div class="autor">
      <?php echo autorFilter($pub) ?>
      <div class="data">
        <h2><?php echo $pub['autor'] ?></h2>
        <p><?php echo $pub['fecha'] ?></p>
      </div>
    </div>
    <div class="cuerpo">
      <?php filterCuerpo($pub) ?>
    </div>
  </main>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
  <script src="pub.js"> </script>
</body>

</html>