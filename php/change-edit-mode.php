<?php
session_start();
if($_SESSION['edit_mode'] == 'on'){
  $_SESSION['edit_mode'] = 'off';
} else {
  $_SESSION['edit_mode'] = 'on';
}

if(preg_match('/\?a=/', $_GET['uri'])){
  header('Location: '.$_GET['uri'].'&scroll='.$_GET['scroll']);
} else {
  $get_uri = preg_replace('/\?scroll=[0-9]*/', '', $_GET['uri']);
  header('Location: '.$get_uri.'?scroll='.$_GET['scroll']);
}
?>
