<?php
require_once "template.php";

$template = new template();
$template->setPage("template500.html");
$errorpage = $template->initializePage();

http_response_code(500);

$errorpage = str_replace("Titolo_pagina","Error 500",$errorpage);
$errorpage = str_replace("<link rel=\"stylesheet\" href=\"Stili/style.css\" media=\"handheld, screen\" />","<link rel=\"stylesheet\" href=\"Stili/style404.css\" media=\"handheld, screen\"/>",$errorpage);
$errorpage = str_replace("<link rel=\"stylesheet\" href=\"Stili/print.css\" media=\"print\" />"," ",$errorpage);
$errorpage = str_replace("<link rel=\"stylesheet\" href=\"Stili/mini.css\" media=\"handheld, screen and (max-width:820px), only screen and (max-device-width: 800px)\" /> "," ",$errorpage);

echo $errorpage;
?>
