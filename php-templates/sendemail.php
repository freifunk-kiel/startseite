<?php
/**
 * Dies ist ein Beispiel für eine PHP Seite, die die Formulardaten empfängt und versendet
 * danach wird zurück an die Bestätigungsseite geleitet
 */

$absender_seite="http://freifunk.in-kiel.de";
$empfaenger = "mailingliste@example.freifunk.net";

$absendername = preg_replace("/[^a-zA-Z \-.,_äöüÄÖÜß\(\)]/","",trim($_REQUEST["name"]));
$absendername = preg_replace("/,/","\,",$absendername);
$absendername = preg_replace("/ä/","ae",$absendername);
$absendername = preg_replace("/ö/","oe",$absendername);
$absendername = preg_replace("/ü/","ue",$absendername);
$absendername = preg_replace("/Ä/","ae",$absendername);
$absendername = preg_replace("/Ö/","oe",$absendername);
$absendername = preg_replace("/Ü/","ue",$absendername);
$absendername = preg_replace("/ß/","ss",$absendername);
if(empty($absendername)){
  header("Location: $absender_seite/fehler.html?message=".rawurlencode("Fehler beim Versenden deiner Email! Der Name ist leer oder enthält ungültige Zeichen!"));
  exit;
}
$absendermail = preg_replace("/[^a-zA-Z \-._@]/","",trim($_REQUEST["from"]));
if(empty($absendermail)) {
  header("Location: $absender_seite/fehler.html?message=".rawurlencode("Fehler beim Versenden deiner Email! Deine Email ist leer oder enthält ungültige Zeichen!"));
  exit;
}
$betreff = "[Kontaktformular Freifunk] $absendername - $absendermail"; 
$text = utf8_decode(trim(strip_tags($_REQUEST["body"]))); 
if(mail($empfaenger, $betreff, $text, "From: \"".utf8_encode($absendername)."\" <$absendermail>")){ 
        header("Location: $absender_seite/bestaetigung.html?message=".rawurlencode("Deine Email wurde erfolgreich versandt.")); 
} else { 
        header("Location: $absender_seite/fehler.html?message=".rawurlencode("Fehler beim Versenden deiner Email!")); 
} 
