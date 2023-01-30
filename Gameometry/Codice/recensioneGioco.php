<?php
require_once "template.php";

$template = new template();
$template->setPage("recensioneGioco.html");
$recensioneGioco = $template->initializePage();

$recensioneGioco = str_replace("parole_chiave", "gameometry, recensioni, recensione, videogioco, videogiochi, voto, commento", $recensioneGioco);
$recensioneGioco = str_replace("descrizione","Questa pagina &egrave; dedicata alle recensioni videoludiche sugli ultimi prodotti usciti", $recensioneGioco);

if(isset($_SESSION['username'])){
    $recensioneGioco = str_replace('<a id="areaRiservata" href="areaLogIn.php', '<a id="areaRiservata" href="areaUtente.php', $recensioneGioco);
}

$giocoRecensito;
if(isset($_GET['titRec'])){
    $giocoRecensito = $_GET['titRec'];
}
else if(isset($_GET['recensione'])){
    $giocoRecensito = $_GET['recensione'];
}
$giocoRecensito = str_replace('vai alla recensione di ','',$giocoRecensito);

$db1 = OpenCon();
$title = mysqli_real_escape_string($db1, $giocoRecensito);
$tmpquery = "SELECT recensione.titolo as title,videogioco.titolo as videogioco,imgBanner,contenuto,voto FROM recensione,videogioco WHERE recensione.idVideogioco=videogioco.titolo and recensione.titolo='$title'";

$result = mysqli_query($db1, $tmpquery);
$r = $result->fetch_array(MYSQLI_ASSOC);

$titoloRec = $r['title'];
$titoloGioco = $r['videogioco'];
$banner = $r['imgBanner'];
$contenutoRec = $r['contenuto'];
$voto = $r['voto'];

mysqli_free_result($result);

CloseCon($db1);

$recensioneGioco = str_replace("alternativeBannerText","banner $titoloGioco",$recensioneGioco);

$recensioneGioco = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; <a href=\"recensioni.php\">Recensioni</a> &raquo; Recensione $titoloGioco </p>", $recensioneGioco);
$recensioneGioco = str_replace("Titolo_pagina","Recensione $titoloGioco | Gameometry",$recensioneGioco);
$recensioneGioco = str_replace("</TITOLOGIOCO>",$titoloRec, $recensioneGioco);
$recensioneGioco = str_replace("bannerGioco",$banner, $recensioneGioco);
$recensioneGioco = str_replace("</VOTO>",$voto, $recensioneGioco);
$recensioneGioco = str_replace("</CONTENUTO>",$contenutoRec, $recensioneGioco);

//SEZIONE RECENSIONE UTENTE
$db = OpenCon();
$recU = " ";
if (isset($_SESSION['email'])) {

    $emailUser = $_SESSION['email'];

    $gioco = mysqli_real_escape_string($db, $titoloGioco);

    $query_check_commento = "SELECT * FROM videogioco,commento WHERE videogioco.titolo=commento.idVideogioco and videogioco.titolo='$gioco' and commento.idUtente='$emailUser'";
    $result = mysqli_query($db, $query_check_commento);
    $userNotOk = $result->fetch_array(MYSQLI_ASSOC);
    if (!isset($userNotOk)) {
        $recU .= "<h2 class=\"titleH2\">LASCIA UN COMMENTO</h2>
        <div id=\"inputCommento\"><form action=\"areaUtente.php\" method=\"POST\">
        <textarea id=\"areaCommento\" name=\"commentoU\" rows=\"10\" placeholder=\" Lascia un commento\" maxlength=\"900\"></textarea>
        <span id=\"errCommento\" aria-live=\"assertive\"></span>
        <div id=\"votazione\">
        <p>Lascia un voto</p>";
        for($i=1;$i<=10;$i++){
            $recU .= "<input id=\"rate$i\" name=\"rating\" type=\"radio\" value=\"$i\"><label id=\"voto\" for=\"rate$i\">$i</label>";
        }
    $recU .= "<span id=\"errVoto\" aria-live=\"assertive\"></span></div><input type=\"hidden\" name=\"inviaCommento2\" value=\"$titoloGioco\"><button id=\"inviaCommento\" class=\"disabled-button\"aria-label=\"invia commento\" type=\"submit\" name=\"inviaCommento\" value=\"Commenta\" onclick=\"checkCommento()\" disabled>Commenta</button></form></div>";
    }
    $recensioneGioco = str_replace("</RECENSIONEU>", $recU, $recensioneGioco);
}
CloseCon($db);
$db2 = OpenCon();
$title1 = mysqli_real_escape_string($db2, $giocoRecensito);

$query_nrows = "SELECT COUNT(*) as nRighe FROM utente,commento,recensione,videogioco WHERE commento.idUtente=utente.email and commento.idVideogioco=videogioco.titolo and recensione.idVideogioco=videogioco.titolo and recensione.titolo='$title1'";
$result = mysqli_query($db2, $query_nrows);
$tmparr = $result->fetch_array(MYSQLI_ASSOC);
$n_rows = $tmparr['nRighe'];
mysqli_free_result($result);

$tmpquery2 = "SELECT utente.nickname as nickname, commento.contenuto as contenutoU, commento.voto as votoU FROM utente,commento,recensione,videogioco WHERE commento.idUtente=utente.email and commento.idVideogioco=videogioco.titolo and recensione.idVideogioco=videogioco.titolo and recensione.titolo='$title1' ORDER BY commento.data desc";
$result2 = mysqli_query($db2, $tmpquery2);
$arr2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
mysqli_free_result($result2);

CloseCon($db2);

$commenti = "";
for ($i = 0; $i < $n_rows; $i++) {
    $nickname = $arr2[$i]['nickname'];
    $contenuto = $arr2[$i]['contenutoU'];
    $votoU = $arr2[$i]['votoU'];

    $commenti .= "<div class=\"post\">
    <img class=\"r2\" alt=\"immagine profilo utente registrato\" src=\"Immagini/avatar.png\"><div class=\"commento\"><ul class=\"contenutoRecensioneU\">
    <li class=\"toBold\">$nickname</li>
    <li> $contenuto</li>
    </ul>
    </div>
    <div class=\"boxPunteggioU\"><p class=\"skip\">punteggio</p><p class=\"punteggioU\">$votoU</p></div>
    </div>";
}

$recensioneGioco = str_replace("</COMMENTI>", $commenti, $recensioneGioco);

echo $recensioneGioco;
?>