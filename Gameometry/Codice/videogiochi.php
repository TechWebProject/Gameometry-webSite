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

// PARTE DA CONVERTIRE
$imgz = array($n_rows);

for($i = 0; $i < $n_rows; $i++){
    $imgz[$i]=array('src' => $arr[$i]['imgLocandina'],'alt'=> $arr[$i]['titolo']);
}
if($n_rows==0){
    $no_risultati = $div_sezioneVideogiochi->appendChild($doc->createElement('p'));
    $no_risultati->setAttribute('id','noresult_text');
    $no_risultati->appendChild($doc->createTextNode("Nessun risultato"));
}else{
    foreach ($imgz as $attributes) {
        $imgForm = $div_sezioneVideogiochi->appendChild($doc->createElement('form'));
        $imgForm->setAttribute('action', 'templateGioco.php');
        $imgForm->setAttribute('method', 'POST');
        $buttonImg = $imgForm->appendChild($doc->createElement('button'));
        $buttonImg->setAttribute('name','immagine');
        $buttonImg->setAttribute('class','btImg');
        $imgtag = $buttonImg->appendChild($doc->createElement('img'));
        $imgSpan = $buttonImg->appendChild($doc->createElement('span'));
        $imgSpan->setAttribute('class','imgSpan');
        foreach ($attributes as $key => $value) {
            $imgtag->setAttribute($key, $value);
            if($key=='alt'){
                $value=str_replace('locandina ','',$value);
                $buttonImg->setAttribute('value',$value);
                $valueAL=str_replace($value,'vai alla pagina di '.$value,$value);
                $buttonImg->setAttribute('aria-label',$valueAL);
                $imgSpan = $imgSpan->appendChild($doc->createTextNode($value));
            }
        }
        $imgtag->setAttribute('class','imgs');
    }
}

CloseCon($db);

echo $videogiochi;
?>