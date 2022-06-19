<?php include "components/head.inc.php"; ?>

<?php include "components/header.inc.php"; ?>

<?php
$pdo = new PDO("mysql:host=localhost;dbname=blog;charset=utf8","root","");

$recupArticle = $pdo->query("SELECT * FROM articles");
while ($article = $recupArticle->fetch()) {


?>
<div>
    <p>
        <?= $article["title"]; ?>
    </p>
    <p>
        <?= $article["text"]; ?>
    </p>
    <p>
        <?= $article["image"]; ?>
    </p>
</div>

<?php
}
?>
<?php include "components/footer.inc.php"; ?>