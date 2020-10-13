<?php
require_once("functions.php");

$post = [];
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $originalTitle = $_POST["original-title"];
    $title = $_POST["title"];
    $author = $_POST["author"];
    $grade = $_POST["grade"];
    editBook($originalTitle, $title, $author, $grade);
    header("Location: index.php");
}else{
    $title = $_GET["title"];
    $post = getBookByTitle($title);
}

?>


<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <title>Harjutustund 1</title>
    <link href="books-style.css" rel="stylesheet">
</head>
<body>
<nav class="header-row">
    <a id="book-list-link" href="index.php">Raamatud</a>
    <span> | </span>
    <a id="book-form-link" href="book-add.php">Lisa raamat</a>
    <span> | </span>
    <a id="author-list-link" href="author-list.php">Autorid</a>
    <span> | </span>
    <a id="author-form-link" href="author-add.php">Lisa autor</a>
</nav>
<form class="contents-add" action="edit-book.php" method="post">
    <label for="title">Pealkiri: </label>
    <input type="text" id="title" name="title" value="<?= $post["title"]?>"><br>

    <label for="A1">Autor 1: </label>
    <select id="A1">
        <option></option>
        <option>Kivirähk</option>
        <option>Runnel</option>
        <option>Tolkien</option>
    </select><br>
    <label for="A2">Autor 2: </label>
    <select id="A2">
        <option></option>
        <option>Kivirähk</option>
        <option>Runnel</option>
        <option>Tolkien</option>
    </select><br>
    <label for="isRead">Loetud: </label>
    <input type="checkbox" id="isRead" name="isRead"> <br>
    <label for="hinne1">Hinne: </label>
    <input type="radio" id="hinne1" name="grade" value="1"
        <?php
    if ($post["grade"] == 1): ?>
        checked="checked"
    <?php endif; ?>
    >1
    <input type="radio" id="hinne2" name="grade" value="2"
        <?php
    if ($post["grade"] == 2): ?>
        checked="checked"
    <?php endif; ?>
    >2
    <input type="radio" id="hinne3" name="grade" value="3"
        <?php
        if ($post["grade"] == 3): ?>
            checked="checked"
        <?php endif; ?>
    >3
    <input type="radio" id="hinne4" name="grade" value="4"
        <?php
        if ($post["grade"] == 4): ?>
            checked="checked"
        <?php endif; ?>
    >4
    <input type="radio" id="hinne5" name="grade" value="5"
        <?php
        if ($post["grade"] == 5): ?>
            checked="checked"
        <?php endif; ?>
    >5 <br>
    <input type="hidden" name="original-title" value="<?= $post["title"]?>">
    <input type="submit" id="submitButton" name="submitButton" value="Salvesta"/>

</form>
<form action="delete-book.php" method="post">
    <input type="hidden" name="post-to-delete" value="<?= $post["title"]?>"/>
    <input type="submit" value="Kustuta"/>
</form>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>

