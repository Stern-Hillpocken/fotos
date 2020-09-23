<?php
  session_start();

  function deleteFile($file) {
    if (file_exists($file)) {
        unlink($file);
    }
  }

  if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp" AND isset($_GET['folder']) AND is_dir('../storage/'.$_GET['folder'])) {
    deleteFile('../storage/'.$_GET['folder'].'/'.$_GET['file']);
    header('Location: ../album.php?a='.$_GET['folder']);
  } else {
    header('Location: ./../');
  }
?>
