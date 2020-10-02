<?php
  session_start();
if (isset($_SESSION['password']) AND $_SESSION['password'] == "mdp" AND $_POST['folder_name'] != ''){
//
  $dossier = $_POST['folder_name'];
  $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
  $dossier = strtr($dossier, $unwanted_array);
  $dossier = preg_replace('/([^.a-z0-9]+)/i', ' ', $dossier);
  if(file_exists('../storage/'.$dossier)){
		$erreur = '<br/><span class=hightlight>⚠️ Nom de dossier déjà existant !</span>';
	}
  //remove firsts space
  while(substr($dossier,0,1) === ' '){
    $dossier = substr($dossier,1,strlen($dossier));
  }
  //remove lasts space
  while(substr($dossier,strlen($dossier)-1,strlen($dossier)) === ' '){
    $dossier = substr($dossier,0,strlen($dossier)-1);
  }
//
  if(!isset($erreur)){
	     if(mkdir('../storage/'.$dossier, 0707)){
	          $_SESSION['feedback'] .= '<br/>✔️ Dossier créé avec succès !';
            $informations = fopen('../storage/'.$dossier.'/informations.txt', 'a+');
            fputs($informations, "<info>Description du dossier...</info>");
            fclose($informations);
            header('Location: ../');
	     } else {
	          $_SESSION['feedback'] .= '<br/><span class=highlight>⚠️ Echec de permission !</span>';
	     }
	} else {
	     $_SESSION['feedback'] .= $erreur;
	}
  header('Location: ./../');
} else {
  header('Location: ./../');
}
?>
