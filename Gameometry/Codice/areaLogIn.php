<?php
require_once "template.php";

$template = new template();
$template->setPage("areaLogIn.html");
$areaLogIn = $template->initializePage();

$areaLogIn = str_replace("Titolo_pagina","Gameometry | Accesso",$areaLogIn);
$areaLogIn = str_replace("parole_chiave", "gameometry, accesso, login, videogioco, videogiochi, utente, recensioni", $areaLogIn);
$areaLogIn = str_replace("descrizione","Accedi a Gameometry per gestire la tua esperienza nel sito!", $areaLogIn);

$areaLogIn = str_replace("</BREADCRUMB_CONTENT>","<p>Ti trovi in: <span lang=\"en\"><a href=\"index.php\">Home</a></span> &raquo; Accesso</p>", $areaLogIn);

if(isset($_POST['loginButton']) && $_POST['username']!="" && $_POST['password']!=""){
    $inputNickname = $_POST['username'];
    $inputPassword = $_POST['password'];

    $db=OpenCon();

    //controllo del nickname
    $correctNickname = false;

    $query_check_nickname="SELECT * FROM utente WHERE utente.nickname='$inputNickname'";
    $result_nickname=mysqli_query($db,$query_check_nickname);
    $nicknameOK=$result_nickname->fetch_array(MYSQLI_ASSOC);
    if(!isset($nicknameOK)){
        $spanUsernameMessage = "Nickname errato o inesistente";
        $areaLogIn = str_replace("<span id=\"errorUsernameRegister\"></span>","<span id=\"errorUsernameRegister\">".$spanUsernameMessage."</span>",$areaLogIn);
    } 
    else {
        $correctNickname = true;
    }

    //controllo della password
    $correctPassword = false;

    $query_check_password="SELECT * FROM utente WHERE utente.nickname='$inputNickname' and utente.password='$inputPassword'";
    $result_nickname=mysqli_query($db,$query_check_password);
    $passwordOK=$result_nickname->fetch_array(MYSQLI_ASSOC);
    if(!isset($passwordOK)){
        $spanPasswordMessage = "Password errata";
        $areaLogIn = str_replace("<span id=\"errorPasswordRegister\"></span>","<span id=\"errorPasswordRegister\">".$spanPasswordMessage."</span>",$areaLogIn);
    } 
    else {
        $correctPassword = true;
    }

    if($correctNickname && $correctPassword){
        $query_check="SELECT utente.email as emailU, utente.dataIscrizione as dataIscrizioneU FROM utente WHERE utente.nickname='$inputNickname' and utente.password='$inputPassword'"; 
        $result=mysqli_query($db,$query_check);
        $tmparr=$result->fetch_array(MYSQLI_ASSOC);

        mysqli_free_result($result);

        CloseCon($db);

        $emailU = $tmparr['emailU'];
        $dataIscrU = $tmparr['dataIscrizioneU'];

        session_start();
        $_SESSION['username'] = $inputNickname;
        $_SESSION['email'] = $emailU;
        $_SESSION['dataIscrizione'] = $dataIscrU;

        header("Location: areaUtente.php");
    }
}
else if(isset($_POST['loginButton'])) {
    $spanGeneralMessage = "Tutti i campi devono essere compilati!";
    $areaLogIn = str_replace("<span id=\"errorGeneralRegister\"></span>","<span id=\"errorGeneralRegister\">".$spanGeneralMessage."</span>",$areaLogIn);
}

if(isset($_GET['message'])){
    $spanGeneralMessage = "Utente eliminato dal sistema!";
    $areaLogIn = str_replace("<span id=\"errorGeneralRegister\"></span>","<span id=\"errorGeneralRegister\">".$spanGeneralMessage."</span>",$areaLogIn);
}

echo $areaLogIn;

?>