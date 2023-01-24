<?php
require_once "template.php";

$template = new template();
$template->setPage("templateGioco.html");
$templateGioco = $template->initializePage();

$templateGioco = str_replace("parole_chiave", "gameometry, videogioco, videogiochi, utente, recensioni", $templateGioco);
$templateGioco = str_replace("descrizione","Pagina dedicata a uno specifico videogioco", $templateGioco);

if(isset($_SESSION['username'])){
    $templateGioco = str_replace('<a id="areaRiservata" href="areaLogIn.php', '<a id="areaRiservata" href="areaUtente.php', $templateGioco);
}

$title = $_POST['immagine'];
$title = str_replace('vai alla pagina di ','',$title);
$title = str_replace('locandina ','',$title);

$db1=OpenCon();
$title=mysqli_real_escape_string($db1,$title);
$tmpquery= "SELECT cast(AVG(commento.voto) as int) as votoU, recensione.titolo as title,trama,rilascio,casaProduttrice,imgBanner,imgLocandina,piattaformaV,genereV,recensione.voto as votoV FROM recensione,videogioco,commento WHERE commento.idVideogioco=videogioco.titolo and recensione.idVideogioco=videogioco.titolo and videogioco.titolo='$title'";

$result = mysqli_query($db1,$tmpquery);
$r = $result->fetch_array(MYSQLI_ASSOC);

$titoloGioco = $r['title'];
$trama = $r['trama'];
$data_uscita=$r['rilascio'];
$publisher=$r['casaProduttrice'];
$banner=$r['imgBanner'];
$imgLocandina=$r['imgLocandina'];
$piattaforma=$r['piattaformaV'];
$genere=$r['genereV'];
$voto=$r['votoV'];
$votoU=$r['votoU'];
mysqli_free_result($result); 
CloseCon($db1); 

$tmpBannerName = str_replace("Banner/","",$banner);
$tmpBannerName = str_replace("_"," ",$tmpBannerName);
$templateGioco = str_replace("altBannerGioco",$tmpBannerName,$templateGioco);
$templateGioco = str_replace("bannerGioco",$banner,$templateGioco);
$title=str_replace("\'","'",$title);
$templateGioco = str_replace("</TITOLOGIOCO>",$title,$templateGioco);

$tmpImgName = str_replace("Locandine/","",$imgLocandina);
$tmpImgName = str_replace("_"," ",$tmpImgName);
$templateGioco = str_replace("altLocandinaGioco",$tmpImgName,$templateGioco);
$templateGioco = str_replace("locandinaGioco",$imgLocandina,$templateGioco);

$templateGioco = str_replace("</PUBLISHER>",$publisher,$templateGioco);
$templateGioco = str_replace("</DATA>",$data_uscita,$templateGioco);
$templateGioco = str_replace("</PIATTAFORMA>",$piattaforma,$templateGioco);
$templateGioco = str_replace("</GENERE>",$genere,$templateGioco);

$templateGioco = str_replace("recGioco",$titoloGioco,$templateGioco);

$templateGioco = str_replace("</PUNTEGGIOCRITICA>",$voto,$templateGioco);
$templateGioco = str_replace("</PUNTEGGIOUTENTI>",$votoU,$templateGioco);

$templateGioco = str_replace("</TRAMA>",$trama,$templateGioco);


$templateGioco = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; <a href=\"videogiochi.php\">Videogiochi</a> &raquo; $title </p>", $templateGioco);
$templateGioco = str_replace("Titolo_pagina","$title | Gameometry",$templateGioco);

echo $templateGioco;

?>