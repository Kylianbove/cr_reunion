<?php
$_SERVER['PHP_AUTH_USER'] = 'inscription@gm.fr';
$pass= '$apr1$y9fi73hd$357hGLyoD4hDB93zoMKFD0';
$_SERVER['PHP_AUTH_PWD'] = $pass;
echo $_SERVER['PHP_AUTH_USER'].$_SERVER['PHP_AUTH_PWD'];
setcookie($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PWD']);
?>
<?php
/*---------------------------------------------------------------*/
/*
Titre : Gestion des mots de passe .htpasswd

URL   : https://phpsources.net/code_s.php?id=379
Auteur           : forty
Website auteur   : http://www.toplien.fr/
Date édition     : 01 Mai 2008
Date mise à jour : 14 Aout 2019
Rapport de la maj:
- fonctionnement du code vérifié
*/
/*---------------------------------------------------------------*/
//Nom du gestionnaire du fichier .htpasswd
define('ADMIN_NAME', 'admin');

//Chemin du fichier .htpasswd
define('FILE_HTPASSWD', dirname(__FILE__) . '/secur-folder/.htpasswd');
//Si vous souhaitez sauvergarder le fichier .htpasswd avant chaque modification
// il faut renseigner le chemin d'un fichier de sauvagarde
define('FILE_HTPASSWD_SAVE', '');

//Mail du webmaster
define('EMAIL_MASTER', $_SERVER['SERVER_ADMIN']);

//ecrit dans un fichier
function ecrire_fichier($nom_fichier, $contenu) {
if (($handle = fopen($nom_fichier, 'w')) !== false) {
if (fputs($handle, $contenu, strlen($contenu)) == false) {
return 'Impossible d\'&eacute;crire "' . $contenu .
'" dans le fichier (' . $nom_fichier . ").\n";
}
fclose($handle);
return '';
} else {
return 'Erreur d\'ouverture du fichier ' . $nom_fichier . ".\n";
}
}

//envoye un mail a l'administrateur
function envoyer_mail($sujet) {
global $login, $pass, $pass_crypte, $message;

$corps  = "\nuser : " . $login;
$corps .= "\nMot de passe : " . $pass;
$corps .= "\nLigne htpasswd : " . $login . ':' . $pass_crypte;
if (isset($_SERVER['REMOTE_USER']))    $corps .= "\n\nRemote user : " . $_SERVER
['REMOTE_USER'];
$corps .= "\nMessage : " . $message;
if (!empty($_SERVER['HTTP_REFERER'])) {
$corps .= "\nProvenance : " . $_SERVER['HTTP_REFERER'];
}
$corps .= "\nPage : " . get_complete_url();
if (!empty($_SERVER['HTTP_USER_AGENT'])) {
$corps .= "\nNavigateur : " . $_SERVER['HTTP_USER_AGENT'];
}
$corps .= "\nAdresse IP : " . $_SERVER['REMOTE_ADDR'];
$corps .= "\nNom de domaine : ".gethostbyaddr($_SERVER['REMOTE_ADDR']);
@mail($_SERVER['HTTP_HOST'] . '<' . EMAIL_MASTER . '>', $sujet, $corps,
'From: ' . $_SERVER['HTTP_HOST'] . '<' . EMAIL_MASTER . '>');
}

// retourne l'url complète de la page courante (avec ou sans les paramètres)
function get_complete_url($sansparam = false) {
if ($sansparam) {
if (isset($_SERVER['SCRIPT_URI'])) {
return $_SERVER['SCRIPT_URI'];
} else {
$uri = explode('?', $_SERVER['REQUEST_URI']);
return 'https://' . $_SERVER['HTTP_HOST'] . $uri[0];
}
} else {
if (isset($_SERVER['SCRIPT_URL']) && isset($_SERVER['REQUEST_URI']) &&
isset($_SERVER['SCRIPT_URI'])) {
return str_replace($_SERVER['SCRIPT_URL'], $_SERVER['REQUEST_URI'],
$_SERVER['SCRIPT_URI']);
} else {
return 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}
}
}

// http://fr.php.net/manual/fr/function.crypt.php#73619
function crypt_apr1_md5($plainpasswd) {
$tmp='';
$salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
$len = strlen($plainpasswd);
$text = $plainpasswd.'$apr1$'.$salt;
$bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd

{0}; }
$bin = pack("H32", md5($text));
for($i = 0; $i < 1000; $i++) {
$new = ($i & 1) ? $plainpasswd : $bin;
if ($i % 3) $new .= $salt;
if ($i % 7) $new .= $plainpasswd;
$new .= ($i & 1) ? $bin : $plainpasswd;
$bin = pack("H32", md5($new));
}
for ($i = 0; $i < 5; $i++) {
$k = $i + 6;
$j = $i + 12;
if ($j == 16) $j = 5;
$tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
}
$tmp = chr(0).chr(0).$bin[11].$tmp;
$tmp = strtr(strrev(substr(base64_encode($tmp), 2)),
"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
"./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
return "$"."apr1"."$".$salt."$".$tmp;
}

// Si le script n'est pas protégé par un fichier .htpasswd le script est
// considéré être lancé par l'administrateur.
$user_logged = empty($_SERVER['REMOTE_USER']) ? ADMIN_NAME : $_SERVER[
'REMOTE_USER'];

if (isset($_POST['login']) && isset($_POST['pass'])) {
$login = $_POST['login'];
$pass = $_POST['pass'];
if (!file_exists(FILE_HTPASSWD)) { //si la page existe dans le cache
echo ecrire_fichier(FILE_HTPASSWD,
'# Fichier des mots de passe généré avec ' . get_complete_url(false) . "\n");
}
$resultat  = '';
$message = '';
$contenu = '';
if (isset($_POST['update'])) {
$pass_crypte = crypt_apr1_md5($pass); // On crypte le mot de passe
if (($user_logged == ADMIN_NAME) || ($user_logged == $login)) {
if ((FILE_HTPASSWD_SAVE != '') && !copy(FILE_HTPASSWD,
FILE_HTPASSWD_SAVE)) {  // Sauvegarde le fichier
$message .= 'La copie du fichier ' . FILE_HTPASSWD . ' en ' .
FILE_HTPASSWD_SAVE . " n'a pas r&eacute;ussi...\n";
} else {
$insere = false;
$handle = fopen(FILE_HTPASSWD, 'r');
// Ouvre le fichier en lecture
if ($handle) {
while (!feof($handle)) {
$buffer = fgets($handle, 4096);
if ((strlen($buffer) > 0) && (($pos = strpos($buffer,
':', 1)) > 0)) {
$utilisateur = substr($buffer, 0, $pos);
if (($difference = strcmp($login, $utilisateur)) ==
0) {  // User existe déjà
 if ($insere == false) {
     $contenu .= $login . ':' . $pass_crypte .
"\n";
     $resultat =
"Modification du mot de passe de l'utilisateur $login.\n";
     $message .= $resultat;
     $insere = true;
 } else {
     $message .=
"Utilisateur $login pr&eacute;sent deux fois : supprime le deuxi&egrave;me.\n";
 }
} elseif ($difference < 0) {
// Trié par ordre alphabétique
 if ($insere == false) {
     $contenu .= $login . ':' . $pass_crypte .
"\n";
     $resultat =
"Cr&eacute;ation du mot de passe de l'utilisateur $login.\n";
     $message .= $resultat;
     $insere = true;
 }
 $contenu .= $buffer;
} else {
 $contenu .= $buffer;
}
} else {
$contenu .= $buffer;
}
}
if ($insere == false) {
// Ajoute en dernière position si pas déjà ajouté
$contenu .= $login . ':' . $pass_crypte . "\n";
$resultat =
"Cr&eacute;ation du mot de passe de l'utilisateur $login.\n";
$message .= $resultat;
$insere = true;
}
fclose($handle);
} else {
$message .= 'Erreur d\'ouverture du fichier ' .
FILE_HTPASSWD . ".\n";
}
$message .= ecrire_fichier(FILE_HTPASSWD, $contenu);
}
envoyer_mail('Changement de mot de passe');
} else {
echo
"Pas d'autorisation de modification du mot de passe de l'utilisateur $login.\n";
}
} elseif (isset($_POST['delete'])) {
if (($user_logged == ADMIN_NAME) && ($login != ADMIN_NAME)) {
// Pas de suppression si pas ADMIN_NAME et pas de suppression du user
// ADMIN_NAME
if ((FILE_HTPASSWD_SAVE != '') && !copy(FILE_HTPASSWD,
FILE_HTPASSWD_SAVE)) {  // Sauvegarde le fichier
$message .= "La copie du fichier " . FILE_HTPASSWD . ' en ' .
FILE_HTPASSWD_SAVE . " n'a pas r&eacute;ussi...\n";
} else {
$supprime = false;
$handle = fopen(FILE_HTPASSWD, 'r');
// Ouvre le fichier en lecture
if ($handle) {
while (!feof($handle)) {
$buffer = fgets($handle, 4096);
if ((strlen($buffer) > 0) && (($pos = strpos($buffer,
':', 1)) > 0)) {
$utilisateur = substr($buffer, 0, $pos);
$pass_crypte = substr($buffer, $pos + 1);
if ($login == $utilisateur) {  // User existe
 if ($supprime == false) {
     $resultat =
"Suppression de l'utilisateur $login.\n";
     $message .= $resultat;
     $supprime = true;
 } else {
     $message .=
"Utilisateur $login pr&eacute;sent deux fois : supprime aussi le" .
" deuxi&egrave;me.\n";
 }
} else {
 $contenu .= $buffer;
}
} else {
$contenu .= $buffer;
}
}
if ($supprime == false) {  // Utilisateur n'existe pas
$resultat =
"L'utilisateur $login n'existe pas dans le fichier.\n";
$message .= $resultat;
}
fclose($handle);
} else {
$message .= "Erreur d'ouverture du fichier " . FILE_HTPASSWD
. ".\n";
}
$message .= ecrire_fichier(FILE_HTPASSWD, $contenu);
}
envoyer_mail('Suppression d\'utilisateur');
} else {
echo "Pas d'autorisation de supprimer l'utilisateur $login.\n";
}
} else {
die("Action \"$submit\" inconnue.\n");
}
die ($resultat);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php
if ($user_logged == ADMIN_NAME) {
?>
<title>Gestion des utilisateurs et de leur mot de passe</title>
<?php } else { ?>
<title>Modification du mot de passe</title>
<?php } ?>
<meta name="robots" content="noindex, follow">
</head>
<body>
<?php if ($user_logged == ADMIN_NAME) { ?>
<?php     if (empty($_SERVER['REMOTE_USER'])) { ?>
<p>Prot&eacute;gez ce script par un fichier .htpasswd!!!</p>
<?php     } ?>
<p>Pour utiliser le fichier .htpasswd, il faut ajouter les lignes suivantes dans
un fichier .htaccess :</p>
<pre>
# Début protection par mot de passe
Authname "Zone prot&eacute;g&eacute;e"
AuthUserFile "<?php echo str_replace('\\', '/', FILE_HTPASSWD); ?>"
AuthGroupFile "/dev/null"
AuthType Basic
&lt;limit GET POST&gt;
require valid-user
&lt;/limit&gt;
# Fin protection par mot de passe</pre>
<?php } ?>
<form method="post" action="">
<?php if ($user_logged == ADMIN_NAME) { ?>
<table>
<tr>
<td><label for="login" accesskey="L">Login</label></td>
<td><input type="text" name="login" id="login"></td>
</tr>
<tr>
<td><label for="pass" accesskey="P">Mot de passe</label></td>
<td><input type="text" name="pass" id="pass"></td>
</tr>
</table>
<table>
<tr>
<td><input type="submit" name="update" value="Modifier"></td>
<td><input type="submit" name="delete" value="Supprimer"
onclick="javascript:return confirm('Etes-vous sur de supprimer cet utilisateur
?');"></td>
<?php } else { ?>
<table>
<tr>
<td><label for="login" accesskey="L">Login</label></td>
<td><input type="text" name="login" value="<?php echo $user_logged;
?>
" readonly id="login"></td>
</tr>
<tr>
<td><label for="pass" accesskey="P">Mot de passe</label></td>
<td><input type="text" name="pass" id="pass"></td>
</tr>
</table>
<table>
<tr>
<td><input type="submit" name="update" value="Modifier"></td>
<?php } ?>
<td><input type="reset" name="reset" value="Annuler"
onclick="javascript:history.back()"></td>
</tr>
</table>
</form>
</body>
</html>
