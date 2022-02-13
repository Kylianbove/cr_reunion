<?php
$code = $_GET['code'];
include ("db.php");

/*echo $code;
$resultat = $connexion->query('SELECT id FROM users WHERE code = "'.$code.'" ' );
echo $resultat;
$resultat->execute();*/
$stmt = $connexion->prepare("SELECT code FROM users WHERE code=?");
$stmt->execute(array($code));
$resultat = $stmt->fetch();

echo "voici le code de validation de votre inscription: ".$resultat['code'];
?>
</br>
<a href="codeinscription.php?code=<?php echo $code;?>">retourner sur la page de validation</a>
