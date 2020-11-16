<?php
require_once("functions.php");
require_once("AuthorDao.php");
require_once("Author.php");
require_once 'vendor/tpl.php';
error_reporting(E_ALL ^ E_NOTICE);



$message = "";
$author1 = 0;
$author2 = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST"){

    $input = isset($_POST["title"])
        ? $_POST["title"]
        : "";

    $inputread = isset($_POST["isRead"])
        ? $_POST["isRead"]
        : false;
    $inputgrade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;

    $dto = new AuthorDao();
    $authors = $dto->getAuthorsPosts();
    $author1 = '';
    $author2 = '';
    foreach ($authors as $author){
        if ($author->id === $_POST["author1"]){
            $author1 = $author->firstName . ' ' . $author->lastName;
        }
        if ($author->id === $_POST["author2"]){
            $author2 = $author->firstName . ' ' . $author->lastName;
        }
    }

    $title = isset($_POST["title"])
        ? trim($_POST["title"])
        : "";
    $isRead = isset($_POST["isRead"])
        ? $_POST["isRead"]
        : 0;
    $grade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;


    $book = new Book($title, $grade, $isRead, '', $author1, $author2);

    if (strlen($input) < 3 || strlen($input) > 23){

        $message = "Pealkiri peab sisaldama 3 kuni 23 märki!";

    }else{

        addBook($book, $_POST["author1"], $_POST["author2"]);

        header("Location: index.php?message=success");

    }

}

$dto = new AuthorDao();
$authors = $dto->getAuthorsPosts();

$data = [
        'errors' => $message,
        'authors' => $authors,
        'book' => $book
];
print renderTemplate('tpl/book-add.html', $data);


?>

