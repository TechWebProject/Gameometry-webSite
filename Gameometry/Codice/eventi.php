<?php
require_once "template.php";

$template = new template();
$template->setPage("eventi.html");
$eventi = $template->initializePage();

$eventi = str_replace("Titolo_pagina","Eventi | Gameometry",$eventi);
$eventi = str_replace("parole_chiave", "gameometry, videogiochi, videogioco, videoludico, eventi", $eventi);
$eventi = str_replace("descrizione","Questa pagina &egrave; dedicata ai diversi eventi videoludici organizzati dagli appassionati di questo mondo", $eventi);

if(isset($_SESSION['username'])){
    $eventi = str_replace('<a id="areaRiservata" href="areaLogIn.php', '<a id="areaRiservata" href="areaUtente.php', $eventi);
}

$eventi = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; Eventi</p>", $eventi);

echo $eventi;
?>