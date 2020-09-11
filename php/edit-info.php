<?php
session_start();

if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp") {
  if(isset($_POST['informations'])) {
    $dir = '../storage/'.$_POST['album_name'].'/informations.txt';
    $contents = file_get_contents($dir);

    $info = $_POST['informations'];
    $info = str_replace('`', "'", $info);
    $info = str_replace('<info>', '', $info);
    $info = str_replace('</info>', '', $info);

    $startInfo = strpos($contents, '<info>');
    $startInfo += 6;
    $endInfo = strpos($contents, '</info>');
    $endInfo -= 6;

    $contents = substr_replace($contents,'',$startInfo,$endInfo);
    $contents = str_replace('<info></info>', '<info>'.$info.'</info>', $contents);

    file_put_contents($dir, $contents);
  }
  header('Location: ../album.php?a='.$_POST['album_name']);
}
?>
