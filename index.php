<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="favicon.png" type="image/png"/>
        <link rel="stylesheet" href="css/raw.css" />
        <title>Accueil | Fotos</title>
    </head>
    <body>
      <header><?php include './php/header.php';?></header>
      <div id="main">
        <?php
function ScanDirectory($Directory){
    $MyDirectory = opendir($Directory) or die('Erreur');
    $arrayNames = array();
    $i = 0;
    while($Entry = @readdir($MyDirectory)) {
        if(is_dir($Directory.'/'.$Entry) && $Entry != '.' && $Entry != '..'){
          $arrayNames[$i] = $Entry;
          $i ++;
        }
    }
    sort($arrayNames);
    for($i = 0; $i < count($arrayNames); $i ++){
      echo '<div style="display: inline-block; margin: 16px;"><a href="album.php?a='.$arrayNames[$i].'" class="folder">'.$arrayNames[$i].'</a>';
      if(isset($_SESSION['edit_mode']) AND $_SESSION['edit_mode'] == 'on'){
        echo '<a href="./php/rmdir.php?folder='.$arrayNames[$i].'" title="Supprimer le dossier définitivement">❌</a>';
      }
      echo '</div>';
    }
  closedir($MyDirectory);
}

ScanDirectory('storage');
        ?>
      <?php
      if (isset($_SESSION['password']) && $_SESSION['password'] == "mdp")
      {
        echo '<form action="./php/mkdir.php" method="post"><input maxlength="20" size="20" placeholder="folder name" type="text" name="folder_name" required><input type="submit" value="Créer dossier"></form>';
      }
      ?>
      </div>
      <footer><?php include './php/footer.php';?></footer>
    </body>
</html>
