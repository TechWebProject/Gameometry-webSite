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
$head = str_replace("<title>Gameometry</title>","<title>Gameometry | Modifica Utente</title>", $head);
$head = str_replace("Pagina dedicata alle informazioni di un singolo utente", "Modifica della propria area personale", $head);
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
$h1 = $h1->appendChild($doc->createTextNode('MODIFICA DEL PROFILO'));

$div = $main->appendChild($doc->createElement('div'));
$div->setAttribute('id','modificaUtenza');

$form = $div->appendChild($doc->createElement('form'));
$form->setAttribute('action','modificaUtente.php');
$form->setAttribute('method','POST');

$h2 = $form->appendChild($doc->createElement('h2'));
$h2->setAttribute('id','loginTitle');
$h2Content = $h2->appendChild($doc->createElement('span'));
$h2Content->setAttribute('lang','en');
$h2Content = $h2Content->appendChild($doc->createTextNode('Modifica i tuoi dati'));

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
$spanUserInput->setAttribute('placeholder','Digita il nuovo username');
$spanUserInput->setAttribute('maxlength','30');

$spanUsernameMessage = $fieldset->appendChild($doc->createElement('span'));
$spanUsernameMessage->setAttribute('id','errorUsernameRegister');

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
$spanPasswordInput->setAttribute('placeholder','Digita la nuova password');
$spanPasswordInput->setAttribute('maxlength','12'); 

$spanPasswordMessage = $fieldset->appendChild($doc->createElement('span'));
$spanPasswordMessage->setAttribute('id','errorPasswordRegister');

$spanGeneralMessage = $fieldset->appendChild($doc->createElement('span'));
$spanGeneralMessage->setAttribute('id','errorGeneralRegister');

$spanRegister = $fieldset->appendChild($doc->createElement('span'));
$spanRegister->setAttribute('id','registerBox');
$buttonS = $spanRegister->appendChild($doc->createElement('button'));
$buttonS->setAttribute('type','submit');
$buttonS->setAttribute('id','submit');
$buttonS->setAttribute('name','modifyButton');
$buttonS->setAttribute('aria-label','applica le modifiche al tuo profilo');
$buttonS = $buttonS->appendChild($doc->createTextNode('CONFERMA')); 

if(isset($_POST['modifyButton']) && $_POST['username']!="" && $_POST['password']!=""){
    $email = $_SESSION['email'];
    $inputNickname = $_POST['username'];
    $inputPassword = $_POST['password'];

    $db=OpenCon();

    //controllo del nickname
    $testNickName = str_split($inputNickname);
    $correctNickname = true;

    $notAllowed = array(" ","'","\"","?","!","$","~",">","<",",","|","\\",";","}","{","=","+","(",")","*","&","^","%","#","@","`");

    foreach($testNickName as $test){
        if(in_array($test, $notAllowed)){
            $correctNickname = false;
        }
    }

    if($correctNickname==false){
        $spanUsernameMessage->appendChild($doc->createTextNode('Sintassi del nickname errata'));
    }
    else {
        $query_check_nickname="SELECT * FROM utente WHERE utente.nickname='$inputNickname'";
        $result_nickname=mysqli_query($db,$query_check_nickname);
        $nicknameOK=$result_nickname->fetch_array(MYSQLI_ASSOC);
        if(isset($nicknameOK)){
            $spanUsernameMessage->appendChild($doc->createTextNode('Nickname già in uso nel sistema'));
        } 
    }

    //controllo della password
    $testPassword = str_split($inputPassword);
    $correctPassword = true;

    $passwordNotAllowed = array(" ","'","\"","$","~",">","<",",","|","\\",";","}","{","=","+","(",")","*","&","^","%","#","@","`","-","_");

    foreach($testPassword as $test){
        if(in_array($test, $passwordNotAllowed)){
            $correctPassword = false;
        }
    }

    if($correctPassword==false){
        $spanPasswordMessage->appendChild($doc->createTextNode('Non è possibile utilizzare spazi o singoli/doppi apici'));
    }

    //aggiornamento del DB
    if($correctNickname && $correctPassword){
        $oldNickname = $_SESSION['username'];
        $modifyUser="UPDATE utente SET nickname='$inputNickname', password='$inputPassword' WHERE utente.nickname='$oldNickname'";
        $resultUpdate=mysqli_query($db,$modifyUser);

        $_SESSION['username'] = $inputNickname;

        mysqli_free_result($result);

        CloseCon($db);

        header("Location: areaUtente.php");
    }
    else {
        mysqli_free_result($result);

        CloseCon($db);
    }
}
else if(isset($_POST['modifyButton'])) {
    $spanGeneralMessage = $spanGeneralMessage->appendChild($doc->createTextNode('Tutti i campi devono essere compilati'));
}

$scriptControllo = $main->appendChild($doc->createElement('script'));
$scriptControllo->setAttribute('type', 'text/JavaScript');
$scriptControllo->setAttribute('src', 'Componenti/scriptControllo.js');

//footer
$footer=file_get_contents("sezioniComuni/footer.html");
$body->appendChild($doc->createTextNode($footer));

$doc->formatOutput=true;
echo html_entity_decode($doc->saveHTML(),ENT_QUOTES,"UTF-8");
?>