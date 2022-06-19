<?php 
ob_start(); 


?>
<!-- enctype pour l'upload des images -->
<form method="POST" action="<?= URL ?>articles/validate" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Titre : </label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="text">Texte : </label>
        <textarea name="text" id="" cols="30" rows="10"class="form-control" id="text"></textarea>
        
    </div>
    <div class="form-group">
        <label for="image">Image : </label>
        <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Valider</button>
</form>

<?php
$content = ob_get_clean();
$title = "Ajouter un article";
require "template.php";
?>