<?php
session_start();

if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp") {
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
  }
  header('Location: ../album.php?a='.$_POST['album_name']);
} else {
  header('Location: ./../');
}
?>
