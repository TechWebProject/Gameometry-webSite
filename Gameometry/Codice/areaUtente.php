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

$formUserOptions = $main->appendChild($doc->createElement('form'));
$formUserOptions->setAttribute('action','areaUtente.php');
$formUserOptions->setAttribute('method','POST');

$buttonLogout = $formUserOptions->appendChild($doc->createElement('button'));
$buttonLogout->setAttribute('id','logoutB');
$buttonLogout->setAttribute('aria-label','esci dal tuo profilo');
$buttonLogout->setAttribute('type','submit');
$buttonLogout->setAttribute('name','logoutButton');
$buttonLogout = $buttonLogout->appendChild($doc->createTextNode('Esci')); 

$buttonDeleteU = $formUserOptions->appendChild($doc->createElement('button'));
$buttonDeleteU->setAttribute('id','deleteAccount');
$buttonDeleteU->setAttribute('aria-label','elimina il tuo profilo');
$buttonDeleteU->setAttribute('type','submit');
$buttonDeleteU->setAttribute('name','deleteU');
$buttonDeleteU = $buttonDeleteU->appendChild($doc->createTextNode('Elimina profilo')); 

function function_alert($message) {
    echo "<script>alert('$message');</script>";
}

if(isset($_POST['logoutButton'])){
    session_unset(); 
    session_destroy(); 

    header("Location: areaLogin.php");
}

if(isset($_POST['deleteU'])){
    $deleteUser="DELETE FROM utente WHERE utente.email = '$email'";
    $result=mysqli_query($db,$deleteUser);

    session_unset(); 
    session_destroy(); 

    header("Location: areaLogin.php?message=success");
}

$listaCommenti = $main->appendChild($doc->createElement('h2'));
$listaCommenti->setAttribute('class','titleH2');
$listaCommenti = $listaCommenti->appendChild($doc->createTextNode('I MIEI COMMENTI'));

//inserimento commento
function generateRandomString($length = 30) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for($i = 0; $i < $length; $i++){
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if(isset($_POST['inviaCommento']) && isset($_POST['commentoU']) && isset($_POST['rating'])){
    $gameTitle = $_POST['inviaCommento2'];

    $commentoUtente = $_POST['commentoU'];
    $votoUtente = $_POST['rating'];
    $votoUtente = number_format($votoUtente);
    $email = $_SESSION['email'];
    $currentDate = date("Y-m-d");

    do{
        $idCommento = generateRandomString();

        $query_check="SELECT * FROM commento WHERE commento.idCommento='$idCommento'";
        $result=mysqli_query($db,$query_check);
        $tmparr=$result->fetch_array(MYSQLI_ASSOC);
    }while(isset($tmparr));

    $gameTitle=mysqli_real_escape_string($db,$gameTitle);

    $query_insert="insert into commento (idCommento, data, voto, contenuto, idUtente, idVideogioco) values ('$idCommento', '$currentDate', $votoUtente, '$commentoUtente', '$email', '$gameTitle')";

    $result = mysqli_query($db,$query_insert);

    function_alert("Commento caricato con successo");
    header("Location: recensioni.php?message=success");
}
else if(isset($_POST['inviaCommento'])){
    function_alert("Per poter commentare un videogioco devi inserire un commento e un voto. Controlla di averli inseriti entrambi e riprova");
}

//commenti
$tmpquery= "SELECT videogioco.titolo as title, commento.contenuto as contenutoU, commento.voto as votoU FROM utente,commento,recensione,videogioco WHERE commento.idUtente=utente.email and commento.idVideogioco=videogioco.titolo and recensione.idVideogioco=videogioco.titolo and utente.email='$email' ORDER BY commento.data desc";
$result2 = mysqli_query($db,$tmpquery);
$arr2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);
mysqli_free_result($result2);

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
        $div_postCommento->setAttribute('class', 'commentoU');
    
        $ul_contenuto = $div_postCommento->appendChild($doc->createElement('ul'));
        $ul_contenuto->setAttribute('class', 'contenutoRecensioneU1');
    
        $li_utente = $ul_contenuto->appendChild($doc->createElement('li'));
        $li_utente->setAttribute('class','toBold');
        $link_titolo=$li_utente->appendChild($doc->createElement('a'));

        $nickname=mysqli_real_escape_string($db,$nickname);
        $queryxtitrec="SELECT titolo as titoloRec FROM recensione WHERE idVideogioco='$nickname'";
        $result2 = mysqli_query($db,$queryxtitrec);
        $r=$result2->fetch_array(MYSQLI_ASSOC);
        mysqli_free_result($result2);
        $titoloRec=$r['titoloRec'];

        $link_titolo->setAttribute('href','./recensioneGioco.php?titRec=' .$titoloRec);
        $link_titolo->setAttribute('class','');
        $nickname=str_replace("\'","'",$nickname);
        $link_titolo->appendChild($doc->createTextNode($nickname));
        $li_commento = $ul_contenuto->appendChild($doc->createElement('li'));
        $li_commento = $li_commento->appendChild($doc->createTextNode($contenuto));
    
        $div_punteggio = $div_post->appendChild($doc->createElement('div'));
        $div_punteggio->setAttribute('class','boxPunteggioU1');
        $p_punteggio = $div_punteggio->appendChild($doc->createElement('p'));
        $p_punteggio->setAttribute('class', 'punteggioU');
        $p_punteggio = $p_punteggio->appendChild($doc->createTextNode($votoU));
    }
    CloseCon($db);
}
else {
    $divMess = $main->appendChild($doc->createElement('div'));
    $divMess->setAttribute('id','messageU');
    $message = $divMess->appendChild($doc->createElement('span'));
    $message = $message->appendChild($doc->createTextNode('Non hai ancora commentanto nessun videogioco. Per farlo recati '));
    $messageLink = $divMess->appendChild($doc->createElement('a'));
    $messageLink->setAttribute('href','recensioni.php');
    $messageLink = $messageLink->appendChild($doc->createTextNode('qui'));
    $messagept2 = $divMess->appendChild($doc->createElement('span'));
    $messagept2 = $messagept2->appendChild($doc->createTextNode(" , leggi una delle recensioni che ti proponiamo e dacci una tua opinione sul videogioco scelto!"));
}

//footer
$footer = file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput = true;
echo html_entity_decode($doc->saveHTML(), ENT_QUOTES, "UTF-8");

?>