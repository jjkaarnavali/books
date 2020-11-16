<?php
require_once("Book.php");
require_once("Author.php");
require_once("BookDao.php");
require_once("AuthorDao.php");
const username = "jakaar";
const parool = "0771";

const address = "mysql:host=db.mkalmo.xyz;dbname=jakaar";




function getBookByTitle($id){
    $dto = new BookDao();
    $books = $dto->getBooksPosts();
    foreach ($books as $book){
        if ($book->id == $id){
            return $book;
        }
    }
    return null;
}
function getAuthorByFirstname($id){
    $dto = new AuthorDao();
    $authors = $dto->getAuthorsPosts();
    foreach ($authors as $author){
        if ($author->id == $id){
            return $author;
        }
    }
    return null;
}

function addBook(Book $book, $author1id, $author2id){



    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt1 = $connection->prepare(
        'insert into book (title, book_grade, is_read)
    values (:title, :book_grade, :isRead)');
    $stmt1->bindValue(':title', $book->title);
    $stmt1->bindValue(':book_grade', $book->grade);
    $stmt1->bindValue(':isRead', $book->isRead);
    $stmt1->execute();
    $book_id = $connection->lastInsertId();

    if ($author1id == "0" && $author2id == "0"){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', 0);
        $stmt2->execute();
    }elseif ($author1id != "0" && $author2id != "0"){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author1id);
        $stmt2->execute();

        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author2id);
        $stmt2->execute();
    }elseif ($author1id != "0" && $author2id == "0"){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author1id);
        $stmt2->execute();
    }elseif ($author1id == "0" && $author2id != "0"){
        $stmt2 = $connection->prepare(
            'insert into book_author (book_id, author_id)
    values (:book_id, :author_id)');
        $stmt2->bindValue(':book_id', $book_id);
        $stmt2->bindValue(':author_id', $author2id);
        $stmt2->execute();
    }

}
function addAuthor(Author $author){
    $connection = new PDO(address, username, parool,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $addAut1 = $connection->prepare(
        'insert into author (firstName, lastName, author_grade)
    values (:firstName, :lastName, :author_grade)');
    $addAut1->bindValue(':firstName', $author->firstName);
    $addAut1->bindValue(':lastName', $author->lastName);
    $addAut1->bindValue(':author_grade', $author->authorGrade);
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
function editBook($title, $author1id, $author2id, $grade, $originalId, $is_read){
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
function editAuthor($firstName, $lastName, $grade, $originalId){

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
