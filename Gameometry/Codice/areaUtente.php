<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang', 'it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head = file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>", "<title>Gameometry | Area riservata</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Gestisci la tua esperienza sul sito Gameometry", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, area, riservata, videogioco, videogiochi, utente, recensioni", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header = file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie", "Area riservata", $header);
$body->appendChild($doc->createTextNode($header));

//main
$main = file_get_contents('Componenti/areaUtente.html');
//$main = str_replace("user_name", nome utente database);     ( X il database)
$commenti = file_get_contents('Componenti/commenti.html');
$body->appendChild($doc->createTextNode($main));   //Le recensioni vanno aggiunte tramite database
$body->appendChild($doc->createTextNode($commenti));

//footer
$footer = file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput = true;
echo html_entity_decode($doc->saveHTML(), ENT_QUOTES, "UTF-8");

?>