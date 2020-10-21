<?php

const BOOKS_DATA_FILE= "books.txt";

const AUTHORS_DATA_FILE= "authors.txt";
const username = "jakaar";
const parool = "0771";

const address = "mysql:host=db.mkalmo.xyz;dbname=jakaar";



function getBooksPosts(){
    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $posts = [];
    $stmt = $connection->prepare(
        'SELECT book.id, book.title, book.book_grade, book_author.book_id, book_author.author_id, author.id, author.firstName, author.lastName
FROM book

         LEFT JOIN book_author
                   ON book.id = book_author.book_id
         LEFT JOIN author
                   ON author.id = book_author.author_id;');

    $stmt->execute();
    $posts[] = ["title"=> "", "author1" => "", "author2" => "", "book_grade" => "",  "is_read" => "", "id" => ""];
    foreach($posts as $post) {
        foreach ($stmt as $row){
            if ($post["title"] == $row['title']){
                $post["author2"] = "{$row['firstName']} {$row['lastName']}";
            }
            $posts[] = ["title" => $row['title'], "author1" => "{$row['firstName']} {$row['lastName']}", "author2" => "",
                "book_grade" => $row['book_grade'],  "is_read" => $row['is_read'], "id" => $row['book.id']];

            print_r($post["title"] != $row['title']);

        }



    }




    /*$lines = file(BOOKS_DATA_FILE);
    $posts = [];
    foreach ($lines as $line){
        list($title, $author, $grade) = explode(",", $line);
        $posts[] = ["title" =>urldecode($title), "author" =>urldecode($author),
            "grade" =>urldecode($grade)];
    }*/
    return $posts;
}
function getAuthorsPosts(){
    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $posts = [];
    $stmt = $connection->prepare(
        'SELECT firstName, lastName, author_grade, id FROM author');
    $stmt->execute();
    foreach($stmt as $row) {
        $posts[] = ["firstName" => $row['firstName'] , "lastName" => $row['lastName'],
            "author_grade" => $row['author_grade'], "id" => $row['id']];
    }
    /*$lines = file(AUTHORS_DATA_FILE);
    $posts = [];
    foreach ($lines as $line){
        list($firstName, $lastName, $grade) = explode(",", $line);
        $posts[] = ["firstName" =>urldecode($firstName), "lastName" =>urldecode($lastName),
            "grade" =>urldecode($grade)];
    }*/
    return $posts;
}
function getBookByTitle($title){
    $posts = getBooksPosts();
    foreach ($posts as $post){
        if ($post["title"] == $title){
            return $post;
        }
    }
    return null;
}
function getAuthorByFirstname($firstName){
    $posts = getAuthorsPosts();
    foreach ($posts as $post){
        if ($post["firstName"] == $firstName){
            return $post;
        }
    }
    return null;
}

function addBook($title, $author1, $author2, $grade, $isRead){

    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt1 = $connection->prepare(
        'insert into book (title, book_grade, is_read)
    values (:title, :book_grade, :isRead)');
    $stmt1->bindValue(':title', $title);
    $stmt1->bindValue(':book_grade', $grade);
    $stmt1->bindValue(':isRead', $isRead);
    $stmt1->execute();
    $book_id = $connection->lastInsertId();

    $stmt2 = $connection->prepare(
        'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
    $stmt2->bindValue(':book_id', $book_id);
    $stmt2->bindValue(':author_id', $author1);
    $stmt2->execute();

    $stmt3 = $connection->prepare(
        'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
    $stmt3->bindValue(':book_id', $book_id);
    $stmt3->bindValue(':author_id', $author2);
    $stmt3->execute();

    /*if ($author1 == "" && $author2 == ""){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id)
    values (:book_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->execute();
    }elseif ($author1 != "" && $author2 != ""){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author1);
        $stmt2->execute();

        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author2);
        $stmt2->execute();
    }elseif ($author1 != "" && $author2 == ""){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author1);
        $stmt2->execute();
    }elseif ($author1 == "" && $author2 != ""){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author2);
        $stmt2->execute();
    }*/



    //$line = urlencode($title) . "," . urlencode($author1) . "," . urlencode($grade) . PHP_EOL;
    //file_put_contents(BOOKS_DATA_FILE, $line, FILE_APPEND);
}
function addAuthor($firstName, $lastName, $grade){
    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $addAut1 = $connection->prepare(
        'insert into author (firstName, lastName, author_grade)
    values (:firstName, :lastName, :author_grade)');
    $addAut1->bindValue(':firstName', $firstName);
    $addAut1->bindValue(':lastName', $lastName);
    $addAut1->bindValue(':author_grade', $grade);
    $addAut1->execute();


    //$line = urlencode(trim($firstName)) . "," . urlencode(trim($lastName)) . "," . urlencode(trim($grade)) . PHP_EOL;
    //file_put_contents(AUTHORS_DATA_FILE, $line, FILE_APPEND);
}
function deleteBookByTitle($title){
    $posts = getBooksPosts();
    $data = "";

    foreach ($posts as $post){
        if ($post["title"] !== $title){
            $data = $data .  urlencode($post["title"]) . "," . urlencode($post["author"])
                . "," . urlencode($post["grade"]) . PHP_EOL;
        }
    }
    file_put_contents(BOOKS_DATA_FILE, $data);
}
function deleteAuthorByFirstname($firstName){
    $posts = getAuthorsPosts();
    $data = "";

    foreach ($posts as $post){
        if ($post["firstName"] !== $firstName){
            $data = $data .  urlencode($post["firstName"]) . "," . urlencode($post["lastName"])
                . "," . urlencode($post["grade"]) . PHP_EOL;
        }
    }
    file_put_contents(AUTHORS_DATA_FILE, $data);

}
function editBook($originalTitle, $title, $author, $grade){
    $posts = getBooksPosts();
    $data = "";
    foreach ($posts as $post){
        if ($post["title"] === $originalTitle){
            $post["title"] = $title;
            $post["author"] = $author;
            $post["grade"] = $grade;
        }
        $data = $data .  urlencode($post["title"]) . "," . urlencode($post["author"])
            . "," . urlencode($post["grade"]) . PHP_EOL;
    }

    file_put_contents(BOOKS_DATA_FILE, $data);

}
function editAuthor($originalFirstName, $firstName, $lastName, $grade){
    $posts = getAuthorsPosts();
    $data = "";
    foreach ($posts as $post){
        if ($post["firstName"] === $originalFirstName){
            $post["firstName"] = $firstName;
            $post["lastName"] = $lastName;
            $post["grade"] = $grade;
        }

        $data = $data .  urlencode($post["firstName"]) . "," . urlencode($post["lastName"])
            . "," . urlencode($post["grade"]) . PHP_EOL;

    }

    file_put_contents(AUTHORS_DATA_FILE, $data);

}
