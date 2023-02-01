<?php
require_once "template.php";

$template = new template();
$template->setPage("videogiochi.html");
$videogiochi = $template->initializePage();

$videogiochi = str_replace("Titolo_pagina","Videogiochi | Gameometry",$videogiochi);
$videogiochi = str_replace("parole_chiave", "gameometry, videogioco, videogiochi, piattaforma, console", $videogiochi);
$videogiochi = str_replace("descrizione","Questa pagina &egrave; dedicata ai divesi videogiochi prodotti nel corso degli anni",$videogiochi);

if(isset($_SESSION['username'])){
    $videogiochi = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $videogiochi);
}

$videogiochi = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; Videogiochi</p>", $videogiochi);

$db=OpenCon();

$titoloh1Video;
$query;
if(isset($_POST["immagine"])){
    $titolo=$_POST["immagine"];
    $titolo=mysqli_real_escape_string($db,$titolo);
    $query = "SELECT titolo , imgLocandina, genereV FROM videogioco WHERE titolo like '%$titolo%'";
    $titoloh1Video = "<h1 id=\"firstTitle\">RISULTATI DELLA RICERCA</h1>";
    $videogiochi = str_replace("<h1 id=\"firstTitle\">LA NOSTRA SELEZIONE DI VIDEOGIOCHI</h1>",$titoloh1Video,$videogiochi);
}else{
    $query = "SELECT titolo , imgLocandina , genereV FROM videogioco";
}

$result = mysqli_query($db,$query);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
$n_rows=mysqli_num_rows($result);
mysqli_free_result($result);


//INSERIMENTO VIDEOGIOCHI
$imgz = array($n_rows);

for($i = 0; $i < $n_rows; $i++){
    $imgz[$i]=array('src' => $arr[$i]['imgLocandina'],'alt'=> $arr[$i]['titolo'], 'genere' => $arr[$i]['genereV']);
}

$imgForm = " ";

if($n_rows==0){
    $videogiochi = str_replace("</VIDEOGIOCHI>","<p id=\"noresult_text\">Nessun risultato</p>",$videogiochi);
    $videogiochi = str_replace("<button id=\"btnImgFiltro\" aria-label=\"mostra filtri\">","<button id=\"btnImgFiltro\" aria-label=\"mostra filtri\" class=\"ciao\">",$videogiochi);
    $videogiochi = str_replace("id=\"sezioneVideogiochi\"","id=\"toStretch\"",$videogiochi);
}else{
    foreach ($imgz as $attributes) {
        $imgForm .= "<form action=\"templateGioco.php\" method=\"GET\" class= \"genere game filtrato\"><button name=\"immagine\" class=\"btImg\" type=\"submit\" value=\"valueButtonVideogioco\" aria-label=\"vai alla pagina di Pagina\"><img src=\"nomeFileLocandina\" alt=\"nomeTitoloVideogioco\" class=\"imgs\"/><span class=\"imgSpan\">spanVideogioco</span></button></form>";
        foreach ($attributes as $key => $value) {
            if($key=='src'){
                $imgForm = str_replace("nomeFileLocandina",$value,$imgForm);
            }
            if($key=='alt'){
                $value = str_replace('locandina ','',$value);
                $imgForm = str_replace("valueButtonVideogioco",$value,$imgForm);
                $imgForm = str_replace("nomeTitoloVideogioco","locandina $value",$imgForm);
                $imgForm = str_replace("Pagina",$value,$imgForm);
                $imgForm = str_replace("spanVideogioco",$value,$imgForm);
            }
            if($key == 'genere'){
                $stringGenere = strip_tags($value);
                $stringGenere = str_replace("Avventura dinamica","Avventuradinamica", $stringGenere);
                $imgForm = str_replace("genere",$stringGenere,$imgForm);
            }
        }   
    }
}


CloseCon($db);

$videogiochi = str_replace("</VIDEOGIOCHI>",$imgForm,$videogiochi);

echo $videogiochi;
?>