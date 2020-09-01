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
      <div>
        <?php
function ScanDirectory($Directory){
    $MyDirectory = opendir($Directory) or die('Erreur');
    while($Entry = @readdir($MyDirectory)) {
        if(is_dir($Directory.'/'.$Entry)&& $Entry != '.' && $Entry != '..'){
          echo '<div style="display: inline-block; margin: 8px;"><a href="album.php?a='.$Entry.'" class="folder">'.$Entry.'</a><img class=delete src="assets/cross.png" /></div>';
        }
    }
  closedir($MyDirectory);
}

ScanDirectory('storage');
        ?>
      </div>
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
