<?php
require_once "template.php";

$template = new template();
$template->setPage("templateGioco.html");
$index = $template->initializePage();

$index = str_replace("parole_chiave", "gameometry, videogioco, videogiochi, utente, recensioni", $index);
$index = str_replace("descrizione","Pagina dedicata a uno specifico videogioco", $index);
if(isset($_SESSIONE['username'])){
    $index = str_replace('<a id="areaRiservata" href="areaLogIn.php', '<a id="areaRiservata" href="areaUtente.php', $index);
}

$title = $_POST['immagine'];
$title = str_replace('vai alla pagina di ','',$title);

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
$index = str_replace("altBannerGioco",$tmpBannerName,$index);
$index = str_replace("bannerGioco",$banner,$index);
$title=str_replace("\'","'",$title);
$index = str_replace("</TITOLOGIOCO>",$title,$index);

$tmpImgName = str_replace("Locandina/","",$imgLocandina);
$index = str_replace("altLocandinaGioco",$tmpImgName,$index);
$index = str_replace("locandinaGioco",$imgLocandina,$index);

$index = str_replace("</PUBLISHER>",$publisher,$index);
$index = str_replace("</DATA>",$data_uscita,$index);
$index = str_replace("</PIATTAFORMA>",$piattaforma,$index);
$index = str_replace("</GENERE>",$genere,$index);

$index = str_replace("recGioco",$titoloGioco,$index);

$index = str_replace("</PUNTEGGIOCRITICA>",$voto,$index);
$index = str_replace("</PUNTEGGIOUTENTI>",$votoU,$index);

$index = str_replace("</TRAMA>",$trama,$index);


$index = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; <a href=\"videogiochi.php\">Videogiochi</a> &raquo; $title </p>", $index);
$index = str_replace("Titolo_pagina","Gameometry | $title",$index);

echo $index;

?>