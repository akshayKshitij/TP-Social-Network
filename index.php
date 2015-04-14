<?php
require 'settings.php';
$a=Settings::$mainPageAddress;
header("Location: $a/main_pages/login.html");
die();
?>

