<?php
require("gtranslate/GTranslate.php");
$languages = parse_ini_file("gtranslate/languages.ini");

// Mettre le repertoire d'origine ici
$path_from = "lang/fr/";
// Mettre le repertoire de destination ici
$path_to = "lang/en/";
// Mettre la langue desiree ici
$lang_to = "english";
$lang_to_iso = $languages[strtoupper($lang_to)];

// On recupere la liste des fichiers contenus dans le repertoire d'origine
$rep = dir($path_from);
$files_to_translate = array();
while ($nametmp = $rep->read()) {
	if (is_file($path_from.$nametmp) && $nametmp!="." && $nametmp!=".." && $nametmp!="Thumbs.db") $files_to_translate[] = $nametmp;
}
$rep->close();

$gt = new Gtranslate;
foreach($files_to_translate as $filename){
	$translation = "";
	// On traite le contenu du fichier ligne par ligne
	$filecontent = file($path_from.$filename);
	foreach($filecontent as $line){
		// Si la ligne contient un variable PHP, alors on traduit
		if(strstr($line,'$')){
			// On extrait le nom et la valeur de la variable
			list($name,$value) = explode("=",$line);
			$value = str_replace('";','',$value);
			$value = str_replace(' "','',$value);
			$value = htmlentities($value);
			// On reecrit la ligne avec la traduction de la valeur de la variable
			$translation .= $name.'= "'.$gt->{"french_to_".$lang_to}($value).'";';
			$translation .= "\n";
		}
		// Si la ligne ne contient pas de variable, alors on recopie la ligne telle quelle
		else {
			$translation .= $line;
		}
	}
	
	// Ecriture du nouveau fichier de langue
	if(!is_dir($path_to)) mkdir($path_to);
	$newfilename = str_replace("_fr","_".$lang_to_iso,$filename);
	$fp = fopen($path_to.$newfilename, "w");
	fwrite($fp,$translation);
	fclose($fp);
}
