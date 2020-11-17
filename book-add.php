<?php
require_once("functions.php");
require_once("AuthorDao.php");
require_once("Author.php");
require_once 'vendor/tpl.php';
error_reporting(E_ALL ^ E_NOTICE);



$message = "";
$author1 = 0;
$author2 = 0;



if ($_SERVER["REQUEST_METHOD"] === "GET"){


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



    $book = new Book($title, $grade, $isRead, '', $author1, $author2);

    if (strlen($title) < 3 || strlen($title) > 23 ){

        $message = "Pealkiri peab sisaldama 3 kuni 23 märki!";

    }else{

        addBook($book, $_GET["author1"], $_GET["author2"]);

        header("Location: index.php?message=success");

    }

}


$dto = new AuthorDao();
$authors = $dto->getAuthorsPosts();

if ($_GET['newBook'] === "new"){
    $message = '';
}

$data = [
        'errors' => $message,
        'authors' => $authors,
        'book' => $book,
        'cmd' => 'save_book_add',
        'contentPath' => 'book-add.html'
];
print renderTemplate('tpl/main.html', $data);

