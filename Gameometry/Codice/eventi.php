<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Eventi</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina è dedicata ai diversi eventi videoludici organizzati dagli appassionati di questo mondo", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, videogiochi, videogioco, videoludico, eventi, ...", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Eventi",$header);
$body->appendChild($doc->createTextNode($header));

//main
$main = file_get_contents('Componenti/listaEventi.html');
$body->appendChild($doc->createTextNode($main));

//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>