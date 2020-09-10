<?php
session_start();

if (!isset($_SESSION['password']) OR $_SESSION['password'] != "mdp")
{
	header('Location: ./');
} else {

	$dossier = '../storage/'.$_POST['album_name'].'/';

	$filesCount = count($_FILES['pictures']['name']);
	for($i=0; $i < $filesCount; $i++){
		//On formate le nom du fichier
		$fichier = basename($_FILES['pictures']['name'][$i]);
		if(preg_match('/^IMG_[0-9]{8}_[0-9]{6}.jpg$/', $fichier) !== 1){
			$fichier = 'IMG_'.date('Ymd_His').'_'.$i.'.jpg';
		}
		//$taille_maxi = 2000000;
		//$taille = filesize($_FILES['pictures']['tmp_name']);
		$extensions = array('.png', '.gif', '.jpg', '.jpeg');
		$extension = strrchr($_FILES['pictures']['name'][$i], '.');
		//Début des vérifications de sécurité...
		if(!in_array($extension, $extensions)){
		  $erreur = 'Vous devez uploader un fichier de type : png, gif, jpg, jpeg';
		}
		/*if($taille>$taille_maxi){
		  $erreur = 'L\'image est trop lourde...';
		}*/
		if(file_exists($dossier.$fichier)){
			$erreur = 'L\'image (ou au moins le nom) est déjà existante !';
		}
		if(!isset($erreur)){
		     if(move_uploaded_file($_FILES['pictures']['tmp_name'][$i], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
		     {
							header('Location: ../album.php?a='.$_POST['album_name']);
		     } else {
		          echo 'Echec de l\'upload !';
							var_dump($_FILES);
		     }
		} else {
		     echo $erreur;
		}
	}
}

?>
