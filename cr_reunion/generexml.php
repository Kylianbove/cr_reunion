<?php
if(!isset($_SESSION['Username'])){
  $affichage = "affichage = 0";
}

if(!empty($users)){

  if($users['typeUser'] == 1){
  $affichage = "(affichage = 0 OR affichage = 1)";
  }
  if($users['typeUser'] == 2){
  $affichage = "(affichage = 0 OR affichage = 1 OR affichage = 2)";
  }
  if($users['typeUser'] == 3){
  $affichage = "(affichage = 0 OR affichage = 1 OR affichage = 2 OR affichage = 3)";
  }
}
if(!empty($contributeur) || !empty($moderateur) || !empty($administrateur)){
  $affichage = "(affichage = 0 OR affichage = 1 OR affichage = 2 OR affichage = 3 OR affichage = 4)";
}

$select = $connexion->query("SELECT *, DATE_FORMAT(date_debut, \"%Y-%m-%d\") as date_debut, DATE_FORMAT(date_fin, \"%Y-%m-%d\") as date_fin FROM planning WHERE publier = 1 AND annuler = 0 AND $affichage");

$xmlFile = new DOMDocument('1.0', 'utf-8');
$xmlFile->appendChild($monthly = $xmlFile->createElement('monthly'));

while($rs = $select->fetch(PDO::FETCH_ASSOC)){
  $monthly->appendChild($event = $xmlFile->createElement('event'));
  $event->appendChild($xmlFile->createElement('id', $rs['id_planning']));
  $event->appendChild($xmlFile->createElement('name', $rs['titre']));
  $event->appendChild($xmlFile->createElement('startdate', $rs['date_debut']));
  $event->appendChild($xmlFile->createElement('enddate', $rs['date_fin']));
  $event->appendChild($xmlFile->createElement('color', $rs['couleur']));
  $event->appendChild($xmlFile->createElement('affichage', $rs['affichage']));
}

$xmlFile->formatOutput = true;
$xmlFile->save('events.xml');
?>
