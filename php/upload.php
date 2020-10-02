<?php
session_start();

if (!isset($_SESSION['password']) OR $_SESSION['password'] != "mdp")
{
	header('Location: ./../');
} else {

	$dossier = '../storage/'.$_POST['album_name'].'/';
	$erreurs = '';
	$filesCount = count($_FILES['pictures']['name']);

	for($i=0; $i < $filesCount; $i++){
		$e = ''; //erreur pour le fichier en cours
		$fichier = basename($_FILES['pictures']['name'][$i]);
		$extensions = array('.png', '.gif', '.jpg', '.jpeg');
		$extension = strrchr($_FILES['pictures']['name'][$i], '.');
		//Début des vérifications de sécurité...
		if(!in_array($extension, $extensions)){
		  $erreurs .= '<br/><span class=hightlight>⚠️ '.$fichier.' : Vous devez uploader un fichier de type : png, gif, jpg, jpeg !</span>';
			$e = 'error : file type';
		}
		if(file_exists($dossier.$fichier)){
			$erreurs .= '<br/><span class=hightlight>⚠️ '.$fichier.' : L\'image (ou au moins le nom) est déjà existante !</span>';
			$e = 'error : file name';
		}
		//On formate le nom du fichier
		if(preg_match('/^IMG_[0-9]{8}_[0-9]{6}.jpg$/', $fichier) !== 1){
			$fichier = 'IMG_'.date('Ymd_His').'_'.$i.'.jpg';
		}
		//$taille_maxi = 2000000;
		//$taille = filesize($_FILES['pictures']['tmp_name']);
		/*if($taille>$taille_maxi){
		  $erreur = 'L\'image est trop lourde...';
		}*/
		if($e === ''){//Pas d'erreurs pour le fichier en cours
		     if(move_uploaded_file($_FILES['pictures']['tmp_name'][$i], $dossier . $fichier)) {//Si la fonction renvoie TRUE, c'est que ça a fonctionné...
					 //On ajoute une ligne de texte dans le fichier d'information
					 $informations = fopen('../storage/'.$dossier.'/informations.txt', 'a+');
					 fputs($informations, "\n".'#'.$fichier.' ');
					 fclose($informations);
					 $_SESSION['feedback'] .= '<br/>✔️ Transfert effectué.';
		     } else {
					 $erreurs .= '<br/><span class=hightlight>⚠️ '.$fichier.' upload impossible !</span>';
				 }
		}
	}//end for

	if($erreurs !== ''){
		$_SESSION['feedback'] .= '<br/><span class=hightlight>'.$erreurs.'</span>';
	}
	header('Location: ../album.php?a='.$_POST['album_name']);
}

?>
