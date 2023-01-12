<?php
include "Componenti/connect.php";

$doc = new DOMDocument;
$doc->appendChild($doc->createTextNode('<!DOCTYPE html>'));
$html = $doc->appendChild($doc->createElement('html'));
$html->setAttribute('lang','it');
$body = $doc->appendChild($doc->createElement('body'));

//head
$head=file_get_contents('sezioniComuni/head.html');
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Accesso</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Accedi a Gameometry e gestisci i tuoi commenti", $head);
$head = str_replace("videogioco, videogiochi, utente, recensioni", "gameometry, accesso, login, videogioco, videogiochi, utente, recensioni", $head);
$html->appendChild($doc->createTextNode($head));

//header
$header=file_get_contents('sezioniComuni/header.html');
$header = str_replace("Notizie","Accesso",$header);
if(isset($_SESSION['username'])){
    $header = str_replace('<a id="areaRiservata" href="areaLogIn.php">','<a id="areaRiservata" href="areaUtente.php">',$header);
}
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
$h1 = $h1->appendChild($doc->createTextNode('AREA DI ACCESSO'));

$div = $main->appendChild($doc->createElement('div'));
$div->setAttribute('id','logIn');

$form = $div->appendChild($doc->createElement('form'));
$form->setAttribute('action','areaLogin.php');
$form->setAttribute('method','POST');

$h2 = $form->appendChild($doc->createElement('h2'));
$h2->setAttribute('id','loginTitle');
$h2Content = $h2->appendChild($doc->createElement('span'));
$h2Content->setAttribute('lang','en');
$h2Content = $h2Content->appendChild($doc->createTextNode('Login'));

$fieldset = $form->appendChild($doc->createElement('fieldset'));

$spanUser = $fieldset->appendChild($doc->createElement('span'));
$spanUser->setAttribute('id','usernameBox');
$labelUser = $spanUser->appendChild($doc->createElement('label'));
$labelUser->setAttribute('for','username');
$spanUser2 = $labelUser->appendChild($doc->createElement('span'));
$spanUser2->setAttribute('lang','en');
$spanUser2 = $spanUser2->appendChild($doc->createTextNode('Username'));
$spanUserInput = $spanUser->appendChild($doc->createElement('input'));
$spanUserInput->setAttribute('name','username');
$spanUserInput->setAttribute('id','username');
$spanUserInput->setAttribute('placeholder','Digita il tuo username');
$spanUserInput->setAttribute('maxlength','30');

$spanPassword = $fieldset->appendChild($doc->createElement('span'));
$spanPassword->setAttribute('id','passwordBox');
$labelPassword = $spanPassword->appendChild($doc->createElement('label'));
$labelPassword->setAttribute('for','password');
$spanPassword2 = $labelPassword->appendChild($doc->createElement('span'));
$spanPassword2->setAttribute('lang','en');
$spanPassword2 = $spanPassword2->appendChild($doc->createTextNode('Password'));
$spanPasswordInput = $spanPassword->appendChild($doc->createElement('input'));
$spanPasswordInput->setAttribute('type','password');
$spanPasswordInput->setAttribute('name','password');
$spanPasswordInput->setAttribute('id','password');
$spanPasswordInput->setAttribute('placeholder','Digita la tua password');
$spanPasswordInput->setAttribute('maxlength','12'); 

$spanRegister = $fieldset->appendChild($doc->createElement('span'));
$spanRegister->setAttribute('id','registerBox');
$buttonS = $spanRegister->appendChild($doc->createElement('button'));
$buttonS->setAttribute('type','submit');
$buttonS->setAttribute('id','submit');
$buttonS->setAttribute('name','loginButton');
$buttonS->setAttribute('aria-label','accedi alla tua area personale');
$buttonS = $buttonS->appendChild($doc->createTextNode('ACCEDI')); 

function function_alert($message) {
    echo "<script>alert('$message');</script>";
} 

if(isset($_GET['success'])){
    function_alert("Utente registrato con successo");
}

if(isset($_GET['message'])){
    function_alert("Profilo eliminato dal sistema");
}

if(isset($_POST['loginButton']) && $_POST['username']!="" && $_POST['password']!=""){
    $inputNickname = $_POST['username'];
    $inputPassword = $_POST['password'];

    $db=OpenCon();

    $query_check="SELECT utente.email as emailU, utente.dataIscrizione as dataIscrizioneU FROM utente WHERE utente.nickname='$inputNickname' and utente.password='$inputPassword'"; /* effettua il controllo che i dati siano corretti */
    $result=mysqli_query($db,$query_check);
    $tmparr=$result->fetch_array(MYSQLI_ASSOC);

    if(isset($tmparr)){
        $emailU = $tmparr['emailU'];
        $dataIscrU = $tmparr['dataIscrizioneU'];

        session_start();
        $_SESSION['username'] = $inputNickname;
        $_SESSION['email'] = $emailU;
        $_SESSION['dataIscrizione'] = $dataIscrU;

        header("Location: areaUtente.php");
    }
    else {
        function_alert("Username o password non corretti, riprovare");
    }

    mysqli_free_result($result);

    CloseCon($db);
}
else if(isset($_POST['loginButton'])) {
    function_alert("Username o password non corretti, riprovare");
}

$linkR = $spanRegister->appendChild($doc->createElement('p'));
$linkR->setAttribute('id','linkRegistrazione');
$spazioP = $linkR->appendChild($doc->createElement('span'));
$spazioP->setAttribute('id','spanLinkR');
$spazioP = $spazioP->appendChild($doc->createTextNode('Non possiedi un account?'));
$linkR1 = $linkR->appendChild($doc->createElement('a'));
$linkR1->setAttribute('href','areaRegistrazione.php');
$linkR1 = $linkR1->appendChild($doc->createTextNode('Clicca qui'));
$spazioP1 = $linkR->appendChild($doc->createElement('span'));
$spazioP1 = $spazioP1->appendChild($doc->createTextNode(' per registrarti.'));

//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>