<?php
  echo 'CC BY-SA 4.0 <a href="https://creativecommons.org/licenses/by-sa/4.0/">>></a><br/>github link <a href="">>></a>'
?>
<script>
if("<?php echo isset($_GET['scroll']); ?>" > 0){
  var scroll = `<?php echo $_GET['scroll'] ?>`;
	document.documentElement.scrollTop = scroll;
}
</script>
