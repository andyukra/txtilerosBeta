<?php
session_start();
if (!$_SESSION['user']) {
  header('Location:index.html');
  die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Txtileros</title>
  <link rel="stylesheet" href="public/home.css">
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
  <p id="yo" hidden><?php echo $_SESSION['user'] ?></p>
  <div class="modalComments">
    <div class="closeComments"></div>
    <div class="commentsInput">
      <input type="text" placeholder="Escribe un comentario..." maxlength="150" minlength="1" />
      <button class="sendComment">
        <ion-icon name="paper-plane"></ion-icon>
      </button>
    </div>
    <div class="commentsBX">
    </div>
  </div>
  <div class="modalImg">
    <ion-icon id="closeModalImg" name="close-circle-outline"></ion-icon><img src="" alt="Imagen Seleccionada">
  </div>
  <div class="loader">
    <div class="blob"></div>
  </div>
  <div class="modalPub">
    <ion-icon id="closeModal" name="close-circle-outline"></ion-icon>
    <h1>Publicar</h1>
    <form action="publicate.php" method="POST" enctype="multipart/form-data" id="publish">
      <textarea rows="4" placeholder="Escribe un mensaje..." name="text" maxlength="250"></textarea>
      <input id="filePubImg" type="file" hidden accept="image/*" name="image">
      <input id="filePubDoc" type="file" hidden accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" name="document">
      <input id="categoria" type="text" hidden name="category">
      <div class="btns">
        <label for="filePubImg">
          <ion-icon name="images"></ion-icon>
          <p>imágen</p>
        </label>
        <label for="filePubDoc">
          <ion-icon name="document-text"></ion-icon>
          <p>Documento</p>
        </label>
      </div>
      <button>Publicar </button>
    </form>
  </div>
  <header>
    <nav>
      <h1>TX</h1>
      <div class="navIcons">
        <ion-icon id="addPub" style="color:#8f03ec;font-size:2rem" name="add-circle"></ion-icon>
        <ion-icon name="search"></ion-icon>
        <ion-icon name="notifications"></ion-icon>
        <a href="perfil.php">
          <ion-icon name="person-circle"></ion-icon>
        </a>
      </div>
    </nav>
    <div class="tabs">
      <div class="tab activeTab" tab="todos">
        <ion-icon name="people"></ion-icon>
        <p>Todos</p>
      </div>
      <div class="tab" tab="maria">
        <ion-icon name="time"></ion-icon>
        <p>María</p>
      </div>
      <div class="tab" tab="ayelen">
        <ion-icon name="color-palette"></ion-icon>
        <p>Ayelen</p>
      </div>
      <div class="tab" tab="melina">
        <ion-icon name="bar-chart"></ion-icon>
        <p>Melina</p>
      </div>
      <div class="tab" tab="vicky">
        <ion-icon name="shirt"></ion-icon>
        <p>vicky</p>
      </div>
      <div class="tab" tab="erika">
        <ion-icon name="cut"></ion-icon>
        <p>Erika</p>
      </div>
      <div class="tab" tab="ingles">
        <ion-icon name="text"></ion-icon>
        <p>Inglés</p>
      </div>
    </div>
  </header>
  <main>
    <div class="container"></div>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
  <script src="home.js"> </script>
</body>

</html>