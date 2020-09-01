<?php
session_start();
$_SESSION['password'] = $_POST['password'];
$_SESSION['edit_mode'] = 'off';
header('Location: '.$_POST['uri']);
?>
