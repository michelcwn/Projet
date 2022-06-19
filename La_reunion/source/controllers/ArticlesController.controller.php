<?php
require_once "models/ArticlesManager.class.php";

class ArticlesController{
    private $articlesManager;

    public function __construct(){
        $this->articlesManager = new ArticlesManager;
        $this->articlesManager->loadingArticles();
    }

    public function readArticles(){
        $articles = $this->articlesManager->getArticles();
        require "views/articles.view.php";
       
    }

    public function readArticle($id){
        $article = $this->articlesManager->getArticleById($id);
        require "views/readArticles.view.php";
        
    }

    public function createArticle(){
        // on va juste afficher un formulaire
        require "views/createArticle.view.php";
    }

    public function createArticleValidate() {
        // on récupère les infos de l'image
        $file = $_FILES['image'];
        // on rajoute ici le repertoire dans lequel on positionne les images qu'on upload
        $directory = "public/images/";
        $imageNameAdded = $this->addImage($file,$directory);
        // on utilise le manager (qui est accessible en tant qu'attribut de notre objet) pour rajouter l'image en base de données
        $this->articlesManager->createArticleDb($_POST['title'],$_POST['text'], $imageNameAdded);
        
        $_SESSION['alert'] = [
            // type servira à bootstrap
            "type" => "success",
            "message" => "L'ajout de l'article est validé"
        ];

        header('Location: '. URL . "articles");
    }

    // la fonction contient en paramètres deux informations : le fichier et le dossier dans lequel on veut mettre l'image
    private function addImage($file, $dir){
        // la fonction va vérifier si nous avons renseignés une image dans le formulaire
        // si ce n'est pas le cas, nous avons une erreur
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");
    
        // la fonction va vérifier si le répertoire public/images/ existe ou non
        // s'il n'existe pas, il va être crée
        // 0777, ie accessible par n'importe qui 
        // https://fr.wikipedia.org/wiki/Chmod
        if(!file_exists($dir)) mkdir($dir,0777);
    
        // on récupère l'extension du fichier (.jpg, .png, etc.)
        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        // on génère un chiffre aléatoire pour rajouter un nom de fichier aléatoire dans l'image qui sera rajouter dans le dossier
        // ce qui évitera d'avoir des doublons
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name'];

         // vérifie si le fichier est une image 
        if(!getimagesize($file["tmp_name"]))     
            throw new Exception("Le fichier n'est pas une image");
        // vérifie les extensions
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        // vérifie si le fichier n'existe pas déjà
        if(file_exists($target_file))
            throw new Exception("Le fichier existe déjà");
        // vérifie la taille pour éviter des fichiers trop gros
        if($file['size'] > 5000000)
            throw new Exception("Le fichier est trop gros");
        // move_uploaded_file permet de rajouter notre image dans le dossier
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        // si move_uploaded_file a fonctionné, on renvoie le nom de l'image qui a été rajouté au dossier
        else return ($random."_".$file['name']);
    }

    public function updateArticle($id){
        // on récupère toutes les infos de l'article
        $article = $this->articlesManager->getArticleById($id);
        require "views/updateArticle.view.php";
    }

    // pas de paramètres dans la fonction, car déjà fait avec la méthode POST
    public function updateArticleValidation(){
        // on récupère l'image de l'article qu'on veut modifier
        $currentImage = $this->articlesManager->getArticleById($_POST['idArticle'])->getImage();
        // on vérifie si l'utilisateur a renseigné un fichier pour changer l'image
        $file = $_FILES['image'];
        // on vérifie si l'utilisateur a renseigné une nouvelle image, ie l'image > 0
        if($file['size'] > 0){
            unlink("public/images/".$currentImage);
            // on rajoute l'image de l'article dans le répertoire
            $directory = "public/images/";
            $ImageNameToAdd = $this->addImage($file,$directory);
        } else {
            // si l'utilisateur n'a pas renseigné d'infos dans le formulaire
            // je dis que l'image ajouté est la même que l'ancienne
            $ImageNameToAdd = $currentImage;
        }
        // modification dans la bdd
        $this->articlesManager->updateArticleDb($_POST['idArticle'],$_POST['title'],$_POST['text'],$ImageNameToAdd);

        $_SESSION['alert'] = [
            // type servira à bootstrap
            "type" => "success",
            "message" => "La modifcation de l'article est validée"
        ];

        header('Location: '. URL . "articles");

    }

    public function deleteArticle($id){
        // on récupère l'image du livre qu'on veut supprimer
        $imageName = $this->articlesManager->getArticleById($id)->getImage();
        // on supprime l'image dans le répertoire concerné
        unlink("public/images/".$imageName);
        // on supprime l'image dans la bdd
        $this->articlesManager->deleteArticleDb($id);

        $_SESSION['alert'] = [
            // type servira à bootstrap
            "type" => "success",
            "message" => "La suppression de l'article est validée"
        ];

        header('Location: '. URL . "articles");
    }
}