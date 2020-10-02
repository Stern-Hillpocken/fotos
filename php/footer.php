<?php
  echo 'CC BY-SA 4.0 <a href="https://creativecommons.org/licenses/by-sa/4.0/">>></a><br/>github <a href="https://github.com/Stern-Hillpocken/fotos">>></a>'
?>
<script>
if("<?php echo isset($_SESSION['scroll']); ?>" > 0){
  var scroll = `<?php echo $_SESSION['scroll'] ?>`;
	document.documentElement.scrollTop = scroll;
}
</script>
<?php
  if(isset($_SESSION['scroll'])){
    $_SESSION['scroll'] = 0;
  }
  if(isset($_SESSION['feedback'])){
    $_SESSION['feedback'] = '';
  }
?>
