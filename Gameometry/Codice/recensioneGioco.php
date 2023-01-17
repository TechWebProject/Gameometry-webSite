<?php
require_once "template.php";

$template = new template();
$template->setPage("recensioneGioco.html");
$index = $template->initializePage();

$index = str_replace("parole_chiave", "gameometry, recensioni, recensione, videogioco, videogiochi, voto, commento", $index);
$index = str_replace("descrizione","Questa pagina &egrave; dedicata alle recensioni videoludiche sugli ultimi prodotti usciti", $index);

if(isset($_SESSIONE['username'])){
    $index = str_replace('<a id="areaRiservata" href="areaLogIn.php', '<a id="areaRiservata" href="areaUtente.php', $index);
}

$giocoRecensito;
if (isset($_POST['recensione'])) {
    $giocoRecensito = $_POST['recensione'];
} elseif (isset($_GET['titRec'])) {
    $giocoRecensito = $_GET['titRec'];
}
$giocoRecensito = str_replace('vai alla recensione di ','',$giocoRecensito);

//QUERY
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


$index = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; <a href=\"recensioni.php\">Recensioni</a> &raquo; $titoloGioco </p>", $index);
$index = str_replace("Titolo_pagina","Gameometry | Recensione $titoloGioco ",$index);
$index = str_replace("</TITOLOGIOCO>",$titoloRec, $index);
$index = str_replace("bannerGioco",$banner, $index);
$index = str_replace("</VOTO>",$voto, $index);
$index = str_replace("</CONTENUTO>",$contenutoRec, $index);

//SEZIONE RECENSIONE UTENTE
$db = OpenCon();
$recU = "";
if (isset($_SESSION['email'])) {

    $emailUser = $_SESSION['email'];

    $gioco = mysqli_real_escape_string($db, $titoloGioco);

    $query_check_commento = "SELECT * FROM videogioco,commento WHERE videogioco.titolo=commento.idVideogioco and videogioco.titolo='$gioco' and commento.idUtente='$emailUser'";
    $result = mysqli_query($db, $query_check_commento);
    $userNotOk = $result->fetch_array(MYSQLI_ASSOC);
    if (!isset($userNotOk)) {
        $recU .= "<h2 class=\"titleH2\">LASCIA UN COMMENTO</h2>
        <div id=\"inputCommento\"><form action=\"areaUtente.php\" method=\"POST\">
    <textarea id=\"areaCommento\" name=\"commentoU\" rows=\"10\" placeholder=\" Lascia un commento\" maxlength=\"900\"></textarea><div id=\"votazione\">
    <p>Lascia un voto</p>
    <input id=\"rate1\" name=\"rating\" type=\"radio\" value=\"1\"><label id=\"voto\" for=\"rate1\">1</label>
    <input id=\"rate2\" name=\"rating\" type=\"radio\" value=\"2\"><label id=\"voto\" for=\"rate2\">2</label>
    <input id=\"rate3\" name=\"rating\" type=\"radio\" value=\"3\"><label id=\"voto\" for=\"rate3\">3</label>
    <input id=\"rate4\" name=\"rating\" type=\"radio\" value=\"4\"><label id=\"voto\" for=\"rate4\">4</label>
    <input id=\"rate5\" name=\"rating\" type=\"radio\" value=\"5\"><label id=\"voto\" for=\"rate5\">5</label>
    <input id=\"rate6\" name=\"rating\" type=\"radio\" value=\"6\"><label id=\"voto\" for=\"rate6\">6</label>
    <input id=\"rate7\" name=\"rating\" type=\"radio\" value=\"7\"><label id=\"voto\" for=\"rate7\">7</label>
    <input id=\"rate8\" name=\"rating\" type=\"radio\" value=\"8\"><label id=\"voto\" for=\"rate8\">8</label>
    <input id=\"rate9\" name=\"rating\" type=\"radio\" value=\"9\"><label id=\"voto\" for=\"rate9\">9</label>
    <input id=\"rate10\" name=\"rating\" type=\"radio\" value=\"10\"><label id=\"voto\" for=\"rate10\">10</label>
    </div>
    <input type=\"hidden\" name=\"inviaCommento2\" value=\"$titoloGioco\"><button id=\"inviaCommento\" aria-label=\"invia commento\" type=\"submit\" name=\"inviaCommento\" value=\"Commenta\">Commenta</button>
    </form></div>";
    }
    $index = str_replace("</RECENSIONEU", $recU, $index);
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
    <div class=\"boxPunteggioU\"><p class=\"punteggioU\">$votoU</p></div>
    </div>";
}

$index = str_replace("</COMMENTI>", $commenti, $index);

echo $index;
?>