<?php

$pageName = isset($_POST["pageName"]) ? $_POST["pageName"] : null;

if ($pageName) {
	print $pageName;
}

?>