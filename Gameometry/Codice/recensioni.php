<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Recensioni</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina &egrave; dedicata alle recensioni videoludiche sugli ultimi prodotti usciti", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, recensioni, recensione, videogioco, videogiochi, voto, commento", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Recensioni",$header);
$body->appendChild($doc->createTextNode($header));

//main
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

$h1 = $main->appendChild($doc->createElement('h1'));
$h1 = $h1->appendChild($doc->createTextNode('LE NOSTRE RECENSIONI'));

$divRec = $main->appendChild($doc->createElement('div'));
$divRec->setAttribute('id','recensioni-critica');

//ultime recensioni codice php
//query per sapere quante recensioni ho nel db

$db=OpenCon();
$query_nrows="SELECT COUNT(*) as nrighe FROM recensione";
$result=mysqli_query($db,$query_nrows);
$tmparr=$result->fetch_array(MYSQLI_ASSOC);
$n_rows=$tmparr['nrighe'];
mysqli_free_result($result);
$query = "SELECT * FROM recensione ORDER BY dataPubblicazione desc";
$result = mysqli_query($db,$query);
$arr = mysqli_fetch_all($result,MYSQLI_ASSOC);

for($i=0;$i<$n_rows;$i++){
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
    $buttonImg->setAttribute('value',$titoloRecX);
    $buttonImg->setAttribute('aria-label','vai alla recensione di '.$chiavesterna);
    $imgRecX = $buttonImg->appendChild($doc->createElement('img'));
    $imgRecX->setAttribute('class','r1'); 
    $imgRecX->setAttribute('src',$percorsoImg);
    $imgRecX->setAttribute('alt',$chiavesterna);
    $divCommentoX = $divRecX->appendChild($doc->createElement('div'));
    $divCommentoX->setAttribute('class','commento');
    $divContenutoRecX = $divCommentoX->appendChild($doc->createElement('div'));
    $divContenutoRecX->setAttribute('class','contenutoRecensione');
    $spanRecX = $divContenutoRecX->appendChild($doc->createElement('span'));
    $spanRecX->setAttribute('class','titoloCritica');
    $linkSpanRecX = $spanRecX->appendChild($doc->createElement('a'));
    $linkSpanRecX->setAttribute('href','./recensioneGioco.php?titRec='.$titoloRecX);
    $linkSpanRecX = $linkSpanRecX->appendChild($doc->createTextNode($titoloRecX));
    $contenutoRecX = $divContenutoRecX->appendChild($doc->createElement('p'));
    $cont=500;
    while($contenuto[$cont]!="."){
        $cont++;
    }
    $contenuto=substr($contenuto,0,$cont);
    $contenuto.="...";
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