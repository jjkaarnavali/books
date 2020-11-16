<?php
require_once 'Author.php';

class AuthorDao
{
    const username = "jakaar";
    const parool = "0771";

    const address = "mysql:host=db.mkalmo.xyz;dbname=jakaar";

    function getAuthorsPosts(){
        $connection = new PDO("mysql:host=db.mkalmo.xyz;dbname=jakaar", "jakaar", "0771",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $authors = [];
        $stmt = $connection->prepare(
            'SELECT firstName, lastName, author_grade, id FROM author');
        $stmt->execute();
        foreach($stmt as $row) {
            $authors[] = new Author($row['firstName'], $row['lastName'], $row['author_grade'], $row['id']);

        }

        return $authors;
    }
}