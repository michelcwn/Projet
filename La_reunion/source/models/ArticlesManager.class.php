<?php
require_once "Model.class.php";
require_once "Article.class.php";

class ArticlesManager extends Model{
    private $articles;

    public function addArticle($article){
        $this->articles[] = $article;
    }

    public function getArticles(){
        return $this->articles;
    }

    public function loadingArticles(){
        $query = $this->getBdd()->prepare("SELECT * FROM articles");
        $query->execute();
        $articles = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();

        foreach($articles as $article){
            $a = new Article($article['id'],$article['title'],$article['text'],$article['image']);
            $this->addArticle($a);
        }
    }

    public function getArticleById($id){
        for($i=0; $i < count($this->articles);$i++){
            if($this->articles[$i]->getId() === $id){
                return $this->articles[$i];
            }
        }
        // cas où l'article n'a pas été trouvé
        throw new Exception("L'article n'existe pas");
    }

    public function createArticleDb($title,$text,$image){
        $query = "INSERT INTO articles (title, text, image) values (:title, :text, :image)";
        $stmt = $this->getBdd()->prepare($query);
        // bindvalue sécurise les infos transmises à la requête
        $stmt->bindValue(":title",$title);
        $stmt->bindValue(":text",$text);
        $stmt->bindValue(":image",$image);
        $result = $stmt->execute();
        $stmt->closeCursor();

        // je veux rajouter l'article qui a été transféré dans la base de données
        // est-ce que le résultat à retourné qqc ?
        if($result > 0){
            // si oui, je rajoute un article dans le tableau
            // lastInsertId permet de retourner la dernière info insérer dans la bdd
            $article = new Article($this->getBdd()->lastInsertId(),$title,$text,$image);
            $this->addArticle($article);
        }        
    }

    public function deleteArticleDb($id) {
        $query ="DELETE from articles where id = :idArticle";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":idArticle",$id,PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();
        // on teste si la requête a bien fonctionné
        if($result > 0) {
            $article = $this->getArticleById($id);
            // unset prend une variable en paramètre
            unset($article);
        }
    }

    public function updateArticleDb($id,$title,$text,$image){
        $query = "UPDATE articles SET title = :title, text = :text, image = :image where id = :id";
        $stmt = $this->getBdd()->prepare($query);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->bindValue(":title",$title,PDO::PARAM_STR);
        $stmt->bindValue(":text",$text,PDO::PARAM_STR);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result > 0){
            $this->getArticleById($id)->setTitle($title);
            $this->getArticleById($id)->setTitle($text);
            $this->getArticleById($id)->setTitle($image);
        }
    }
}