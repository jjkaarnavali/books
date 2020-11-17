<?php
require_once("functions.php");
require_once("AuthorDao.php");
require_once("Author.php");
require_once 'vendor/tpl.php';
error_reporting(E_ALL ^ E_NOTICE);


$messageFirst = "";
$messageSecond = "";

if ($_SERVER["REQUEST_METHOD"] === "GET"){



    $firstName = isset($_GET["firstName"])
        ? trim($_GET["firstName"])
        : "";
    $lastName = isset($_GET["lastName"])
        ? trim($_GET["lastName"])
        : "";
    $grade = isset($_GET["grade"])
        ? $_GET["grade"]
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
if ($messageFirst == "" && $messageSecond == ""){
    $errors = [];
}elseif ($messageFirst != "" && $messageSecond == ""){
    $errors = [$messageFirst];
}elseif ($messageFirst == "" && $messageSecond != ""){
    $errors = [$messageSecond];
}else{
    $errors = [$messageFirst, $messageSecond];
}
if ($_GET['newAuthor'] === 'new'){
    $errors = [];
}

$data = [
    'errors' => $errors,
    'author' => $author,
    'contentPath' => 'author-add.html',
    'cmd' => 'save_author_add'
];
print renderTemplate('tpl/main.html', $data);


