<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Recensione</title>", $head); /*Recensione dovrà essere sostituita con il titolo del relativo gioco*/
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina è dedicata alle recensioni videoludiche sugli ultimi prodotti usciti");
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, recensioni, recensione, videogioco, videogiochi, voto, commento", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Recensione",$header); /*Recensione dovrà essere sostituita con il titolo del relativo gioco*/
$body->appendChild($doc->createTextNode($header));



//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>