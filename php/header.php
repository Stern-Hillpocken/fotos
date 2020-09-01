<script>
	function displayScrollBarPosition(){
		var newUrl = "http://localhost/fotos/php/change-edit-mode.php?uri=<?php echo $_SERVER['REQUEST_URI'];?>&scroll="+(window.pageYOffset || document.documentElement.scrollTop);
		document.location.href = newUrl;
	}
</script>

<?php

echo '<a href=http://localhost/fotos/ style="color:black"><div><img alt="logo" src="./assets/logo.png"> <span>FOTOS</span></div></a>';

if (!isset($_SESSION['password']) OR $_SESSION['password'] != "mdp"){
	echo '<div>Se connecter : <form action="./php/login.php" method="post"><input maxlength="10" size="10" placeholder="password" type="password" name="password" required><input type="hidden" name="uri" value="'.$_SERVER['REQUEST_URI'].'"><input type="submit"></form></div>';
} else {
	echo '<div><a href="./php/logout.php">Déconnexion</a></div><div id="edit-mode" title="Actuellement en mode :" onclick="displayScrollBarPosition();">';
	if($_SESSION['edit_mode'] == 'on'){
		echo '📝';
	} else {
		echo '👁️';
	}
	echo '</div>';
}

?>
