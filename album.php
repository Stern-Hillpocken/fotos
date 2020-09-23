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

        <?php
        if(file_exists('./storage/'.$_GET['a'].'/informations.txt')){
          $info = file('./storage/'.$_GET['a'].'/informations.txt', FILE_SKIP_EMPTY_LINES);
          $folderInfo = '';
          for($i = 0; $i < count($info); $i++){
            $readLine = substr($info[$i], 0, strlen($info[$i])-2);//remove line break
            if($i === count($info)-1){//</info>$ @ end of file
              $readLine = substr($info[$i], 0, strlen($info[$i]));
            }
            $folderInfo .= $readLine;
            if(preg_match('/<\/info>/', $readLine) === 1){//end reading
              $i = count($info);
            } else {
              $folderInfo .= '<br/>';
            }
          }
        } else {
          $folderInfo = '';
        }
        ?>

        <script type="text/javascript">
          let folderInfo = `<?php echo $folderInfo; ?>`;
          folderInfo = folderInfo.replace(/<br\/>/g, '\n');
          folderInfo = folderInfo.replace('<info>', '');
          folderInfo = folderInfo.replace('</info>', '');
          console.log(folderInfo);
          function clearPopup(){
            document.getElementById("popup").innerHTML = '';
          }
          function doEditInfo(folder){
            document.getElementById("popup").innerHTML = '<div id=double-check>Modifier les informations du dossier<br/><span id=double-check-value>'+folder+'</span> ?<br/><form method=POST action="./php/edit-info.php"><input type="hidden" name="album_name" value="'+folder+'"><textarea name=informations style="min-width:90vw; max-width:90vw; min-height:20vh; max-height:85vh">'+folderInfo+'</textarea><br/><div class=yes-or-no><a onclick=clearPopup()>❎ Annuler</a></div><div class=yes-or-no><input type=submit class=input-submit value="☑️ Modifier"></div></form></div>';
          }
          function doAddPicture(folder){
            document.getElementById("popup").innerHTML = '<div id=double-check>Ajouter des images au dossier<br/><span id=double-check-value>'+folder+'</span> ?<br/><form method=POST action="./php/upload.php" enctype="multipart/form-data"><input type="hidden" name="album_name" value="'+folder+'"><input type="file" name="pictures[]" required multiple><br/><div class=yes-or-no><a onclick=clearPopup()>❎ Annuler</a></div><div class=yes-or-no><input type=submit class=input-submit value="☑️ Ajouter"></div></form></div>';
          }
          function doRemoveFile(folder, file){
            document.getElementById("popup").innerHTML = '<div id=double-check>Voulez vous supprimer le fichier<br/><span id=double-check-value>'+file+'</span> ?<br/><img src="./storage/'+folder+'/'+file+'" style="height:25%"><br/><div class=yes-or-no><a onclick=clearPopup()>❎ Annuler</a></div><div class=yes-or-no><a href="./php/rmfile.php?folder='+folder+'&file='+file+'">☑️ Supprimer</a></div></div>';
          }
          function doEditFile(folder, file){
            document.getElementById("popup").innerHTML = '<div id=double-check>Modifier le fichier<br/><span id=double-check-value>'+file+'</span> ?<br/><img src="./storage/'+folder+'/'+file+'" style="height:25%"><br/><form method=POST action="./php/edit-file.php" enctype="multipart/form-data"><input type="hidden" name="album_name" value="'+folder+'"><input type="hidden" name="file_name" value="'+file+'"><label for=file_new_name>Nom du fichier : </label><input name=file_new_name type=text placeholder="IMG_yyyymmdd_hhmmss.jpg"><br/><label for=description>Description : </label><input name=description type=text><br/><div class=yes-or-no><a onclick=clearPopup()>❎ Annuler</a></div><div class=yes-or-no><input type=submit class=input-submit value="☑️ Changer"></div></form></div>';
          }
        </script>
    </head>
    <body>
      <div id=popup></div>
      <header><?php include './php/header.php';?></header>
      <div id="main">
        <div id="informations">
          <h1>
          <?php
            echo $_GET['a'];
            if(isset($_SESSION['edit_mode']) AND $_SESSION['edit_mode'] == 'on'){
              echo '<a onclick="doEditInfo(`'.$_GET['a'].'`)" title="Modifier les informations ?">✏️</a> <a onclick="doAddPicture(`'.$_GET['a'].'`)" title="Ajouter des images ?">🖼️</a>';
            }
          ?>
          </h1>
          <p>
          <?php echo $folderInfo; ?>
          </p>
        </div>
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
      echo '<div class=cadre-photo>';
      if(isset($_SESSION['edit_mode']) AND $_SESSION['edit_mode'] == 'on'){
        $date = '?';
        $time = '?';
        if(preg_match('/^IMG_[0-9]{8}_[0-9]{6}.jpg$/', $arrayNames[$i]) === 1){
          preg_match('/^IMG_([0-9]{8})_([0-9]{6}).jpg$/', $arrayNames[$i], $sections);
          $month = ['error', 'jan', 'fév', 'mars', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'dec'];
          $monthVal = (int)substr($sections[1], 4, 2);
          if($monthVal > 12){$monthVal = 0;}
          $month = $month[$monthVal];
          $date = substr($sections[1], 0, 4).' '.$month.' '.substr($sections[1], 6, 2);
          $time = substr($sections[2], 0, 2).':'.substr($sections[2], 2, 2).':'.substr($sections[2], 4, 2);
        }
        echo '<div class=edit-buttons><a onclick="doRemoveFile(`'.$_GET['a'].'`,`'.$arrayNames[$i].'`)" title="Supprimer le fichier ?">❌ Supprimer</a><br/>📅 '.$date.'<br/>⌚'.$time.'<br/><a onclick="doEditFile(`'.$_GET['a'].'`,`'.$arrayNames[$i].'`)" title="Modifier le fichier ?">✏️ Modifier</a></div>';
        echo '<img src="storage/'.$_GET['a'].'/'.$arrayNames[$i].'" />';
      } else {
        echo '<a href="storage/'.$_GET['a'].'/'.$arrayNames[$i].'"><img src="storage/'.$_GET['a'].'/'.$arrayNames[$i].'" /></a>';
      }
      echo '<div class=description>txt<br/>oijfdigjfg fiuhgfuhfg fhjgufh hfhgufg hfughfugh hufg hufhugifuhd ui hfdiu ui hud hf dhdf ugdf hgfd hghdf  gdfuih gdfhu ghf hidf gdfi gdfhu gdfuih gf ugu</div></div>';
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
