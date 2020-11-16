<?php
require_once("functions.php");
require_once("AuthorDao.php");
require_once("Author.php");
require_once 'vendor/tpl.php';
error_reporting(E_ALL ^ E_NOTICE);


$messageFirst = "";
$messageSecond = "";

if ($_SERVER["REQUEST_METHOD"] === "POST"){



    $firstName = isset($_POST["firstName"])
        ? trim($_POST["firstName"])
        : "";
    $lastName = isset($_POST["lastName"])
        ? trim($_POST["lastName"])
        : "";
    $grade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;

    $author = new Author($firstName, $lastName, $grade, '');

    if (strlen($firstName) < 1 || strlen($firstName) > 21){

        $messageFirst = "Eesnimi peab sisaldama 1 kuni 21 märki!";

    }
    if (strlen($lastName) < 2 || strlen($lastName) > 22){

        $messageSecond = "Perenimi peab sisaldama 2 kuni 22 märki!";

    }
    if (strlen($firstName) >= 1 && strlen($firstName) <= 21 && strlen($lastName) >= 2 && strlen($lastName) <= 22){


        addAuthor($author);

        header("Location: author-list.php?message=success");

    }

}
$errors = [$messageFirst, $messageSecond];
if ($messageFirst == "" && $messageSecond == ""){
    $errors = [];
}
$data = [
    'errors' => $errors,
    'author' => $author,
];
print renderTemplate('tpl/author-add.html', $data);


