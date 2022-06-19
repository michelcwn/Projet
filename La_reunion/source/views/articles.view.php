<?php
ob_start();

// on cherche a savoir s'il y a des infos dans la variable de session
if (!empty($_SESSION['alert'])) :
?>
    <div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
        <?= $_SESSION['alert']['message'] ?>
    </div>
<?php
    // on vide la variable de session une fois la réalisation effectuée
    unset($_SESSION['alert']);
endif;
?>

<table class="table text-center">
    <tr class="table-dark">
        <th>Image</th>
        <th>Titre</th>
        <th>Texte</th>
        <th colspan="2">Actions</th>
    </tr>
    <?php
    for ($i = 0; $i < count($articles); $i++) :
    ?>
        <tr>
            <td class="align-middle"><img src="public/images/<?= $articles[$i]->getImage(); ?>" width="60px;"></td>
            <td class="align-middle"><?= $articles[$i]->getTitle(); ?></td>
            <td class="align-middle"><?= $articles[$i]->getText(); ?></td>
            <td class="align-middle"><a href="<?= URL ?>articles/update/<?= $articles[$i]->getId(); ?>" class="btn btn-info">Modifier</a></td>
            <td class="align-middle">
                <form method="POST" action="<?= URL ?>articles/delete/<?= $articles[$i]->getId(); ?>" onSubmit="return confirm('Voulez-vous vraiment supprimer l'article' ?');">
                    <button class="btn btn-danger" type="submit"">Supprimer</button>
            </form>
            
        </td>
    </tr>
    <?php endfor; ?>
</table>
<a href=" <?= URL ?>articles/create" class="btn btn-success d-block">Ajouter</a>

<?php
$content = ob_get_clean();
$title = "Les articles du blog";
require "template.php";
?>