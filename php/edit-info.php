<?php
session_start();

if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp") {
  if(isset($_POST['new_album_name'])){
//
    $dossier = $_POST['new_album_name'];
    $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    $dossier = strtr($dossier, $unwanted_array);
    $dossier = preg_replace('/([^.a-z0-9]+)/i', ' ', $dossier);
    //remove firsts space
    while(substr($dossier,0,1) === ' '){
      $dossier = substr($dossier,1,strlen($dossier));
    }
    //remove lasts space
    while(substr($dossier,strlen($dossier)-1,strlen($dossier)) === ' '){
      $dossier = substr($dossier,0,strlen($dossier)-1);
    }
    //
    if(file_exists('../storage/'.$dossier) AND $dossier !== $_POST['album_name']){
      $erreur = '<br/><span class=hightlight>⚠️ Nom de dossier déjà existant !</span>';
    }
//
    if(!isset($erreur)){
      if($dossier !== $_POST['album_name']){
        $_SESSION['feedback'] .= '<br/>✔️ Nom de dossier changé : '.$_POST['album_name'].' > '.$dossier;
        rename('../storage/'.$_POST['album_name'], '../storage/'.$dossier);
        $_POST['album_name'] = $dossier;
      } else {
        echo 'Pas besoin de changer le nom.';
      }
    } else {
      $_SESSION['feedback'] .= $erreur;
    }

  }
  if(isset($_POST['informations'])) {
    $dir = '../storage/'.$_POST['album_name'].'/informations.txt';
    $contents = file_get_contents($dir);

    $info = $_POST['informations'];
    $info = str_replace('`', "'", $info);
    $info = str_replace('<', '[', $info); $info = str_replace('>', ']', $info);
    $info = str_replace('[b]', '<b>', $info); $info = str_replace('[/b]', '</b>', $info);
    $info = str_replace('[c]', '<span class=hightlight>', $info); $info = str_replace('[/c]', '</span>', $info);
    $info = str_replace('[span class=hightlight]', '<span class=hightlight>', $info); $info = str_replace('[/span]', '</span>', $info);
    $info = str_replace('[i]', '<b>', $info); $info = str_replace('[/b]', '</b>', $info);
    $info = str_replace('[s]', '<s>', $info); $info = str_replace('[/s]', '</s>', $info);
    $info = str_replace('[u]', '<u>', $info); $info = str_replace('[/u]', '</u>', $info);
    $info = str_replace('<info>', '', $info);
    $info = str_replace('</info>', '', $info);

    $startInfo = strpos($contents, '<info>');
    $startInfo += 6;
    $endInfo = strpos($contents, '</info>');
    $endInfo -= 6;

    $contents = substr_replace($contents,'',$startInfo,$endInfo);
    $contents = str_replace('<info></info>', '<info>'.$info.'</info>', $contents);

    file_put_contents($dir, $contents);
    $_SESSION['feedback'] .= '<br/>✔️ Informations mises à jour.';
  }
  header('Location: ../album.php?a='.$_POST['album_name']);
} else {
  header('Location: ./../');
}
?>
