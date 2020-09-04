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
        <div id="informations"><h1><?php echo $_GET['a'] ?></h1><p>
          <?php
            $ligne = '';
            if(file_exists('./storage/'.$_GET['a'].'/informations.txt')){
              $informations = fopen('./storage/'.$_GET['a'].'/informations.txt', 'r');
              $ligne = fgets($informations);
              fclose($informations);
            }
            if(isset($_SESSION['edit_mode']) AND $_SESSION['edit_mode'] == 'on'){
              echo '<form action="./php/edit-album.php" method="post"><input type="hidden" name="album_name" value="'.$_GET['a'].'"><textarea name="informations" style="width:100%">'.$ligne.'</textarea>';
              echo '<input type="submit" value="✏️"></form>';
            } else {
              echo $ligne;
            }
          ?>
        </p></div>
        <?php
        if (isset($_SESSION['edit_mode']) AND $_SESSION['edit_mode'] == 'on' AND isset($_SESSION['password']) AND $_SESSION['password'] == "mdp"){
          echo '<div><details><summary><span class=hightlight>A</span>jouter une image <span class=hightlight>>></span></summary><br/><form method="POST" action="./php/upload.php" enctype="multipart/form-data">
            <input type="hidden" name="album_name" value="'.$_GET['a'].'">
            <input type="file" name="picture" required><br/>
            <input type="radio" id="valid-name" name="valid_name" value="valid" checked>
            <label for="valid-name" title="Nom du style IMG_20200904_150042.jpg">Nom : IMG_ymd_hms</label><br/>
            <input type="radio" id="unvalid-name" name="valid_name" value="unvalid">
            <label for="unvalid-name">Autre nom</label><br/>
            <input type="date" name="date" required><br/>
            <input type="text" name="description" placeholder="description"><br/><br/>
            <input type="submit" name="upload" value="Ajouter">
          </form></details></div>';
        }
        ?>
        <div id="album-container">
        <?php
function ScanDirectory($Directory){
    $MyDirectory = opendir($Directory) or die('Erreur');
    $arrayNames = array();
    $i = 0;
    while($Entry = @readdir($MyDirectory)) {
      if($Entry != '.' && $Entry != '..' && $Entry != 'index.php' && $Entry != 'informations.txt'){
          $arrayNames[$i] = $Entry;
          $i ++;
      }
    }
    sort($arrayNames);
    for($i = 0; $i < count($arrayNames); $i ++){
      echo '<div class=cadre-photo><a href="storage/'.$_GET['a'].'/'.$arrayNames[$i].'"><img src="storage/'.$_GET['a'].'/'.$arrayNames[$i].'" /></a><div class=description>txt<br/>oijfdigjfg fiuhgfuhfg fhjgufh hfhgufg hfughfugh hufg hufhugifuhd ui hfdiu ui hud hf dhdf ugdf hgfd hghdf  gdfuih gdfhu ghf hidf gdfi gdfhu gdfuih gf ugu</div></div>';
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
