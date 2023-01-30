<?php
require_once "template.php";

$template = new template();
$template->setPage("index.html");
$index = $template->initializePage();

$index = str_replace("Titolo_pagina","Home | Gameometry",$index);
$index = str_replace("parole_chiave", "gameometry, videogioco, videogiochi, console, pc, computer, recensione, recensioni, voto, notizie", $index);
$index = str_replace("descrizione","Questa pagina &egrave; dedicata al mondo videoludico e, pi&ugrave; nello specifico, alle recensioni legate a questo tipo di mondo", $index);

if(isset($_SESSION['username'])){
    $index = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $index);
}

$index = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span></p>", $index);

//CAROSELLO
$dir = scandir("Locandine");
$str = 'Locandine/';

$db = OpenCon();
$query = "SELECT titolo,imgLocandina FROM videogioco ORDER BY rilascio desc LIMIT 10";
$result = mysqli_query($db, $query);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

$imgz = array();
$imgz = array_fill(0, 10, null);

for($i=0;$i<10;$i++){
    $alt=$arr[$i]['titolo'];
    $src=$arr[$i]['imgLocandina'];

    $j = rand(0, 9);
    while ($imgz[$j] != NULL) {
        $j = rand(0, 9);
    }
    $imgz[$j] = array('src' =>$src, 'alt' => 'locandina '.$alt);
}

$carousel = "";

foreach ($imgz as $attributes) {
    $carousel .= "<form action=\"templateGioco.php\" method=\"GET\"><button name=\"immagine\" type=\"submit\" value=\"\" aria-label=\"\"><img src=\"\" alt=\"\" class=\"imgs\"></button></form>";
    foreach ($attributes as $key => $value) {
        if($key=='src'){
            $carousel = str_replace("src=\"\"","src=\"$value\"",$carousel);
        }
        if($key=='alt'){
            $indication = str_replace('locandina ', 'vai alla pagina di ', $value);
            $carousel = str_replace("value=\"\"","value=\"$indication\"",$carousel);
            $carousel = str_replace("aria-label=\"\"","aria-label=\"$indication\"",$carousel);
            $carousel = str_replace("alt=\"\"","alt=\"$value\"",$carousel);
        }
    }
}

$index = str_replace("</CAROUSEL_CONTENT>",$carousel,$index);

//ULTIME RECENSIONI
$query = "SELECT * FROM recensione ORDER BY dataPubblicazione desc LIMIT 5";
$result = mysqli_query($db, $query);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);

$ultimeRecensioni = "";

for ($i = 0; $i < 5; $i++) {
    $chiavesterna = $arr[$i]['idVideogioco'];
    $titoloRecX = $arr[$i]['titolo'];
    $titoloRec = $titoloRecX;
    $titoloRec = str_replace(" ","%20",$titoloRec);
    $contenuto = $arr[$i]['contenuto'];
    $voto = $arr[$i]['voto'];

    $chiavesterna = mysqli_real_escape_string($db, $chiavesterna);
    $queryXimg = "SELECT * FROM videogioco WHERE titolo='$chiavesterna'";
    $result = mysqli_query($db, $queryXimg);
    $rr = $result->fetch_array(MYSQLI_ASSOC);
    $percorsoImg = $rr['imgLocandina'];
    mysqli_free_result($result);
    
    $cont = 500;
    while ($contenuto[$cont] != ".") {
        $cont++;
    }
    $contenuto = substr($contenuto, 0, $cont);
    $contenuto .= "<abbr title=\"la recensione continua nella pagina del videogioco\">...</abbr>";

    $ultimeRecensioni .= "<div>
    <form action=\"recensioneGioco.php\" method=\"GET\" class=\"formRecensioni\"><button name=\"recensione\" type=\"submit\" value=\"$titoloRecX\" aria-label=\"vai alla recensione di $chiavesterna\"><img class=\"r1\" src=\"$percorsoImg\" alt=\"locandina $chiavesterna\"></button></form><div class=\"commentoRecensione\"><div class=\"contenutoRecensione\"><h2 class=\"titoloCritica\"><a href=\"./recensioneGioco.php?titRec=$titoloRec\">$titoloRecX</a></h2><p>$contenuto</p></div><p class=\"skip\">il nostro punteggio</p><p class=\"punteggio\">$voto</p></div></div>";  

}
CloseCon($db);

$index = str_replace("</ULTIME_RECENSIONI>",$ultimeRecensioni,$index);

echo $index;

?>