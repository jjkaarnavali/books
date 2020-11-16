<?php
require_once("Book.php");

class BookDao {

    const username = "jakaar";
    const parool = "0771";

    const address = "mysql:host=db.mkalmo.xyz;dbname=jakaar";

    public function getBooksPosts(){
        $connection = new PDO("mysql:host=db.mkalmo.xyz;dbname=jakaar", "jakaar", "0771",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $stmt = $connection->prepare(
            'SELECT book.id, book.title, book.book_grade, book.is_read, book_author.book_id, book_author.author_id, author.id, author.firstName, author.lastName
FROM book_author

         LEFT JOIN book
                   ON book.id = book_author.book_id
         LEFT JOIN author
                   ON author.id = book_author.author_id;');

        $stmt->execute();
        $books = [];
        $i = 0;

        foreach($stmt as $row) {

            if ($row['book_id'] === $books[$i - 1]->id){


                $books[$i - 1]->author2 .= "{$row['firstName']} {$row['lastName']}";

            }else {
                $books[] = new Book($row['title'], $row['book_grade'], $row['is_read'],
                    $row['book_id'], "{$row['firstName']} {$row['lastName']}", '');
                $i += 1;

            }
        }

        return $books;
    }

}