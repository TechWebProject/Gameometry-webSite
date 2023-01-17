<?php
require_once "template.php";

$template = new template();
$template->setPage("template500.html");
$errorpage = $template->initializePage();

echo $errorpage;
?>
