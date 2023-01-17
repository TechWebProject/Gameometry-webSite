<?php
include "Componenti/connect.php";

class template{

    public $page;

    public function setPage($page){
        $this->page = $page;
    }

    public function getPage(){
        return $this->page;
    }

    public function initializePage(){
        session_start();
        $pageToFill = file_get_contents("html/".$this->getPage());
        $head = file_get_contents("sezioniComuni/head.html");
        $pageToFill = str_replace("</HEAD>",$head,$pageToFill);
        $header = file_get_contents("sezioniComuni/header.html");
        $pageToFill = str_replace("</HEADER>",$header,$pageToFill);

        if (isset($_SESSION['username'])) {
            $header = str_replace('<a id="areaRiservata" href="areaLogIn.php">', '<a id="areaRiservata" href="areaUtente.php">', $header);
        }
        
        $db = OpenCon();

        $query = "SELECT titolo FROM videogioco";
        $result = mysqli_query($db, $query);
        $arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $n_rows=mysqli_num_rows($result);

        mysqli_free_result($result);

        CloseCon($db);

        $t = '';
        for ($i = 0; $i < $n_rows; $i++) {
            if ($i == $n_rows - 1) {
                $t .= $arr[$i]['titolo'];
            } else {
                $t .= $arr[$i]['titolo'] . ',';
            }
        }
        $pageToFill = str_replace("<label id=\"arrTitoli\">","<label id=\"arrTitoli\">$t",$pageToFill);

        $footer = file_get_contents("sezioniComuni/footer.html");
        $pageToFill = str_replace("</FOOTER>",$footer,$pageToFill);

        return $pageToFill;
    }
}

?>