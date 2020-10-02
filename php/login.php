<?php
session_start();
$_SESSION['password'] = $_POST['password'];
$_SESSION['edit_mode'] = 'off';
$_SESSION['scroll'] = 0;
$_SESSION['feedback'] = '';
header('Location: '.$_POST['uri']);
?>
