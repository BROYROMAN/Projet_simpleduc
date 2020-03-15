Traduction de fichiers de langue avec google gtranslate-------------------------------------------------------
Url     : http://codes-sources.commentcamarche.net/source/50108-traduction-de-fichiers-de-langue-avec-google-gtranslateAuteur  : madislakDate    : 14/08/2013
Licence :
=========

Ce document intitulé « Traduction de fichiers de langue avec google gtranslate » issu de CommentCaMarche
(codes-sources.commentcamarche.net) est mis à disposition sous les termes de
la licence Creative Commons. Vous pouvez copier, modifier des copies de cette
source, dans les conditions fixées par la licence, tant que cette note
apparaît clairement.

Description :
=============

Un petit script vite fait qui traduit des fichier de langue PHP via un traitemen
t par lot en utilisant l'API Gtranslate de Google. Evidement, c'est de la traduc
tion automatique donc &ccedil;a vaut ce que &ccedil;a vaut...
<br />
<br />Je 
l'ai laiss&eacute; tel quel car je m'en suis servit une seule et unique fois don
c &ccedil;a vaut pas trop le coup de l'optimiser (pour 4000 lignes &agrave; trad
uire, &ccedil;a valait quand m&ecirc;me le coup de le faire).
<br />
<br />Il 
faut que les fichiers d'origine soient &eacute;crits comme ceci (j'ai mis un exe
mple dans le zip) :
<br />&lt;?php
<br />$var1 = &quot;bla bla&quot;;
<br />$
var2 = &quot;plop plop&quot;;
<br />etc.
<br />?&gt;
<br />
<br />Enjoy !
<
br /><a name='source-exemple'></a><h2> Source / Exemple : </h2>
<br /><pre cla
ss='code' data-mode='basic'>
&lt;?php
require(&quot;gtranslate/GTranslate.php&
quot;);
$languages = parse_ini_file(&quot;gtranslate/languages.ini&quot;);

/
/ Mettre le repertoire d'origine ici
$path_from = &quot;lang/fr/&quot;;
// Met
tre le repertoire de destination ici
$path_to = &quot;lang/en/&quot;;
// Mettr
e la langue desiree ici
$lang_to = &quot;english&quot;;
$lang_to_iso = $langua
ges[strtoupper($lang_to)];

// On recupere la liste des fichiers contenus dans
 le repertoire d'origine
$rep = dir($path_from);
$files_to_translate = array()
;
while ($nametmp = $rep-&gt;read()) {
	if (is_file($path_from.$nametmp) &amp;
&amp; $nametmp!=&quot;.&quot; &amp;&amp; $nametmp!=&quot;..&quot; &amp;&amp; $na
metmp!=&quot;Thumbs.db&quot;) $files_to_translate[] = $nametmp;
}
$rep-&gt;clo
se();

$gt = new Gtranslate;
foreach($files_to_translate as $filename){
	$tr
anslation = &quot;&quot;;
	// On traite le contenu du fichier ligne par ligne

	$filecontent = file($path_from.$filename);
	foreach($filecontent as $line){
	
	// Si la ligne contient un variable PHP, alors on traduit
		if(strstr($line,'$
')){
			// On extrait le nom et la valeur de la variable
			list($name,$value)
 = explode(&quot;=&quot;,$line);
			$value = str_replace('&quot;;','',$value);

			$value = str_replace(' &quot;','',$value);
			$value = htmlentities($value)
;
			// On reecrit la ligne avec la traduction de la valeur de la variable
			
$translation .= $name.'= &quot;'.$gt-&gt;{&quot;french_to_&quot;.$lang_to}($valu
e).'&quot;;';
			$translation .= &quot;\n&quot;;
		}
		// Si la ligne ne cont
ient pas de variable, alors on recopie la ligne telle quelle
		else {
			$tran
slation .= $line;
		}
	}
	
	// Ecriture du nouveau fichier de langue
	if(!i
s_dir($path_to)) mkdir($path_to);
	$newfilename = str_replace(&quot;_fr&quot;,&
quot;_&quot;.$lang_to_iso,$filename);
	$fp = fopen($path_to.$newfilename, &quot
;w&quot;);
	fwrite($fp,$translation);
	fclose($fp);
}
</pre>
<br /><a name=
'conclusion'></a><h2> Conclusion : </h2>
<br />L'API Gtranslate peut &ecirc;tr
e t&eacute;l&eacute;charg&eacute;e ici : <a href='http://code.google.com/p/gtran
slate-api-php/' target='_blank'>http://code.google.com/p/gtranslate-api-php/</a>
