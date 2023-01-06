<?php

http_response_code(404);

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang', 'it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head = file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>", "", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Pagina di errore", $head);
$head = str_replace("Stili/style.css", "./Stili/style404.css", $head);
$head = str_replace('<link rel="stylesheet" href="Stili/mini.css" media="handheld, screen and (max-width:820px), only screen and (max-device-width: 800px)" /> ', "", $head);
$head = str_replace("<meta name=&quot;keywords&quot; content=&quot;videogioco, videogiochi, utente, recensioni&quot; />", "", $head);
$html->appendChild($doc->createTextNode($head));

$file = file_get_contents("Componenti/template404.html");
$html->appendChild($doc->createTextNode($file));

$doc->formatOutput = true;
echo html_entity_decode($doc->saveHTML(), ENT_QUOTES, "UTF-8");
$doc->appendChild($doc->createTextNode('</html>'));
