<?php
require_once "template.php";

$template = new template();
$template->setPage("recensioni.html");
$recensioni = $template->initializePage();

$recensioni = str_replace("Titolo_pagina","Recensioni | Gameometry",$recensioni);
$recensioni = str_replace("parole_chiave", "gameometry, recensioni, recensione, videogioco, videogiochi, voto, commento", $recensioni);
$recensioni = str_replace("descrizione","Questa pagina &egrave; dedicata alle recensioni videoludiche sugli ultimi prodotti usciti", $recensioni);

if(isset($_SESSION['username'])){
    $recensioni = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $recensioni);
}

$recensioni = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; Recensioni</p>", $recensioni);


$db = OpenCon();
$query = "SELECT * FROM recensione ORDER BY dataPubblicazione desc";
$result = mysqli_query($db,$query);
$arr = mysqli_fetch_all($result,MYSQLI_ASSOC);
$n_rows=mysqli_num_rows($result);
mysqli_free_result($result);

$recensioniTot = "";

for($i=0;$i<$n_rows;$i++){
    $chiavesterna = $arr[$i]['idVideogioco'];
    $titoloRecX = $arr[$i]['titolo'];
    $titoloRec = $titoloRecX;
    $titoloRec = str_replace(" ","%20",$titoloRec);
    $contenuto = $arr[$i]['contenuto'];
    $voto = $arr[$i]['voto'];
    
    $chiavesterna=mysqli_real_escape_string($db,$chiavesterna);
    $queryXimg = "SELECT * FROM videogioco WHERE titolo='$chiavesterna'";
    $result = mysqli_query($db,$queryXimg);
    $rr=$result->fetch_array(MYSQLI_ASSOC);
    $percorsoImg=$rr['imgLocandina'];
    mysqli_free_result($result);

    $recensioniTot .= "<div><form action=\"recensioneGioco.php\" method=\"GET\" class=\"formRecensioni\"><button name=\"recensione\" type=\"submit\" value=\"$titoloRecX\" aria-label=\"vai alla recensione di $chiavesterna\">
    <img class=\"r1\" src=\"$percorsoImg\" alt=\"$chiavesterna\"/></button></form><div class=\"commentoRecensione\"><div class=\"contenutoRecensione\"><h2 class=\"titoloCritica\">
    <a href=\"./recensioneGioco.php?titRec=$titoloRec\">$titoloRecX</a></h2>";
    
    $cont = 500;
    while ($contenuto[$cont] != ".") {
        $cont++;
    }
    $contenuto = substr($contenuto, 0, $cont);
    $contenuto .= "<abbr title=\"la recensione continua nella pagina del videogioco\">...</abbr>";

    $recensioniTot .= "<p>$contenuto</p></div><p class=\"punteggio\">$voto</p></div></div>";
}


CloseCon($db);

$recensioni = str_replace("</TUTTE_LE_RECENSIONI>",$recensioniTot,$recensioni);

echo $recensioni;
?>