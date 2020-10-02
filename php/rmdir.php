<?php
  session_start();

  function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

  if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp" AND isset($_GET['folder']) AND is_dir('../storage/'.$_GET['folder'])) {
    deleteDirectory('../storage/'.$_GET['folder']);
    $_SESSION['feedback'] .= '<br/>✔️ Dossier supprimé.';
    header('Location: ../');
  } else {
    header('Location: ./../');
  }
?>
