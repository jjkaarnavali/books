<?php

class Author {

    public $firstName;
    public $lastName;

    public function __construct($firstName, $lastName, $authorGrade, $id) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->authorGrade = $authorGrade;
        $this->id = $id;
    }

}
