<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("&raquo; Notizie","",$header);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina è dedicata al mondo videoludico e, più nello specifico, alle recensioni legate a questo tipo di mondo", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, videogioco, videogiochi, console, pc, computer, recensione, recensioni, voto, notizie", $head);
$body->appendChild($doc->createTextNode($header));



//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>