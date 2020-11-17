<?php
require_once("functions.php");
require_once("AuthorDao.php");
require_once("Author.php");
require_once("Book.php");
require_once("BookDao.php");
require_once 'vendor/tpl.php';
error_reporting(E_ALL ^ E_NOTICE);

$message = "";
$originalId = $_POST["original-id"];
$title = trim($_POST["title"]);
$author1 = $_POST["author1"];
$author2 = $_POST["author2"];
$grade = $_POST["grade"];
$is_read = $_POST["isRead"];


if ($_SERVER["REQUEST_METHOD"] === "POST"){

    $dto = new AuthorDao();
    $authors = $dto->getAuthorsPosts();
    $author1 = '';
    $author2 = '';
    foreach ($authors as $author){
        if ($author->id === $_POST["author1"]){
            $author1 = $author->firstName . ' ' . $author->lastName;
        }
        if ($author->id === $_GET["author2"]){
            $author2 = $author->firstName . ' ' . $author->lastName;
        }
    }
    $originalId = $_POST["id"];
    $title = trim($_POST["title"]);
    $author1 = '';
    $author2 = '';
    $grade = $_POST["grade"];
    $is_read = $_POST["isRead"];
    foreach ($authors as $author){
        if ($author->id === $_POST["author1"]){
            $author1 = $author->firstName . ' ' . $author->lastName;
        }
        if ($author->id === $_POST["author2"]){
            $author2 = $author->firstName . ' ' . $author->lastName;
        }
    }

    $book = new Book($title, $grade, $is_read, $originalId, $author1, $author2);



    if (strlen($title) < 3 || strlen($title) > 23){


        $message = "Pealkiri peab sisaldama 3 kuni 23 märki!";

    }else{
        print_r($book);
        editBook($book, $_POST["author1"], $_POST["author2"]);
        header("Location: index.php?message=changed");
    }

}

$id = $_GET["id"];
$book = getBookByTitle($id);


if ($_GET["title"] != null || $_GET["isRead"] != null || $_GET["grade"] != null || $_GET["author1"] != 0 || $_GET["author2"] != 0){
    $dto = new AuthorDao();
    $authors = $dto->getAuthorsPosts();
    $author1 = '';
    $author2 = '';
    foreach ($authors as $author){
        if ($author->id === $_GET["author1"]){
            $author1 = $author->firstName . ' ' . $author->lastName;
        }
        if ($author->id === $_GET["author2"]){
            $author2 = $author->firstName . ' ' . $author->lastName;
        }
    }

    $title = isset($_GET["title"])
        ? trim($_GET["title"])
        : "";
    $isRead = isset($_GET["isRead"])
        ? $_GET["isRead"]
        : 0;
    $grade = $_GET["grade"];
    $saveId = $_GET["id"];
    $book = new Book($title, $grade, $isRead, $saveId, $author1, $author2);


    if (strlen($title) < 3 || strlen($title) > 23){


        $message = "Pealkiri peab sisaldama 3 kuni 23 märki!";
        $dto = new AuthorDao();
        $authors = $dto->getAuthorsPosts();
        $data = [
            'errors' => $message,
            'authors' => $authors,
            'book' => $book,
            'contentPath' => 'edit-book.html',
            'cmd' => 'save_edit_book'
        ];
        print renderTemplate('tpl/main.html', $data);


    }else{
        print_r($book);
        editBook($book, $_GET["author1"], $_GET["author2"]);
        header("Location: index.php?message=changed");
    }
}else{
    $dto = new AuthorDao();
    $authors = $dto->getAuthorsPosts();
    if ($_GET['newBook'] === 'new'){

    }

    $data = [
        'errors' => $message,
        'authors' => $authors,
        'book' => $book,
        'contentPath' => 'edit-book.html',
        'cmd' => 'save_edit_book'
    ];
    print renderTemplate('tpl/main.html', $data);
}


