<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("&raquo; Notizie","",$header);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Questa pagina è dedicata al mondo videoludico e, più nello specifico, alle recensioni legate a questo tipo di mondo", $head);
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

for($i = 2; $i < 12; $i++){ /* per il momento impostato così, sarebbe bello farlo randomico */
    $res = $str.$dir[$i];
    $trimmedword = RemoveSpecialChar($dir,$i);
    $imgz[$i-2]=array('src' => $res , 'alt' => $trimmedword);
}

foreach ($imgz as $attributes) {
    $imgtag = $divSlider->appendChild($doc->createElement('img'));
    foreach ($attributes as $key => $value) {
        $imgtag->setAttribute($key, $value);
        if($key=='alt'){
            $key=str_replace('locandina ','',$value);
            $imgtag->setAttribute('name',$value);
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

/*

//Query che trova quanti videogiochi ci sono attualmente
$db1=OpenCon();

$tmpquery= "SELECT COUNT(*) as Conto FROM videogioco";

$result = mysqli_query($db1,$tmpquery);

$r = mysqli_fetch_all($result,MYSQLI_ASSOC);

$count = $r[0]['Conto'];

for($i=0;$i<4;$i++){
//Query che prende in base alla data più recente le ultime 5 (abbiamo attributo data su recensione) -> la query mi deve restituire contenuto,data,voto,chiave esterna
// -> con la chiave esterna titolo riesco a reperirmi la img del gioco
    $divRecX = $divRec->appendChild($doc->createElement('div'));
    $imgRecX = $divRecX->appendChild($doc->createElement('img'));
    $imgRecX->setAttribute('class','r1'); 
    $imgRecX->setAttribute('src',PercorsoDaimgLocandina);
    $imgRecX->setAttribute('alt',titolo);
    $imgRecX->setAttribute('name',titolo);
}

*/

$divRec1 = $divRec->appendChild($doc->createElement('div'));
$divRec1->setAttribute('class','post');
$imgRec1 = $divRec1->appendChild($doc->createElement('img'));
$imgRec1->setAttribute('class','r1');
$imgRec1->setAttribute('src','Immagini/locandinaGioco.png');
$imgRec1->setAttribute('alt','locandina videogioco recensito');
$divCommento1 = $divRec1->appendChild($doc->createElement('div'));
$divCommento1->setAttribute('class','commento');
$divContenutoRec1 = $divCommento1->appendChild($doc->createElement('div'));
$divContenutoRec1->setAttribute('class','contenutoRecensione');
$spanRec1 = $divContenutoRec1->appendChild($doc->createElement('span'));
$spanRec1->setAttribute('class','titoloCritica');
$linkSpanRec1 = $spanRec1->appendChild($doc->createElement('a'));
$linkSpanRec1->setAttribute('href','recensioneGioco.php');
$linkSpanRec1 = $linkSpanRec1->appendChild($doc->createTextNode('Titolo recensione videogioco: breve commento'));
$contenutoRec1 = $divContenutoRec1->appendChild($doc->createElement('p'));
$rec1 = "una gelida avventura dell'ultimo viaggio di Santa Monica Studio tra i regni della mitologia norrena, che arriva ad oltre quattro anni dall'esordio di una delle migliori esclusive della scorsa generazione. Sulle spalle del team diretto da Eric Williams grava dunque il peso di un'immane responsabilità, che coincide con la necessità  di chiudere nel migliore dei modi un'odissea creativa assolutamente memorabile. Un ambizioso traguardo che a nostro avviso è stato raggiunto con uno slancio formidabile, e questo è di fatto l'unico spoiler che troverete in questa recensione";
$contenutoRec1 = $contenutoRec1->appendChild($doc->createTextNode($rec1));
$punteggio1 = $divCommento1->appendChild($doc->createElement('p'));
$punteggio1->setAttribute('class','punteggio');
$punteggio1 = $punteggio1->appendChild($doc->createTextNode('7.5'));

$divRec2 = $divRec->appendChild($doc->createElement('div'));
$divRec2->setAttribute('class','post');
$imgRec2 = $divRec2->appendChild($doc->createElement('img'));
$imgRec2->setAttribute('class','r1');
$imgRec2->setAttribute('src','Immagini/locandinaGioco.png');
$imgRec2->setAttribute('alt','locandina videogioco recensito');
$divCommento2 = $divRec2->appendChild($doc->createElement('div'));
$divCommento2->setAttribute('class','commento');
$divContenutoRec2 = $divCommento2->appendChild($doc->createElement('div'));
$divContenutoRec2->setAttribute('class','contenutoRecensione');
$spanRec2 = $divContenutoRec2->appendChild($doc->createElement('span'));
$spanRec2->setAttribute('class','titoloCritica');
$linkSpanRec2 = $spanRec2->appendChild($doc->createElement('a'));
$linkSpanRec2->setAttribute('href','recensioneGioco.php');
$linkSpanRec2 = $linkSpanRec2->appendChild($doc->createTextNode('Titolo recensione videogioco: breve commento'));
$contenutoRec2 = $divContenutoRec2->appendChild($doc->createElement('p'));
$rec2 = "una gelida avventura dell'ultimo viaggio di Santa Monica Studio tra i regni della mitologia norrena, che arriva ad oltre quattro anni dall'esordio di una delle migliori esclusive della scorsa generazione. Sulle spalle del team diretto da Eric Williams grava dunque il peso di un'immane responsabilità, che coincide con la necessità  di chiudere nel migliore dei modi un'odissea creativa assolutamente memorabile. Un ambizioso traguardo che a nostro avviso è stato raggiunto con uno slancio formidabile, e questo è di fatto l'unico spoiler che troverete in questa recensione";
$contenutoRec2 = $contenutoRec2->appendChild($doc->createTextNode($rec1));
$punteggio2 = $divCommento2->appendChild($doc->createElement('p'));
$punteggio2->setAttribute('class','punteggio');
$punteggio2 = $punteggio2->appendChild($doc->createTextNode('7.5'));

$divRec3 = $divRec->appendChild($doc->createElement('div'));
$divRec3->setAttribute('class','post');
$imgRec3 = $divRec3->appendChild($doc->createElement('img'));
$imgRec3->setAttribute('class','r1');
$imgRec3->setAttribute('src','Immagini/locandinaGioco.png');
$imgRec3->setAttribute('alt','locandina videogioco recensito');
$divCommento3 = $divRec3->appendChild($doc->createElement('div'));
$divCommento3->setAttribute('class','commento');
$divContenutoRec3 = $divCommento3->appendChild($doc->createElement('div'));
$divContenutoRec3->setAttribute('class','contenutoRecensione');
$spanRec3 = $divContenutoRec3->appendChild($doc->createElement('span'));
$spanRec3->setAttribute('class','titoloCritica');
$linkSpanRec3 = $spanRec3->appendChild($doc->createElement('a'));
$linkSpanRec3->setAttribute('href','recensioneGioco.php');
$linkSpanRec3 = $linkSpanRec3->appendChild($doc->createTextNode('Titolo recensione videogioco: breve commento'));
$contenutoRec3 = $divContenutoRec3->appendChild($doc->createElement('p'));
$rec3 = "una gelida avventura dell'ultimo viaggio di Santa Monica Studio tra i regni della mitologia norrena, che arriva ad oltre quattro anni dall'esordio di una delle migliori esclusive della scorsa generazione. Sulle spalle del team diretto da Eric Williams grava dunque il peso di un'immane responsabilità, che coincide con la necessità  di chiudere nel migliore dei modi un'odissea creativa assolutamente memorabile. Un ambizioso traguardo che a nostro avviso è stato raggiunto con uno slancio formidabile, e questo è di fatto l'unico spoiler che troverete in questa recensione";
$contenutoRec3 = $contenutoRec3->appendChild($doc->createTextNode($rec1));
$punteggio3 = $divCommento3->appendChild($doc->createElement('p'));
$punteggio3->setAttribute('class','punteggio');
$punteggio3 = $punteggio3->appendChild($doc->createTextNode('7.5'));

$divRec4 = $divRec->appendChild($doc->createElement('div'));
$divRec4->setAttribute('class','post');
$imgRec4 = $divRec4->appendChild($doc->createElement('img'));
$imgRec4->setAttribute('class','r1');
$imgRec4->setAttribute('src','Immagini/locandinaGioco.png');
$imgRec4->setAttribute('alt','locandina videogioco recensito');
$divCommento4 = $divRec4->appendChild($doc->createElement('div'));
$divCommento4->setAttribute('class','commento');
$divContenutoRec4 = $divCommento4->appendChild($doc->createElement('div'));
$divContenutoRec4->setAttribute('class','contenutoRecensione');
$spanRec4 = $divContenutoRec4->appendChild($doc->createElement('span'));
$spanRec4->setAttribute('class','titoloCritica');
$linkSpanRec4 = $spanRec4->appendChild($doc->createElement('a'));
$linkSpanRec4->setAttribute('href','recensioneGioco.php');
$linkSpanRec4 = $linkSpanRec4->appendChild($doc->createTextNode('Titolo recensione videogioco: breve commento'));
$contenutoRec4 = $divContenutoRec4->appendChild($doc->createElement('p'));
$rec4 = "una gelida avventura dell'ultimo viaggio di Santa Monica Studio tra i regni della mitologia norrena, che arriva ad oltre quattro anni dall'esordio di una delle migliori esclusive della scorsa generazione. Sulle spalle del team diretto da Eric Williams grava dunque il peso di un'immane responsabilità, che coincide con la necessità  di chiudere nel migliore dei modi un'odissea creativa assolutamente memorabile. Un ambizioso traguardo che a nostro avviso è stato raggiunto con uno slancio formidabile, e questo è di fatto l'unico spoiler che troverete in questa recensione";
$contenutoRec4 = $contenutoRec4->appendChild($doc->createTextNode($rec1));
$punteggio4 = $divCommento4->appendChild($doc->createElement('p'));
$punteggio4->setAttribute('class','punteggio');
$punteggio4 = $punteggio4->appendChild($doc->createTextNode('7.5'));

$divRec5 = $divRec->appendChild($doc->createElement('div'));
$divRec5->setAttribute('class','post');
$imgRec5 = $divRec5->appendChild($doc->createElement('img'));
$imgRec5->setAttribute('class','r1');
$imgRec5->setAttribute('src','Immagini/locandinaGioco.png');
$imgRec5->setAttribute('alt','locandina videogioco recensito');
$divCommento5 = $divRec5->appendChild($doc->createElement('div'));
$divCommento5->setAttribute('class','commento');
$divContenutoRec5 = $divCommento5->appendChild($doc->createElement('div'));
$divContenutoRec5->setAttribute('class','contenutoRecensione');
$spanRec5 = $divContenutoRec5->appendChild($doc->createElement('span'));
$spanRec5->setAttribute('class','titoloCritica');
$linkSpanRec5 = $spanRec5->appendChild($doc->createElement('a'));
$linkSpanRec5->setAttribute('href','recensioneGioco.php');
$linkSpanRec5 = $linkSpanRec5->appendChild($doc->createTextNode('Titolo recensione videogioco: breve commento'));
$contenutoRec5 = $divContenutoRec5->appendChild($doc->createElement('p'));
$rec5 = "una gelida avventura dell'ultimo viaggio di Santa Monica Studio tra i regni della mitologia norrena, che arriva ad oltre quattro anni dall'esordio di una delle migliori esclusive della scorsa generazione. Sulle spalle del team diretto da Eric Williams grava dunque il peso di un'immane responsabilità, che coincide con la necessità  di chiudere nel migliore dei modi un'odissea creativa assolutamente memorabile. Un ambizioso traguardo che a nostro avviso è stato raggiunto con uno slancio formidabile, e questo è di fatto l'unico spoiler che troverete in questa recensione";
$contenutoRec5 = $contenutoRec5->appendChild($doc->createTextNode($rec1));
$punteggio5 = $divCommento5->appendChild($doc->createElement('p'));
$punteggio5->setAttribute('class','punteggio');
$punteggio5 = $punteggio5->appendChild($doc->createTextNode('7.5'));

//ultimi commenti --> prendere da recensioneGioco.php


//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>