<?php
session_start();

if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp") {
  if(file_exists('../storage/'.$_POST['album_name'].'/'.$_POST['file_name'])){
    rename('../storage/'.$_POST['album_name'].'/'.$_POST['file_name'], '../storage/'.$_POST['album_name'].'/'.$_POST['file_new_name']);
    header('Location: ../album.php?a='.$_POST['album_name']);
  } else {
    echo 'Le fichier '.'../storage/'.$_POST['album_name'].'/'.$_POST['file_name'].' existe déjà !';
  }
} else {
  header('Location: ./../');
}
?>
