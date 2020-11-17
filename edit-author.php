<?php
require_once("functions.php");
require_once("AuthorDao.php");
require_once("Author.php");
require_once 'vendor/tpl.php';
error_reporting(E_ALL ^ E_NOTICE);


$messageFirst = "";
$messageSecond = "";
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $originalId = $_POST["original-id"];


    $firstName = isset($_POST["firstName"])
        ? trim($_POST["firstName"])
        : "";
    $lastName = isset($_POST["lastName"])
        ? trim($_POST["lastName"])
        : "";
    $grade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;

    $author = new Author($firstName, $lastName, $grade, $originalId);
    if (strlen($firstName) < 1 || strlen($firstName) > 21){
        if (strlen($lastName) < 1 || strlen($lastName) > 22){

        $messageSecond = "Perenimi peab sisaldama 2 kuni 22 märki!";
        }
        $messageFirst = "Eesnimi peab sisaldama 1 kuni 21 märki!";

    }elseif (strlen($lastName) < 1 || strlen($lastName) > 22){

        $messageSecond = "Perenimi peab sisaldama 2 kuni 22 märki!";

    }else{

        editAuthor($author);
        header("Location: author-list.php?message=changed");
    }

}else{
    $id = $_GET["id"];
    $originalId = $id;
    $author = getAuthorByFirstname($id);
    $originalFirstname = $author->firstName;

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
if ($_GET['firstName'] != null || $_GET['lastName'] != null || $_GET['grade'] != null){
    $firstName = isset($_GET["firstName"])
        ? trim($_GET["firstName"])
        : "";
    $lastName = isset($_GET["lastName"])
        ? $_GET["lastName"]
        : 0;
    $grade = $_GET["grade"];
    $saveId = $_GET["id"];
    $author = new Author($firstName, $lastName, $grade, $saveId);

    if (strlen($firstName) < 1 || strlen($firstName) > 21){
        if (strlen($lastName) < 1 || strlen($lastName) > 22){

            $messageSecond = "Perenimi peab sisaldama 2 kuni 22 märki!";
        }
        $messageFirst = "Eesnimi peab sisaldama 1 kuni 21 märki!";

    }elseif (strlen($lastName) < 1 || strlen($lastName) > 22){

        $messageSecond = "Perenimi peab sisaldama 2 kuni 22 märki!";

    }else{

        editAuthor($author);
        header("Location: author-list.php?message=changed");
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
    $data = [
        'errors' => $errors,
        'author' => $author,
        'contentPath' => 'edit-author.html',
        'cmd' => 'save_edit_author'
    ];
    print renderTemplate('tpl/main.html', $data);
}else{
    $data = [
        'errors' => $errors,
        'author' => $author,
        'contentPath' => 'edit-author.html',
        'cmd' => 'save_edit_author'
    ];
    print renderTemplate('tpl/main.html', $data);
}



