<?php
class Article{
    private $id;
    private $title;
    private $text;
    private $image;

    public function __construct($id,$title,$text,$image){
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->image = $image;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }


    public function getTitle(){
        return $this->title;
    }
    public function setTitle($title){
        $this->title = $title;
    }

    
    public function getText(){
        return $this->text;
    }
    public function setText($text){
        $this->text = $text;
    }


    public function getImage(){
        return $this->image;
    }
    public function setImage($image){
        $this->image = $image;
    }
}