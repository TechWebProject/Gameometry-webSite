<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
session_start();
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
if(isset($_SESSION['username'])){
    $header = str_replace('<a id="areaRiservata" href="areaLogIn.php">','<a id="areaRiservata" href="areaUtente.php">',$header);
}
$body->appendChild($doc->createTextNode($header));

//searchBar
$db=OpenCon();

$query_nrows="SELECT COUNT(*) as nrighe FROM videogioco";
$result=mysqli_query($db,$query_nrows);
$tmparr=$result->fetch_array(MYSQLI_ASSOC);
$n_rows=$tmparr['nrighe'];

mysqli_free_result($result);

$query="SELECT titolo FROM videogioco";
$result=mysqli_query($db,$query);
$arr=mysqli_fetch_all($result, MYSQLI_ASSOC);

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

$email = $_SESSION['email'];

$nCommenti="SELECT COUNT(*) as nComm FROM commento WHERE commento.idUtente='$email'";
$result=mysqli_query($db,$nCommenti);
$arr=$result->fetch_array(MYSQLI_ASSOC);
$nComm=$arr['nComm'];

$userInfo = file_get_contents('Componenti/userInfo.html');
$userInfo = str_replace("genericUser", $_SESSION['username'], $userInfo);
$userInfo = str_replace("user@dom.it", $_SESSION['email'], $userInfo);
$userInfo = str_replace("aaaa/mm/gg", $_SESSION['dataIscrizione'], $userInfo);
$userInfo = str_replace("NaN", "$nComm", $userInfo);
$main->appendChild($doc->createTextNode($userInfo));

$formLogout = $main->appendChild($doc->createElement('form'));
$formLogout->setAttribute('action','areaUtente.php');
$formLogout->setAttribute('method','POST');
$buttonLogout = $formLogout->appendChild($doc->createElement('button'));
$buttonLogout->setAttribute('id','logoutB');
$buttonLogout->setAttribute('type','submit');
$buttonLogout->setAttribute('name','logoutButton');
$spanButtonLogout = $buttonLogout->appendChild($doc->createElement('span'));
$spanButtonLogout->setAttribute('lang','en');
$spanButtonLogout = $spanButtonLogout->appendChild($doc->createTextNode('Logout')); 

if(isset($_POST['logoutButton'])){
    session_unset(); /* azzera le variabili */
    session_destroy(); /* distrugge la sessione */

    header("Location: areaLogin.php");
}

$listaCommenti = $main->appendChild($doc->createElement('h2'));
$listaCommenti->setAttribute('class','titleH2');
$listaCommenti = $listaCommenti->appendChild($doc->createTextNode('I MIEI COMMENTI'));

//commenti
$tmpquery= "SELECT videogioco.titolo as title, commento.contenuto as contenutoU, commento.voto as votoU FROM utente,commento,recensione,videogioco WHERE commento.idUtente=utente.email and commento.idVideogioco=videogioco.titolo and recensione.idVideogioco=videogioco.titolo and utente.email='$email' ORDER BY commento.data desc";
$result2 = mysqli_query($db,$tmpquery);
$arr2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);
mysqli_free_result($result2);

CloseCon($db);

if($nComm>0){
    $div_commenti = $main->appendChild($doc->createElement('div'));
    $div_commenti->setAttribute('id', 'recensioni-utenti');

    for($i=0;$i<$nComm;$i++){
        $nickname = $arr2[$i]['title'];
        $contenuto=$arr2[$i]['contenutoU'];
        $votoU=$arr2[$i]['votoU']; 
    
        $div_post= $div_commenti->appendChild($doc->createElement('div'));
        $div_post->setAttribute('class', 'postU');
    
        $div_postCommento = $div_post->appendChild($doc->createElement('div'));
        $div_postCommento->setAttribute('class', 'commento');
    
        $ul_contenuto = $div_postCommento->appendChild($doc->createElement('ul'));
        $ul_contenuto->setAttribute('class', 'contenutoRecensioneU1');
    
        $li_utente = $ul_contenuto->appendChild($doc->createElement('li'));
        $li_utente->setAttribute('class','toBold');
        $li_utente = $li_utente->appendChild($doc->createTextNode($nickname));
        $li_commento = $ul_contenuto->appendChild($doc->createElement('li'));
        $li_commento = $li_commento->appendChild($doc->createTextNode($contenuto));
    
        $div_punteggio = $div_post->appendChild($doc->createElement('div'));
        $div_punteggio->setAttribute('class','boxPunteggioU1');
        $p_punteggio = $div_punteggio->appendChild($doc->createElement('p'));
        $p_punteggio->setAttribute('class', 'punteggioU');
        $p_punteggio = $p_punteggio->appendChild($doc->createTextNode($votoU));
    }
}
else {
    $divMess = $main->appendChild($doc->createElement('div'));
    $divMess->setAttribute('id','messageU');
    $message = $divMess->appendChild($doc->createElement('span'));
    $message->setAttribute('id','messageU1');
    $message = $message->appendChild($doc->createTextNode('Non hai ancora commentanto nessun videogioco. Per farlo recati '));
    $messageLink = $divMess->appendChild($doc->createElement('a'));
    $messageLink->setAttribute('id','messageU2');
    $messageLink->setAttribute('href','recensioni.php');
    $messageLink = $messageLink->appendChild($doc->createTextNode('qui'));
    $messagept2 = $divMess->appendChild($doc->createElement('span'));
    $messagept2->setAttribute('id','messageU3');
    $messagept2 = $messagept2->appendChild($doc->createTextNode(", leggi una delle recensioni che ti proponiamo e dacci anche una tua opinione sul videogioco!"));
}

//footer
$footer = file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput = true;
echo html_entity_decode($doc->saveHTML(), ENT_QUOTES, "UTF-8");

?>