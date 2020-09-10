<?php
  session_start();
if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp" AND $_POST['folder_name'] != ''){
  $dossier = $_POST['folder_name'];
  $dossier = strtr($dossier,
       'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
       'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
  $dossier = preg_replace('/([^.a-z0-9]+)/i', ' ', $dossier);
  if(file_exists('../storage/'.$dossier)){
		$erreur = 'Dossier (ou au moins le nom) déjà existant !';
	}
  if(!isset($erreur)){
	     if(mkdir('../storage/'.$dossier, 0707)){
	          echo 'Dossier créé avec succès !';
            $informations = fopen('../storage/'.$dossier.'/informations.txt', 'a+');
            fputs($informations, "Description du dossier...");
            fclose($informations);
            header('Location: ../');
	     } else {
	          echo 'Echec !';
	     }
	} else {
	     echo $erreur;
	}
}
?>
