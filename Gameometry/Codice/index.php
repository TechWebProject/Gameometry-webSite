<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("&raquo; Notizie","",$header);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina &egrave; dedicata al mondo videoludico e, pi&ugrave; nello specifico, alle recensioni legate a questo tipo di mondo", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, videogioco, videogiochi, console, pc, computer, recensione, recensioni, voto, notizie", $head);
$body->appendChild($doc->createTextNode($header));

//main
$main = $body->appendChild($doc->createElement('main'));

//slider
$h1 = $main->appendChild($doc->createElement('h1'));
$h1 = $h1->appendChild($doc->createTextNode('GIOCHI PIÙ VOTATI'));

$divCarousel = $main->appendChild($doc->createElement('div'));
$divCarousel->setAttribute('class','wrapper');
$divInternalCarousel = $divCarousel->appendChild($doc->createElement('div'));
$divInternalCarousel->setAttribute('class','horizontal-wrapper');

$rightRow = $divInternalCarousel->appendChild($doc->createElement('button'));
$rightRow->setAttribute('id','btn-left');
$rightRow->setAttribute('aria-label','Scorrimento a sinistra');
$rightRow = $rightRow->appendChild($doc->createTextNode('&lsaquo;'));

$divSlider = $divInternalCarousel->appendChild($doc->createElement('div'));
$divSlider->setAttribute('class','carousel');

$dir = scandir("Locandine");
$str = 'Locandine/';

$imgz = array(count($dir)-2);
$imgz = array_fill(0,10,null);

for($i = 2; $i < 12; $i++){ 
    $res = $str.$dir[$i];
    $trimmedword = RemoveSpecialChar($dir,$i);
    $j=rand(0,9);
    while($imgz[$j]!=NULL){
        $j=rand(0,9);
    }   
    $imgz[$j]=array('src' => $res , 'alt' => $trimmedword);
}

foreach ($imgz as $attributes) {
    $imgForm = $divSlider->appendChild($doc->createElement('form'));
    $imgForm->setAttribute('action', 'templateGioco.php');
    $imgForm->setAttribute('method', 'POST');
    $buttonImg = $imgForm->appendChild($doc->createElement('button'));
    $buttonImg->setAttribute('name','immagine');
    $imgtag = $buttonImg->appendChild($doc->createElement('img'));
    foreach ($attributes as $key => $value) {
        $imgtag->setAttribute($key, $value);
        if($key=='alt'){
            $value=str_replace('locandina ','',$value);
            $buttonImg->setAttribute('value',$value);
        }
    }
    $imgtag->setAttribute('class','imgs');
}

$leftRow = $divInternalCarousel->appendChild($doc->createElement('button'));
$leftRow->setAttribute('id','btn-right');
$leftRow->setAttribute('aria-label','Scorrimento a destra');
$leftRow = $leftRow->appendChild($doc->createTextNode('&rsaquo;'));

$sliderScript = $main->appendChild($doc->createElement('script'));
$sliderScript->setAttribute('type','text/JavaScript');
$sliderScript->setAttribute('src','Componenti/scriptjs.js');

//breaking news
$listaBN = file_get_contents('Componenti/listaBN.html');
$main->appendChild($doc->createTextNode($listaBN));

//ultime recensioni
$h1Recensioni = $main->appendChild($doc->createElement('h1'));
$h1Recensioni = $h1Recensioni->appendChild($doc->createTextNode('ULTIME RECENSIONI'));

$divRec = $main->appendChild($doc->createElement('div'));
$divRec->setAttribute('id','recensioni-critica');

//ultime recensioni codice php
$db=OpenCon();
$query = "SELECT * FROM recensione ORDER BY dataPubblicazione desc LIMIT 5";
$result = mysqli_query($db,$query);
$arr = mysqli_fetch_all($result,MYSQLI_ASSOC);

for($i=0;$i<5;$i++){
//Query che prende in base alla data più recente le ultime 5 (abbiamo attributo data su recensione) -> la query mi deve restituire contenuto,data,voto,chiave esterna
    $chiavesterna = $arr[$i]['idVideogioco'];
    $titoloRecX = $arr[$i]['titolo'];
    $contenuto = $arr[$i]['contenuto'];
    $voto = $arr[$i]['voto'];

    $chiavesterna=mysqli_real_escape_string($db,$chiavesterna);
    $queryXimg = "SELECT * FROM videogioco WHERE titolo='$chiavesterna'";
    $result = mysqli_query($db,$queryXimg);
    $rr=$result->fetch_array(MYSQLI_ASSOC);
    $percorsoImg=$rr['imgLocandina'];
    mysqli_free_result($result);

// -> con la chiave esterna titolo riesco a reperirmi la img del gioco
    $divRecX = $divRec->appendChild($doc->createElement('div'));
    $imgForm = $divRecX->appendChild($doc->createElement('form'));
    $imgForm->setAttribute('action', 'recensioneGioco.php');
    $imgForm->setAttribute('method', 'POST');
    $imgForm->setAttribute('class','formRecensioni');
    $buttonImg = $imgForm->appendChild($doc->createElement('button'));
    $buttonImg->setAttribute('name','recensione');
    $imgtag = $buttonImg->appendChild($doc->createElement('img'));
    $imgRecX = $buttonImg->appendChild($doc->createElement('img'));
    $imgRecX->setAttribute('class','r1'); 
    $imgRecX->setAttribute('src',$percorsoImg);
    $imgRecX->setAttribute('alt',$chiavesterna);
    $imgRecX->setAttribute('name','immagine');
    $imgRecX->setAttribute('value',$titoloRecX);
    $divCommentoX = $divRecX->appendChild($doc->createElement('div'));
    $divCommentoX->setAttribute('class','commento');
    $divContenutoRecX = $divCommentoX->appendChild($doc->createElement('div'));
    $divContenutoRecX->setAttribute('class','contenutoRecensione');
    $spanRecX = $divContenutoRecX->appendChild($doc->createElement('span'));
    $spanRecX->setAttribute('class','titoloCritica');
    $linkSpanRecX = $spanRecX->appendChild($doc->createElement('p'));
    $linkSpanRecX = $linkSpanRecX->appendChild($doc->createTextNode($titoloRecX));
    $contenutoRecX = $divContenutoRecX->appendChild($doc->createElement('p'));
    $contenutoRecX = $contenutoRecX->appendChild($doc->createTextNode($contenuto));
    $punteggioX = $divCommentoX->appendChild($doc->createElement('p'));
    $punteggioX->setAttribute('class','punteggio');
    $punteggioX = $punteggioX->appendChild($doc->createTextNode($voto));
}

CloseCon($db);

//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>