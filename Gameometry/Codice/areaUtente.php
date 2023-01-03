<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang', 'it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head = file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>", "<title>Gameometry | Area riservata</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Gestisci la tua esperienza sul sito Gameometry", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, area, riservata, videogioco, videogiochi, utente, recensioni", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header = file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie", "Area riservata", $header);
$body->appendChild($doc->createTextNode($header));

//searchBar
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

$labelTitoli = $body->appendChild($doc->createElement('label'));
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

$searchscript = $body->appendChild($doc->createElement('script'));
$searchscript->setAttribute('type','text/JavaScript');
$searchscript->setAttribute('src','Componenti/scriptSearch.js');  

//main
$main = $body->appendChild($doc->createElement('main'));

$userInfo = file_get_contents('Componenti/userInfo.html');
$main->appendChild($doc->createTextNode($userInfo));

$divLogout = $main->appendChild($doc->createElement('div'));
$buttonLogout = $divLogout->appendChild($doc->createElement('button'));
$buttonLogout->setAttribute('id','logoutB');
$buttonLogout->setAttribute('name','logoutButton');
$spanButtonLogout = $buttonLogout->appendChild($doc->createElement('span'));
$spanButtonLogout->setAttribute('lang','en');
$linkSpan = $spanButtonLogout->appendChild($doc->createElement('a'));
$linkSpan->setAttribute('href','areaLogin.php');
$linkSpan = $linkSpan->appendChild($doc->createTextNode('Logout')); /* dovrà chiudere la sessione attiva */

$listaCommenti = $main->appendChild($doc->createElement('h2'));
$listaCommenti->setAttribute('class','titleH2');
$listaCommenti = $listaCommenti->appendChild($doc->createTextNode('I MIEI COMMENTI'));

//footer
$footer = file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput = true;
echo html_entity_decode($doc->saveHTML(), ENT_QUOTES, "UTF-8");

?>