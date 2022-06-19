<?php
session_start();
// require "login/login.php";
// $pdo = new PDO("mysql:host=localhost;dbname=blog;charset=utf8", "root", "");
// if (!isset($_SESSION['password'])) {
//     header("Location: connexion.php");
// }
    
// on remplace index.php
// on teste si on est sur un serveur https ou http avec une fonction ternaire
define("URL", str_replace("router.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/ArticlesController.controller.php";
$articlesController = new ArticlesController;
try {
    if (empty($_GET['page'])) {
        require "views/accueil.view.php";
    } else {
        // on va décomposer l'url
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
        // $url[0] pour tester le 1er élément dans l'url
        switch ($url[0]) {
            case "accueil":
                require "views/accueil.view.php";
                break;
            case "articles":
                // on teste si on a pas un 2e élément dans l'url
                if (empty($url[1])) {
                    $articlesController->readArticles();
                } else if ($url[1] === "read") {
                    $articlesController->readArticle($url[2]);
                } else if ($url[1] === "create") {
                    $articlesController->createArticle();
                } else if ($url[1] === "update") {
                    $articlesController->updateArticle($url[2]);
                } else if ($url[1] === "delete") {
                    $articlesController->deleteArticle($url[2]);
                } else if($url[1] === "validate") {
                    $articlesController->createArticleValidate();
                }else if($url[1] === "updateValidation") {
                    $articlesController->updateArticleValidation();
                }else {
                    throw new Exception("La page n'existe pas");
                }
                break;
                default : throw new Exception("La page n'existe pas");
            
        }
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    require "views/error.view.php";
}
