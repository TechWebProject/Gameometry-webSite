<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Videogiochi</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina è dedicata ai divesi videogiochi prodotti nel corso degli anni", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, videogioco, videogiochi, piattaforma, genere, ...", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Videogiochi",$header);
$body->appendChild($doc->createTextNode($header));

//Codice php generazione giochi
$main = $body->appendChild($doc->createElement('main'));

$h1_Video = $main->appendChild($doc->createElement('h1'));
$h1_Video->setAttribute('id','newsTitle');
$h1_Video = $h1_Video->appendChild($doc->createTextNode('LA NOSTRA SELEZIONE DI VIDEOGIOCHI'));

$div_sezioneVideogiochi = $main->appendChild($doc->createElement('div'));
$div_sezioneVideogiochi->setAttribute('id','sezioneVideogiochi');

$dir = scandir("imgs");
$str = 'imgs/';

$imgz = array(count($dir)-2);

for($i = 2; $i < count($dir); $i++){
    $res = $str.$dir[$i];
    $trimmedword = RemoveSpecialChar($dir,$i);
    $imgz[$i-2]=array('src' => $res , 'alt' => $trimmedword);
}

foreach ($imgz as $attributes) {
    $imgtag = $div_sezioneVideogiochi->appendChild($doc->createElement('img'));
    foreach ($attributes as $key => $value) {
        $imgtag->setAttribute($key, $value);
        if($key=='alt'){
            $value=str_replace('locandina ','',$value);
            $imgtag->setAttribute('name',$value);
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