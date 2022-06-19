<?php 
ob_start(); 
?>

<div class="row">
    <div class="col-6">
        <img src="<?= URL ?>public/images/<?= $article->getImage(); ?>">
    </div>
    <div class="col-6">
        <p>Titre : <?= $article->getTitle(); ?></p>
        <p>Texte : <?= $article->getText(); ?></p>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = $article->getTitle();
require "template.php";
?>