<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="favicon.png" type="image/png"/>
        <link rel="stylesheet" href="css/raw.css" />
        <title><?php echo $_GET['a'] ?> | Fotos</title>
    </head>
    <body>
      <header><?php include './php/header.php';?></header>
      <div id="main">
        <div id="informations"><h1><?php echo $_GET['a'] ?></h1></div>
        <?php
        if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp"){
          /*echo '<div><details><summary><span class=hightlight>A</span>jouter une image <span class=hightlight>>></span></summary><form method="POST" action="./php/upload.php" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="100000">
            <input type="file" name="picture"><br/>
            <input type="date" name="date"><br/>
            <input type="text" name="description" placeholder="description"><br/>
            <input type="submit" name="upload" value="Ajouter">
          </form></details></div>';*/
          echo '<form method="POST" action="./php/upload.php" enctype="multipart/form-data">
     <input type="hidden" name="album_name" value="'.$_GET['a'].'">
     Fichier : <input type="file" name="avatar">
     <input type="submit" name="envoyer" value="Envoyer le fichier">
</form>';
        }
        ?>
        <div id="album-container">
        <?php
function ScanDirectory($Directory){
    $MyDirectory = opendir($Directory) or die('Erreur');
    while($Entry = @readdir($MyDirectory)) {
      if($Entry != '.' && $Entry != '..' && $Entry != 'index.php'){
          echo '<div class=cadre-photo><a href="storage/'.$_GET['a'].'/'.$Entry.'"><img src="storage/'.$_GET['a'].'/'.$Entry.'" /></a><div class=description>txt<br/>oijfdigjfg fiuhgfuhfg fhjgufh hfhgufg hfughfugh hufg hufhugifuhd ui hfdiu ui hud hf dhdf ugdf hgfd hghdf  gdfuih gdfhu ghf hidf gdfi gdfhu gdfuih gf ugu</div></div>';
      }
    }
  closedir($MyDirectory);
}

ScanDirectory('storage/'.$_GET['a']);
        ?>
        </div>
      </div>
      <footer><?php include './php/footer.php';?></footer>
    </body>
</html>
