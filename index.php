<?php
require_once("functions.php");
$title = $_POST["title"];
$author = $_POST["author"];
$grade = $_POST["grade"];

addBook($title, $author, $grade);
$posts = getBooksPosts();
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
<div id="message-block">Uuendatud!</div>
<div id="message-block">Lisatud!</div>
<table class="contents-list">
    <thead>
    <tr>
        <th>Pealkiri</th>
        <th>Autorid</th>
        <th>Hinne</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($posts as $post): ?>
        <tr>
            <td><a href="edit-book.php?title=<?=$post["title"]?>"><?=$post["title"]?></a></td>
            <td><?=$post["author"]?></td>
            <td><?=$post["grade"]?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>
