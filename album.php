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
            if(preg_match('/<\/info>$/', $info[$i]) === 1){//</info>$ @ end of line
              $readLine = substr($info[$i], 0, strlen($info[$i])-1);
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

        //OPTIONS
        $dir = './storage/'.$_GET['a'].'/informations.txt';
        $contents = file_get_contents($dir);
        preg_match("\n/#".'options (...*)/', $contents, $options);
        $optionsSeparation = false;
        if(isset($options[1])){
          //separation
          preg_match('/separation/', $options[1], $optionsSeparation);
          if(isset($optionsSeparation) AND count($optionsSeparation) === 1){
            $optionsSeparation = true;
          }
        }
        ?>

        <script type="text/javascript">
          let folderInfo = `<?php echo $folderInfo; ?>`;
          folderInfo = folderInfo.replace(/<br\/>/g, '\n');
          folderInfo = folderInfo.replace('<info>', '');
          folderInfo = folderInfo.replace('</info>', '');
          let optionsSeparation = `<?php echo $optionsSeparation; ?>`;
          if(optionsSeparation === "1"){optionsSeparation = "checked";}
          else{optionsSeparation = "";}
          function clearPopup(){
            document.getElementById("popup").innerHTML = '';
          }
          function doEditInfo(folder){
            document.getElementById("popup").innerHTML = '<div id=double-check>Modifier les informations du dossier<br/><span id=double-check-value>'+folder+'</span> ?<br/><br/><form method=POST action="./php/edit-info.php"><input type="hidden" name="album_name" value="'+folder+'"><label for="new_album_name">Titre : </label><input type="text" value="'+folder+'" name="new_album_name" required><br/><br/><label for="separation">Séparation par journée : </label><input type=checkbox name="separation" id=separation style="transform: scale(2);" '+optionsSeparation+'><br/><br/><label for="informations">Description :</label><br/><textarea name=informations style="min-width:90vw; max-width:90vw; min-height:20vh; max-height:85vh">'+folderInfo+'</textarea><br/><br/><div class=yes-or-no><a onclick=clearPopup()>❎ Annuler</a></div><div class=yes-or-no><input type=submit class=input-submit value="☑️ Modifier"></div></form></div>';
          }
          function doAddPicture(folder){
            document.getElementById("popup").innerHTML = '<div id=double-check>Ajouter des images au dossier<br/><span id=double-check-value>'+folder+'</span> ?<br/><br/><form method=POST action="./php/upload.php" enctype="multipart/form-data"><input type="hidden" name="album_name" value="'+folder+'"><input type="file" name="pictures[]" required multiple><br/><br/><div class=yes-or-no><a onclick=clearPopup()>❎ Annuler</a></div><div class=yes-or-no><input type=submit class=input-submit value="☑️ Ajouter"></div></form></div>';
          }
          function doRemoveFile(folder, file){
            document.getElementById("popup").innerHTML = '<div id=double-check>Voulez vous supprimer le fichier<br/><span id=double-check-value>'+file+'</span> ?<br/><br/><img src="./storage/'+folder+'/'+file+'" style="height:25%"><br/><br/><div class=yes-or-no><a onclick=clearPopup()>❎ Annuler</a></div><div class=yes-or-no><a href="./php/rmfile.php?folder='+folder+'&file='+file+ '&scroll='+scrollBarPosition()+'">☑️ Supprimer</a></div></div>';
          }
          function doEditFile(folder, file, desc){
            document.getElementById("popup").innerHTML = '<div id=double-check>Modifier le fichier<br/><span id=double-check-value>'+file+'</span> ?<br/><br/><img src="./storage/'+folder+'/'+file+'" style="height:25%"><br/><br/><form method=POST action="./php/edit-file.php" enctype="multipart/form-data"><input type="hidden" name="scroll" value="'+scrollBarPosition()+'"><input type="hidden" name="album_name" value="'+folder+'"><input type="hidden" name="file_name" value="'+file+'"><label for=file_new_name>Nom du fichier : </label><input name=file_new_name type=text placeholder="IMG_yyyymmdd_hhmmss.jpg"><br/><br/><label for=description>Description : </label><input name=description type=text value="'+desc+'"><br/><br/><div class=yes-or-no><a onclick=clearPopup()>❎ Annuler</a></div><div class=yes-or-no><input type=submit class=input-submit value="☑️ Changer"></div></form></div>';
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
              echo ' <span style="font-size:0.68em"><a onclick="doEditInfo(`'.$_GET['a'].'`)" title="Modifier les informations ?">✏️</a> <a onclick="doAddPicture(`'.$_GET['a'].'`)" title="Ajouter des images ?">🖼️</a></span>';
            }
          ?>
          </h1>
          <p>
          <?php echo $folderInfo; ?>
          </p>
        </div>
        <div id="album-container">
        <?php
function ScanDirectory($Directory, $optionsSeparation){
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

    function dateTime($IMGname){
      $date = '?';
      $time = '?';
      if(preg_match('/^IMG_[0-9]{8}_[0-9]{6}.jpg$/', $IMGname) === 1){
        preg_match('/^IMG_([0-9]{8})_([0-9]{6}).jpg$/', $IMGname, $sections);
        $month = ['error', 'jan', 'fév', 'mars', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'dec'];
        $monthVal = (int)substr($sections[1], 4, 2);
        if($monthVal > 12){$monthVal = 0;}
        $month = $month[$monthVal];
        $date = substr($sections[1], 0, 4).' '.$month.' '.substr($sections[1], 6, 2);
        $time = substr($sections[2], 0, 2).':'.substr($sections[2], 2, 2).':'.substr($sections[2], 4, 2);
      }
      return [$date, $time];
    }

    for($i = 0; $i < count($arrayNames); $i ++){
      //DATE
      $date = dateTime($arrayNames[$i])[0];
      $time = dateTime($arrayNames[$i])[1];

      //SEPARATION
      if($optionsSeparation AND ($i===0 OR dateTime($arrayNames[$i])[0] !== dateTime($arrayNames[$i-1])[0])){
        if($i !== 0){
          preg_match('/^([0-9]{4}) (...*) ([0-9]{2})$/', dateTime($arrayNames[$i-1])[0], $sepOldDate);
        }
        preg_match('/^([0-9]{4}) (...*) ([0-9]{2})$/', dateTime($arrayNames[$i])[0], $sepDate);
        if(isset($sepDate[1])){
          if($i===0 OR ($sepOldDate[1] !== $sepDate[1])){
            echo '<div class=separation-years>'.$sepDate[1].'</div>';
          }
          echo '<div class=separation>'.$sepDate[3].' '.$sepDate[2].'</div>';
        } else {
          echo '<div class=separation-years>Images non datées</div>';
        }
      }

      //CADRE
      echo '<div class=cadre-photo>';
      //IMAGE DESCRIPTION
      $divDescription = '';
      $imgStyle = "width:100%;";
      if(file_exists('./storage/'.$_GET['a'].'/informations.txt')){
        $fileDescription = ' ';
        //grep
        $info = file('./storage/'.$_GET['a'].'/informations.txt', FILE_SKIP_EMPTY_LINES);
        for($j = 0; $j < count($info); $j++){
          $readLine = substr($info[$j], 0, strlen($info[$j])-1);//remove line break
          if($j === count($info)-1){// end of file
            $readLine = substr($info[$j], 0, strlen($info[$j]));
          }
          if(preg_match('/^#'.$arrayNames[$i].'/', $readLine) === 1){
            preg_match('/#'.$arrayNames[$i].' (...*)/', $readLine, $out);
            if(isset($out[1])){
              $fileDescription = $out[1];
            }
          }
        }
        //display
        if($fileDescription != ' '){
          $divDescription = '<div class=description>'.$fileDescription.'</div>';
          $imgStyle = "width:80%;";
        }
      } else {
        $divDescription = '<div class=description>Manque le fichier informations.txt</div>';
      }

      //EDIT MODE INFORMATIONS
      if(isset($_SESSION['edit_mode']) AND $_SESSION['edit_mode'] == 'on'){
        echo '<div class=edit-buttons><a onclick="doRemoveFile(`'.$_GET['a'].'`,`'.$arrayNames[$i].'`)" title="Supprimer le fichier ?">❌ Supprimer</a><br/>📅 '.$date.'<br/>⌚'.$time.'<br/><a onclick="doEditFile(`'.$_GET['a'].'`,`'.$arrayNames[$i].'`,`'.$fileDescription.'`)" title="Modifier le fichier ?">✏️ Modifier</a></div>';
        echo '<img src="storage/'.$_GET['a'].'/'.$arrayNames[$i].'" style="'.$imgStyle.'" />';
      } else {
        echo '<a href="storage/'.$_GET['a'].'/'.$arrayNames[$i].'"><img src="storage/'.$_GET['a'].'/'.$arrayNames[$i].'" style="'.$imgStyle.'" /></a>';
      }
      //
      echo $divDescription;
      echo '</div>';
    }
  closedir($MyDirectory);
}

ScanDirectory('storage/'.$_GET['a'],$optionsSeparation);
        ?>
        </div>
      </div>
      <footer><?php include './php/footer.php';?></footer>
    </body>
</html>
