<?php
require_once("authorDao.php");
require_once 'vendor/tpl.php';
$message = "";
error_reporting(E_ALL ^ E_NOTICE);

$success = $_GET["message"];
if ($success == "success")
    $message = "Lisatud!";
if ($success == "changed")
    $message = "Muudetud!";
if ($success == "deleted")
    $message = "Kustutatud!";

$dto = new AuthorDao();
$authors = $dto->getAuthorsPosts();

$data = [
    'message' => $message,
    'authors' => $authors,
    'contentPath' => 'author-list.html'
];
print renderTemplate('tpl/main.html', $data);

