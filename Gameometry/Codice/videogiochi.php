<?php
require_once "template.php";

$template = new template();
$template->setPage("videogiochi.html");
$videogiochi = $template->initializePage();

$videogiochi = str_replace("Titolo_pagina","Gameometry | Videogiochi",$videogiochi);
$videogiochi = str_replace("parole_chiave", "gameometry, videogioco, videogiochi, piattaforma, genere, ...", $videogiochi);
$videogiochi = str_replace("descrizione","Questa pagina &egrave; dedicata ai divesi videogiochi prodotti nel corso degli anni", $videogiochi);

if(isset($_SESSION['username'])){
    $videogiochi = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $videogiochi);
}

$videogiochi = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; Videogiochi</p>", $videogiochi);

    
$db=OpenCon();

$result = mysqli_query($db,$query);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
$n_rows=mysqli_num_rows($result);
mysqli_free_result($result);



CloseCon($db);

echo $videogiochi;
?>