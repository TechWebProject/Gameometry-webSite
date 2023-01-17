<?php
require_once "template.php";

$template = new template();
$template->setPage("notizie.html");
$notizie = $template->initializePage();

$notizie = str_replace("Titolo_pagina","Gameometry | Notizie",$notizie);
$notizie = str_replace("parole_chiave", "gameometry, videogioco, videogiochi, console, pc, computer, recensione, recensioni, voto, notizie", $notizie);
$notizie = str_replace("descrizione","Questa pagina &egrave; dedicata al mondo videoludico e, pi&ugrave; nello specifico, alle recensioni legate a questo tipo di mondo", $notizie);

if(isset($_SESSION['username'])){
    $notizie = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $notizie);
}

$notizie = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; Notizie</p>", $notizie);

echo $notizie;
?>