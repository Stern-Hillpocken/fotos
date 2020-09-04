<?php
session_start();

if (!isset($_SESSION['password']) OR $_SESSION['password'] != "mdp")
{
	header('Location: ./');
} else {

	$dossier = '../storage/'.$_POST['album_name'].'/';
	$fichier = basename($_FILES['picture']['name']);
	//On formate le nom du fichier ici...
	/*$fichier = strtr($fichier,
			 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
			 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
	$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);*/
	$fichier = 'IMG_'.$_POST['date'].strrchr($_FILES['picture']['name'], '.');
	$taille_maxi = 2000000;
	$taille = filesize($_FILES['picture']['tmp_name']);
	$extensions = array('.png', '.gif', '.jpg', '.jpeg');
	$extension = strrchr($_FILES['picture']['name'], '.');
	//Début des vérifications de sécurité...
	if(!in_array($extension, $extensions)){
	  $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
	}
	if($taille>$taille_maxi){
	  $erreur = 'L\'image est trop lourde...';
	}
	if(file_exists($dossier.$fichier)){
		$erreur = 'Image (ou au moins le nom) déjà existant(e) !';
	}
	if(!isset($erreur)){
	     if(move_uploaded_file($_FILES['picture']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
	     {
	          echo 'Upload effectué avec succès !';
						header('Location: ../album.php?a='.$_POST['album_name']);
	     } else {
	          echo 'Echec de l\'upload !';
						var_dump($_FILES);
	     }
	} else {
	     echo $erreur;
	}

}

?>
