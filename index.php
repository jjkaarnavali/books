<?php

require_once("functions.php");
require_once("AuthorDao.php");
require_once("Author.php");
require_once("Book.php");
require_once("BookDao.php");
require_once 'vendor/tpl.php';
require_once 'Request.php';
$request = new Request($_REQUEST);

$cmd = $request->param('cmd')
    ?$request->param('cmd')
    : 'book_list';

if ($cmd === 'book_list'){
    $message = "";

    error_reporting(E_ALL ^ E_NOTICE);

    $success = $_GET["message"];
    if ($success == "success")
        $message = "Lisatud!";
    if ($success == "changed")
        $message = "Muudetud!";
    if ($success == "deleted")
        $message = "Kustutatud!";



    $dto = new BookDao();
    $books = $dto->getBooksPosts();

    $data = [
        'message' => $message,
        'books' => $books,
        'contentPath' => 'book-list.html',
        'cmd' => 'book_list'
    ];
    print renderTemplate('tpl/main.html', $data);


}elseif ($cmd === 'save_book_add'){



    $dto = new AuthorDao();
    $authors = $dto->getAuthorsPosts();
    $author1 = isset($_POST["author1"])
        ? $_POST["author1"]
        : 0;
    $author2 = isset($_POST["author2"])
        ? $_POST["author2"]
        : 0;


    $title = isset($_POST["title"])
        ? trim($_POST["title"])
        : "";
    $isRead = isset($_POST["isRead"])
        ? $_POST["isRead"]
        : 0;
    $grade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;



    header("Location: book-add.php?title=$title&isRead=$isRead&grade=$grade&author1=$author1&author2=$author2");



}elseif ($cmd === 'book_add'){

    $new = 'new';
    header("Location: book-add.php?newBook=$new");



}elseif ($cmd === 'author_list'){
    header("Location: author-list.php");


}elseif ($cmd === 'save_author_add'){

    $firstName = isset($_POST["firstName"])
        ? trim($_POST["firstName"])
        : "";
    $lastName = isset($_POST["lastName"])
        ? trim($_POST["lastName"])
        : "";
    $grade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;

    header("Location: author-add.php?firstName=$firstName&lastName=$lastName&grade=$grade");


}elseif ($cmd === 'author_add'){

    $new = 'new';
    header("Location: author-add.php?newAuthor=$new");



}elseif ($cmd === 'edit_book') {
    $id = $request->param('id')
        ?$request->param('id')
        : 0;


    header("Location: edit-book.php?id=$id");

}elseif ($cmd === 'save_edit_book') {
    $id = $request->param('original-id')
        ?$request->param('original-id')
        : 0;
    $title = isset($_POST["title"])
        ? trim($_POST["title"])
        : "";
    $isRead = isset($_POST["isRead"])
        ? $_POST["isRead"]
        : 0;
    $grade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;
    $author1 = isset($_POST["author1"])
        ? $_POST["author1"]
        : 0;
    $author2 = isset($_POST["author2"])
        ? $_POST["author2"]
        : 0;


    header("Location: edit-book.php?id=$id&title=$title&isRead=$isRead&grade=$grade&author1=$author1&author2=$author2");

}elseif ($cmd === 'edit_author'){
    $id = $request->param('id')
        ?$request->param('id')
        : 'book_list';
    header("Location: edit-author.php?id=$id");

}elseif ($cmd === 'save_edit_author') {

    $firstName = isset($_POST["firstName"])
        ? trim($_POST["firstName"])
        : "";
    $lastName = isset($_POST["lastName"])
        ? trim($_POST["lastName"])
        : "";
    $grade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;
    $id = $request->param('original-id')
        ?$request->param('original-id')
        : 0;



    header("Location: edit-author.php?id=$id&firstName=$firstName&lastName=$lastName&grade=$grade");

}





