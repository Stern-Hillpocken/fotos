<?php
  session_start();

  function deleteFile($file) {
    if (file_exists($file)) {
        unlink($file);
    }
  }

  if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp" AND isset($_GET['folder']) AND is_dir('../storage/'.$_GET['folder'])) {
    //DELETE TEXT
    $dir = '../storage/'.$_GET['folder'].'/informations.txt';
    $contents = file_get_contents($dir);

    $startInfo = strpos($contents, '#'.$_GET['file']);
    preg_match("/\n#".$_GET['file'].' (...*)/', $contents, $output_array);
    $endInfo = strlen($output_array[0]);

    $contents = substr_replace($contents,'',$startInfo,$endInfo);
    file_put_contents($dir, $contents);

    //DELETE FILE
    deleteFile('../storage/'.$_GET['folder'].'/'.$_GET['file']);
    $_SESSION['feedback'] .= '<br/>✔️ Suppression de l\'image';
    $_SESSION['scroll'] = $_GET['scroll'];
    header('Location: ../album.php?a='.$_GET['folder']);
  } else {
    header('Location: ./../');
  }
?>
