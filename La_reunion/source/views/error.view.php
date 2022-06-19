<?php 
ob_start(); 
?>

<?= $message; ?>

<?php
$content = ob_get_clean();
$title = "Erreurs";
require "template.php";
?>