<?php
require_once "template.php";

$template = new template();
$template->setPage("eventi.html");
$index = $template->initializePage();
$eventi = file_get_contents("Componenti/listaEventi.html");

$index = str_replace("Titolo_pagina","Gameometry | Eventi",$index);
$index = str_replace("parole_chiave", "gameometry, videogiochi, videogioco, videoludico, eventi, ...", $index);
$index = str_replace("descrizione","Questa pagina &egrave; dedicata ai diversi eventi videoludici organizzati dagli appassionati di questo mondo", $index);

if(isset($_SESSIONE['username'])){
    $index = str_replace('<a id="areaRiservata" href="areaLogIn.php', '<a id="areaRiservata" href="areaUtente.php', $index);
}

$index = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span>  &raquo; Eventi</p>", $index);

$index = str_replace("</EVENTI>", $eventi, $index);
echo $index;
?>