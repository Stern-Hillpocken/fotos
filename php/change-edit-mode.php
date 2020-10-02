<?php
session_start();
if($_SESSION['edit_mode'] == 'on'){
  $_SESSION['edit_mode'] = 'off';
} else {
  $_SESSION['edit_mode'] = 'on';
}

if(preg_match('/\?a=/', $_GET['uri'])){
  $_SESSION['scroll'] = $_GET['scroll'];
  header('Location: '.$_GET['uri']);
} else {
  $get_uri = preg_replace('/\?scroll=[0-9]*/', '', $_GET['uri']);
  $_SESSION['scroll'] = $_GET['scroll'];
  header('Location: '.$get_uri);
}
?>
