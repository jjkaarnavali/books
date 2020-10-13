<?php
require_once("functions.php");

$post = [];
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $originalFirstname = $_POST["original-firstname"];
    $firstname = $_POST["firstname"];
    $secondname = $_POST["secondname"];
    $grade = $_POST["grade"];
    editAuthor($originalFirstname, $firstname, $secondname, $grade);
    header("Location: author-list.php");
}else{
    $firstname = $_GET["firstname"];
    $post = getAuthorByFirstname($firstname);
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
<form class="contents-add" action="edit-author.php" method="post">
    <label for="eesnimi">Eesnimi: </label>
    <input type="text" id="eesnimi" name="firstname" value="<?= $post["firstname"]?>"><br>
    <label for="perenimi">Perekonnanimi: </label>
    <input type="text" id="perenimi" name="secondname" value="<?= $post["secondname"]?>"><br>
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
    <input type="hidden" name="original-firstname" value="<?= $post["firstname"]?>">
    <input type="submit" id="submitButton" name="submitButton" value="Salvesta">
</form>
<form action="delete-author.php" method="post">
    <input type="hidden" name="post-to-delete" value="<?= $post["firstname"]?>"/>
    <input type="submit" value="Kustuta"/>
</form>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>
