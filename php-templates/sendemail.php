<?php
/**
 * Dies ist ein Beispiel für eine PHP Seite, die die Formulardaten empfängt und versendet
 * danach wird zurück an die Bestätigungsseite geleitet
 */

$absender_seite="http://freifunk.in-kiel.de";
$empfaenger = "mailingliste@example.freifunk.net";
$absendername = preg_replace("/[^a-zA-Z \-.,_]/","",trim($_REQUEST["name"]));
$absendermail = "formular@example.freifunk.net";

if(empty($_REQUEST["name"])){
	header("Location: $absender_seite/fehler.html?message=".urlencode("Fehler beim Versenden deiner Email! Der Name enthält ungültige Zeichen!"));
}
if(!empty($_REQUEST["from"])) $absenderemail = $_REQUEST["from"];
$betreff = "Kontaktformular Freifunk";
$text = $_REQUEST["body"];
if(mail($empfaenger, $betreff, $text, "From: $absendername <$absendermail>")){
        header("Location: $absender_seite/bestaetigung.html?message=".urlencode("Deine Email wurde erfolgreich versandt."));
} else {
        header("Location: $absender_seite/fehler.html?message=".urlencode("Fehler beim Versenden deiner Email!"));
}
