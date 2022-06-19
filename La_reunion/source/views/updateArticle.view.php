<?php 
ob_start(); 
?>

<form method="POST" action="<?= URL ?>articles/updateValidation" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Titre : </label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $article->getTitle() ?>">
    </div>
    <div class="form-group">
        <label for="text">Texte : </label>        
        <textarea name="text" id="" cols="30" rows="10"class="form-control" id="text"><?= $article->getText() ?></textarea>
    </div>
    <h3>Images : </h3>
    <!-- aperçu de l'image actuelle -->
    <img src="<?= URL ?>public/images/<?= $article->getImage() ?>">
    <div class="form-group">
        <label for="image">Changer l'image : </label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <!-- id de l'article -->
    <!-- on récupère dans la $_POST la propriété de l'identifiant qui contient l'id de l'article -->
    <input type="hidden" name="idArticle" value="<?= $article->getId(); ?>">
    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php
$content = ob_get_clean();
$title = "Modification de l'article : ".$article->getId();
require "template.php";
?>