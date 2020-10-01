<?php
session_start();

if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp") {
  if(file_exists('../storage/'.$_POST['album_name'].'/'.$_POST['file_name']) AND !file_exists('../storage/'.$_POST['album_name'].'/'.$_POST['file_new_name'])){
    rename('../storage/'.$_POST['album_name'].'/'.$_POST['file_name'], '../storage/'.$_POST['album_name'].'/'.$_POST['file_new_name']);
    echo 'Nom de fichier changé !';
    //format of name.jpg and change
    $dir = '../storage/'.$_POST['album_name'].'/informations.txt';
    $contents = file_get_contents($dir);

    $fileNewName = $_POST['file_new_name'];
    $fileNewName = str_replace('`', "'", $fileNewName);
    $fileNewName = str_replace(' ', "-", $fileNewName);

    $startInfo = strpos($contents, '#'.$_POST['file_name']);
    $endInfo = strlen('#'.$_POST['file_name']);

    if(!isset($error)){
      $contents = substr_replace($contents,'#'.$fileNewName,$startInfo,$endInfo);
      file_put_contents($dir, $contents);
      $_POST['file_name'] = $fileNewName;
    }
  } else if($_POST['file_new_name'] === '') {
    echo 'Pas besoin de changer le nom du fichier.';
  } else {
    echo 'Le fichier '.'../storage/'.$_POST['album_name'].'/'.$_POST['file_new_name'].' existe déjà !';
  }
  if(isset($_POST['description'])){
    echo 'Mise à jour de la description.';
    $dir = '../storage/'.$_POST['album_name'].'/informations.txt';
    $contents = file_get_contents($dir);

    $info = $_POST['description'];
    $info = str_replace('`', "'", $info);
    $info = str_replace('<', '[', $info); $info = str_replace('>', ']', $info);
    $info = str_replace('[b]', '<b>', $info); $info = str_replace('[/b]', '</b>', $info);
    $info = str_replace('[c]', '<span class=hightlight>', $info); $info = str_replace('[/c]', '</span>', $info);
    $info = str_replace('[span class=hightlight]', '<span class=hightlight>', $info); $info = str_replace('[/span]', '</span>', $info);
    $info = str_replace('[i]', '<b>', $info); $info = str_replace('[/b]', '</b>', $info);
    $info = str_replace('[s]', '<s>', $info); $info = str_replace('[/s]', '</s>', $info);
    $info = str_replace('[u]', '<u>', $info); $info = str_replace('[/u]', '</u>', $info);

    $startInfo = strpos($contents, '#'.$_POST['file_name']);
    $startInfo += strlen('#'.$_POST['file_name']);
    preg_match("/\n#".$_POST['file_name'].' (...*)/', $contents, $output_array);
    $endInfo = strlen($output_array[1])+1;

    $contents = substr_replace($contents,' '.$info,$startInfo,$endInfo);
    file_put_contents($dir, $contents);
  }
  header('Location: ../album.php?a='.$_POST['album_name']);
} else {
  header('Location: ./../');
}
?>
