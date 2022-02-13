<?php
if(isset($_GET["dwn"])) {

// Entête pour Ouvrir avec MSExcel
header("content-type: application/vnd.ms-excel");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("content-type: application/msword");
header("content-type: application/pdf");

header("content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=".$_GET ["dwn"]);

flush(); // Envoie le buffer
readfile($_GET["dwn"]); // Envoie le fichier

}
?>
