<?php
ob_start();

?>



La page d'accueil

<?php
$content = ob_get_clean();
$title = "Les articles du blog";
require "template.php";

?>