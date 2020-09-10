<?php
session_start();

if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp") {
  if(isset($_POST['informations'])) {
    $file = fopen('../storage/'.$_POST['album_name'].'/informations.txt', 'r+');
    fseek($file, 0);
    fputs($file, $_POST['informations']);
    fclose($file);
  }
  header('Location: ../album.php?a='.$_POST['album_name']);
}
?>
