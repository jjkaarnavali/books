<?php

class Book {

    public $title;
    public $grade;
    public $isRead;
    public $authors = [];

    public function __construct($title, $grade, $isRead, $id, $author1, $author2) {
        $this->title = $title;
        $this->grade = $grade;
        $this->isRead = $isRead;
        $this->author1 = $author1;
        $this->author2 = $author2;
        $this->id = $id;
    }

    public function addAuthor($author) {
        $this->authors[] = $author;
    }

}
