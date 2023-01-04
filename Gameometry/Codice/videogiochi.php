<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
session_start();
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Videogiochi</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina &egrave; dedicata ai divesi videogiochi prodotti nel corso degli anni", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, videogioco, videogiochi, piattaforma, genere, ...", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Videogiochi",$header);
if(isset($_SESSION['username'])){
    $header = str_replace('<a id="areaRiservata" href="areaLogIn.php">','<a id="areaRiservata" href="areaUtente.php">',$header);
}
$body->appendChild($doc->createTextNode($header));

//Codice php generazione giochi
$main = $body->appendChild($doc->createElement('main'));

$db=OpenCon();

$query_nrows="SELECT COUNT(*) as nrighe FROM videogioco";
$result=mysqli_query($db,$query_nrows);
$tmparr=$result->fetch_array(MYSQLI_ASSOC);
$n_rows=$tmparr['nrighe'];

mysqli_free_result($result);

$query = "SELECT titolo FROM videogioco";
$result = mysqli_query($db,$query);
$arr = mysqli_fetch_all($result, MYSQLI_ASSOC);


CloseCon($db);

$labelTitoli = $main->appendChild($doc->createElement('label'));
$t ='';

for ($i = 0; $i < $n_rows; $i++){
    if($i == $n_rows-1){
        $t .= $arr[$i]['titolo'];
    }else{
        $t .= $arr[$i]['titolo'].',';
    }
}

$labelTitoli->appendChild($doc->createTextNode($t));
$labelTitoli->setAttribute('id', 'arrTitoli');

$searchscript = $main->appendChild($doc->createElement('script'));
$searchscript->setAttribute('type','text/JavaScript');
$searchscript->setAttribute('src','Componenti/scriptSearch.js');

$h1_Video = $main->appendChild($doc->createElement('h1'));
$h1_Video->setAttribute('id','newsTitle');
$h1_Video = $h1_Video->appendChild($doc->createTextNode('LA NOSTRA SELEZIONE DI VIDEOGIOCHI'));

$div_sezioneVideogiochi = $main->appendChild($doc->createElement('div'));
$div_sezioneVideogiochi->setAttribute('id','sezioneVideogiochi');

$dir = scandir("Locandine");
$str = 'Locandine/';

$imgz = array(count($dir)-2);

for($i = 2; $i < count($dir); $i++){
    $res = $str.$dir[$i];
    $trimmedword = RemoveSpecialChar($dir,$i);
    $imgz[$i-2]=array('src' => $res , 'alt' => $trimmedword);
}

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
            $imgSpan = $imgSpan->appendChild($doc->createTextNode($value));
        }
    }
    $imgtag->setAttribute('class','imgs');
}

//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>