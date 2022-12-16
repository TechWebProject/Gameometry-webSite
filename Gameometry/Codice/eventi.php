<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Eventi</title>", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Eventi",$header);
$body->appendChild($doc->createTextNode($header));



//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>