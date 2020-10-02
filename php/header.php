<script>
	function changeEditMode(){
		var newUrl = "http://localhost/fotos/php/change-edit-mode.php?uri=<?php echo $_SERVER['REQUEST_URI'];?>&scroll=" + scrollBarPosition();
		document.location.href = newUrl;
	}
	function scrollBarPosition(){
		return (window.pageYOffset || document.documentElement.scrollTop);
	}

	function feedbackTransition() {
  var el = document.getElementById("feedback");
	if(el){
		el.style.opacity = '0';
		setTimeout(function() {el.style.zIndex = '-1';}, 1000);
	}
}
var intervalID = window.setInterval(feedbackTransition, 2000);
</script>

<?php

echo '<a href=http://localhost/fotos/ style="color:black"><div><img alt="logo" src="./assets/logo.png"> <span>FOTOS</span></div></a>';

if (!isset($_SESSION['password']) OR $_SESSION['password'] != "mdp"){
	echo '<div>Se connecter : <form action="./php/login.php" method="post"><input maxlength="10" size="10" placeholder="password" type="password" name="password" required><input type="hidden" name="uri" value="'.$_SERVER['REQUEST_URI'].'"><input type="submit"></form></div>';
} else {
	echo '<div><a href="./php/logout.php">Déconnexion</a></div>';
	if($_SESSION['feedback'] !== ''){
		echo '<div id=feedback>'.$_SESSION['feedback'].'</div>';
	}
	echo '<div id="edit-mode" title="Actuellement en mode :" onclick="changeEditMode();" style="font-size:2em;">';
	if($_SESSION['edit_mode'] == 'on'){
		echo '📝';
	} else {
		echo '👁️';
	}
	echo '</div>';
}

?>
