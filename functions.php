<?php

const username = "jakaar";
const parool = "0771";

const address = "mysql:host=db.mkalmo.xyz;dbname=jakaar";



function getBooksPosts(){
    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $stmt = $connection->prepare(
        'SELECT book.id, book.title, book.book_grade, book.is_read, book_author.book_id, book_author.author_id, author.id, author.firstName, author.lastName
FROM book_author

         LEFT JOIN book
                   ON book.id = book_author.book_id
         LEFT JOIN author
                   ON author.id = book_author.author_id;');

    $stmt->execute();
    $posts[] = [];
    $i = 0;

    foreach($stmt as $row) {
        if ($row['book_id'] === $posts[$i]['id']){

            $posts[$i]['author2'] .= "{$row['firstName']} {$row['lastName']}";

        }else {
            $posts[] = ["title" => $row['title'], "author1" => "{$row['firstName']} {$row['lastName']}",
                "author2" => "",
                "book_grade" => $row['book_grade'], "is_read" => $row['is_read'], "id" => $row['book_id']];
            $i += 1;

        }
    }

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

    return $posts;
}
function getBookByTitle($id){
    $posts = getBooksPosts();
    foreach ($posts as $post){
        if ($post["id"] == $id){
            return $post;
        }
    }
    return null;
}
function getAuthorByFirstname($id){
    $posts = getAuthorsPosts();
    foreach ($posts as $post){
        if ($post["id"] == $id){
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

    if ($author1 == "0" && $author2 == "0"){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', 0);
        $stmt2->execute();
    }elseif ($author1 != "0" && $author2 != "0"){
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
    }elseif ($author1 != "0" && $author2 == "0"){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author1);
        $stmt2->execute();
    }elseif ($author1 == "0" && $author2 != "0"){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author2);
        $stmt2->execute();
    }

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

}
function deleteBookByTitle($id){
    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $delBook1 = $connection->prepare(
        'DELETE FROM book
WHERE id = :bookId');

    $delBook1->bindValue(':bookId', $id);
    $delBook1->execute();

    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $delBook2 = $connection->prepare(
        'DELETE FROM book_author
WHERE book_id = :bookId');

    $delBook2->bindValue(':bookId', $id);
    $delBook2->execute();

}
function deleteAuthorByFirstname($id){

    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $delAut1 = $connection->prepare(
        'DELETE FROM author
WHERE id = :authorId');

    $delAut1->bindValue(':authorId', $id);
    $delAut1->execute();

    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $delAut2 = $connection->prepare(
        'UPDATE book_author
        SET author_id = 0
        WHERE author_id = :authorId');

    $delAut2->bindValue(':authorId', $id);
    $delAut2->execute();

}
function editBook($originalTitle, $title, $author1id, $author2id, $grade, $originalId, $is_read){
    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $edBook1 = $connection->prepare(
        'UPDATE book 
        set title = :title, book_grade = :grade, is_read = :is_read
        WHERE id = :originalId
        ');
    $edBook1->bindValue(':title', $title);
    $edBook1->bindValue(':grade', $grade);
    $edBook1->bindValue(':is_read', $is_read);
    $edBook1->bindValue(':originalId', $originalId);
    $edBook1->execute();

    $selectAuthorBookId = $connection->prepare(
        'SELECT id, book_id, author_id FROM book_author WHERE book_id = :book_id');
    $selectAuthorBookId->bindValue(':book_id', $originalId);
    $selectAuthorBookId->execute();

    $i = 0;
    foreach ($selectAuthorBookId as $row){

       if ($author1id != "0" && $author2id == "0"){
            $stmt2 = $connection->prepare(
                'UPDATE book_author 
            set author_id = :author_id
            where id = :Id
        ');
            $stmt2->bindValue(':author_id', $author1id);
            $stmt2->bindValue(':Id', $row['id']);
            $stmt2->execute();
        }elseif ($author1id == "0" && $author2id != "0"){
            $stmt2 = $connection->prepare(
                'UPDATE book_author 
            set author_id = :author_id
            where id = :Id
        ');
            $stmt2->bindValue(':author_id', $author2id);
            $stmt2->bindValue(':Id', $row['id']);
            $stmt2->execute();
        }elseif ($author1id == "0" && $author2id == "0"){
            $stmt2 = $connection->prepare(
                'UPDATE book_author 
            set author_id = :author_id
            where id = :Id
        ');
            $stmt2->bindValue(':author_id', 0);
            $stmt2->bindValue(':Id', $row['id']);
            $stmt2->execute();
        }elseif ($author1id != "0" && $author2id != "0" && $i == 0){
            $stmt2 = $connection->prepare(
                'UPDATE book_author 
            set author_id = :author_id
            where id = :Id
        ');
            $stmt2->bindValue(':author_id', $author1id);
            $stmt2->bindValue(':Id', $row['id']);
            $stmt2->execute();
            $i++;

        }elseif ($author1id != "0" && $author2id != "0" && $i == 1){
           $stmt2 = $connection->prepare(
               'UPDATE book_author 
            set author_id = :author_id
            where id = :Id
        ');
           $stmt2->bindValue(':author_id', $author2id);
           $stmt2->bindValue(':Id', $row['id']);
           $stmt2->execute();


       }

    }

}
function editAuthor($originalFirstName, $firstName, $lastName, $grade, $originalId){

    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $edAut1 = $connection->prepare(
        'UPDATE author 
        set firstName = :firstName, lastName = :lastName, author_grade = :grade
        WHERE id = :originalId
        ');
    $edAut1->bindValue(':firstName', $firstName);
    $edAut1->bindValue(':lastName', $lastName);
    $edAut1->bindValue(':grade', $grade);
    $edAut1->bindValue(':originalId', $originalId);
    $edAut1->execute();

}
