<?php
require_once "template.php";

$template = new template();
$template->setPage("areaUtente.html");
$areaUtente = $template->initializePage();

$areaUtente = str_replace("Titolo_pagina","Area Utente",$areaUtente);
$areaUtente = str_replace("parole_chiave", "gameometry, videogioco, videogiochi, console, pc, computer, recensione, recensioni, voto, notizie", $areaUtente);
$areaUtente = str_replace("descrizione","Pagina rservata all'area personale del singolo utente", $areaUtente);

if(isset($_SESSION['username'])){
    $areaUtente = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $areaUtente);
}

$areaUtente = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; <a href=\"areaUtente.php\">Area Utente</a></p>", $areaUtente);

//INFO UTENTE

$db = OpenCon();

$email = $_SESSION['email'];
$nCommenti="SELECT COUNT(*) as nComm FROM commento WHERE commento.idUtente='$email'";
$result=mysqli_query($db,$nCommenti);
$arr=$result->fetch_array(MYSQLI_ASSOC);
$nComm=$arr['nComm'];

$areaUtente = str_replace("</USERNAME>", $_SESSION['username'], $areaUtente);
$areaUtente = str_replace("</EMAIL>", $_SESSION['email'], $areaUtente);
$areaUtente = str_replace("</ISCRIZIONE>", $_SESSION['dataIscrizione'], $areaUtente);
$areaUtente = str_replace("</NCOMMENTI>", "$nComm", $areaUtente);

//MODIFICHE

if(isset($_POST['logoutButton'])){
    session_unset(); 
    session_destroy(); 

    header("Location: index.php");
}

/////////

if(isset($_POST['deleteU'])){
    $deleteUser="DELETE FROM utente WHERE utente.email = '$email'";
    $result=mysqli_query($db,$deleteUser);

    session_unset(); 
    session_destroy(); 

    header("Location: areaLogin.php?message=success");
}

if(isset($_POST['modifyU'])){
    header("Location: modificaUtente.php");
}

//////////

//INSERIMENTO COMMENTO

//ULTIME RECENSIONI
$tmpquery= "SELECT videogioco.titolo as title, commento.contenuto as contenutoU, commento.voto as votoU FROM utente,commento,recensione,videogioco WHERE commento.idUtente=utente.email and commento.idVideogioco=videogioco.titolo and recensione.idVideogioco=videogioco.titolo and utente.email='$email' ORDER BY commento.data desc";
$result2 = mysqli_query($db,$tmpquery);
$arr2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);
mysqli_free_result($result2);

$commenti = "";
if($nComm>0){
    for($i=0;$i<$nComm;$i++){
        $titologioco = $arr2[$i]['title'];
        $titologioco=mysqli_real_escape_string($db,$titologioco);
        $contenuto=$arr2[$i]['contenutoU'];
        $votoU=$arr2[$i]['votoU']; 
        $queryxtitrec="SELECT titolo as titoloRec FROM recensione WHERE idVideogioco='$titologioco'";
        $result2 = mysqli_query($db,$queryxtitrec);
        $r=$result2->fetch_array(MYSQLI_ASSOC);
        mysqli_free_result($result2);
        $titoloRec=$r['titoloRec'];
        $commenti .= "<div class=\"postU\">
        <div class=\"commentoU\">
            <div class=\"userButtons\">
                <button class=\"btnmod\"></button>
                <button class=\"btnel\"></button>
            </div>
            <ul class=\"contenutoRecensioneU1\">
                <li class=\"toBold\">
                    <a href=\"./recensioneGioco.php?titRec=$titoloRec\" class=\"\">$titologioco</a></li>
                <li>$contenuto</li>
            </ul>
            </div>
            <div class=\"boxPunteggioU1\"><p class=\"punteggioU\">$votoU</p></div>
            </div>";
    }
}
else {
    $commenti .= "<div id=\"messageU\"><span>Non hai ancora commentanto nessun videogioco. 
    Per farlo recati alla pagina<a href=\"recensioni.php\">Recensioni</a>, leggi una delle nostre recensioni e dacci una tua opinione sul videogioco scelto!</span></div>";
}
CloseCon($db);

$areaUtente = str_replace("</ULTIME_RECENSIONI>",$commenti,$areaUtente);
echo $areaUtente;

?>