<?php
/**
 * dies ist ein Beispiel für eine PHP Seite, die die Formulardaten empfängt und versendet
 * danach wird zurück an die Bestätigungsseite geleitet
 */

$absender_seite="http://freifunk.in-kiel.de";
$nodewatcher_mail = "freifunk-knotenalarm@lists.in-kiel.de";
$nodewatcher_url='http://freifunk.discovibration.de/freifunk-nodewatcher.php';
$fromheader="From: \"Freifunk Knotenalarm\" <$nodewatcher_mail>";
$community_TLD="FFKI";
$nodewatcher_name="KNOTENALARM";

if (!empty($_REQUEST["confirm-email"]) and trim($_REQUEST["confirm-email"])!=""){
	$confirmmail=$absendermail=preg_replace("/[^a-zA-Z0-9 \-._@!\\#$%&`*+\/=?^{|}~]/","",trim($_REQUEST["confirm-email"]));
}
if (!empty($_REQUEST["deactivate"]) and trim($_REQUEST["deactivate"])!=""){
	$deactivatemail=$absendermail=preg_replace("/[^a-zA-Z0-9 \-._@!\\#$%&`*+\/=?^{|}~]/","",trim($_REQUEST["deactivate"]));
}
if(!empty($confirmmail)){
	$mess="Du wurdest erfolgreich eingetragen.";
	mail($confirmmail, '['.$community_TLD.'] erfolgreich eingetragen',$mess,$fromheader);
	mail($nodewatcher_mail, '['.$community_TLD.' '.$nodewatcher_name.'] confirmation',$confirmmail,$fromheader);
	header("Location: $absender_seite/bestaetigung.html?message=".rawurlencode($mess));
	exit;
}
if(!empty($deactivatemail)){
	$mess="Du wurdest erfolgreich abgemeldet.";
	mail($deactivatemail, '['.$community_TLD.'] erfolgreich abgemeldet',$mess,$fromheader);
	mail($nodewatcher_mail, '['.$community_TLD.' '.$nodewatcher_name.'] abgemeldet',$deactivatemail,$fromheader);
	header("Location: $absender_seite/bestaetigung.html?message=".rawurlencode($mess));
	exit;
}
$absendername = preg_replace("/[^a-zA-Z0.9 \-.,_äöüÄÖÜß\(\)]/","",trim($_REQUEST["name"]));
$absendername = preg_replace("/,/","\,",$absendername);
$absendername = preg_replace("/ä/","ae",$absendername);
$absendername = preg_replace("/ö/","oe",$absendername);
$absendername = preg_replace("/ü/","ue",$absendername);
$absendername = preg_replace("/Ä/","ae",$absendername);
$absendername = preg_replace("/Ö/","oe",$absendername);
$absendername = preg_replace("/Ü/","ue",$absendername);
$absendername = preg_replace("/ß/","ss",$absendername);
if(empty($absendername)){
  header("Location: $absender_seite/fehler.html?message=".rawurlencode("Fehler beim Versenden deiner Email! der Name ist leer oder enthält ungültige Zeichen!"));
  exit;
}
$absendermail = preg_replace("/[^a-zA-Z0-9 \-._@!\\#$%&`*+\/=?^{|}~]/","",trim($_REQUEST["from"]));
if(empty($absendermail)) {
  header("Location: $absender_seite/fehler.html?message=".rawurlencode("Fehler beim Versenden deiner Email! Deine Email ist leer oder enthält ungültige Zeichen!"));
  exit;
}
$betreff = '['.$community_TLD.' '.$nodewatcher_name.'] '.$absendername." - ".$absendermail;
$body=trim(strip_tags($_REQUEST["body"]));
$text = "Bitte folgende Knoten in den Nodewatcher aufnehmen:\n\n".utf8_decode($body);
if(mail($nodewatcher_mail, $betreff, $text, "From: \"".utf8_encode($absendername)."\" <$absendermail>")){
	#send email confirmation to sender:
	$confirmtext='Hallo '.$absendername.',

für einen deiner Knoten wurde der automatisierte Versand von Status-E-Mails aktiviert. Um sicherzustellen, dass du wirklich der richtige Empfänger für diese E-Mails bist, bitten wir dich, deine E-Mail-Adresse durch einen Klick auf folgenden Bestätiguns-Link unten zu bestätigen:

'.$nodewatcher_url.'?confirm-email='.urlencode($absendermail).'

Erst danach wird der Versand von Status-E-Mails wirklich stattfinden.

Knoten:
'.$body.'
Empfänger 	'.$absendermail.'

Bei Fragen wende dich gerne an freifunk@lists.in-kiel.de

Viele Grüße
dein Freifunk Kiel

Möchtest du keine Status-E-Mails zu diesem Knoten mehr erhalten, so kannst du den Versand jederzeit deaktivieren:
'.$nodewatcher_url.'?deactivate='.$absendermail.'
';
	mail($absendermail, '[FFKI] Knotenalarm bestätigen', utf8_decode($confirmtext),$fromheader);
	header("Location: $absender_seite/bestaetigung.html?message=".rawurlencode("Du wurdest eingetragen. Bitte schaue in deinem Postfach nach der Bestätigungs-Email. Erst, wenn du diese beantwortet hast, wirst du benachrichtigt."));
} else {
	header("Location: $absender_seite/fehler.html?message=".rawurlencode("Fehler beim Versenden deiner Email!"));
}
