<?php
require_once("functions.php");
require_once("AuthorDao.php");
require_once("Author.php");
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

    if (strlen($input) < 3 || strlen($input) > 23){

        $message = "Pealkiri peab sisaldama 3 kuni 23 märki!";

    }else{
        $dto = new AuthorDao();
        $authors = $dto->getAuthorsPosts();
        $author1 = '';
        $author2 = '';
        foreach ($authors as $author){
            if ($author->id === $_POST["author1"]){
                $author1 = $author->firstName + $author->lastName;
            }
            if ($author->id === $_POST["author2"]){
                $author2 = $author->firstName + $author->lastName;
            }
        }

        $title = trim($_POST["title"]);

        $grade = $_POST["grade"];
        $isRead = $_POST["isRead"];

        $book = new Book(trim($_POST["title"]), $_POST["grade"], $_POST["isRead"], '', $author1, $author2);


        addBook($book, $_POST["author1"], $_POST["author2"]);

        header("Location: index.php?message=success");

    }

}

$dto = new AuthorDao();
$authors = $dto->getAuthorsPosts();


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
<?php if($message !== ""): ?>
    <div id="error-block"><?= $message?><br></div>
<?php endif; ?>
<form class="contents-add" action="book-add.php" method="post">
    <label for="title">Pealkiri: </label>
    <?php if($message !== ""): ?>
        <input type="text" id="title" name="title" value="<?= $input?>"><br>
    <?php else: ?>
        <input type="text" id="title" name="title" ><br>
    <?php endif; ?>

    <label for="author1">Autor 1: </label>
    <select id="author1" name="author1">
        <option value="0"></option>
        <?php
        foreach ($authors as $author):?>
            <option value="<?=$author->id?>"><?=$author->firstName?> <?=$author->lastName?></option>
        <?php endforeach; ?>
    </select><br>
    <label for="author2">Autor 2: </label>
    <select id="author2" name="author2">
        <option value="0"></option>
        <?php
        foreach ($authors as $author):?>
            <option value="<?=$author->id?>"><?=$author->firstName?> <?=$author->lastName?></option>
        <?php endforeach; ?>
    </select><br>
    <label for="isRead">Loetud: </label>
    <input type="checkbox" id="isRead" value="1" name="isRead"
        <?php
        if ($inputread == true): ?>
            checked="checked"
        <?php endif; ?>
    > <br>
    <?php print_r($_POST["isRead"]) ?>
    <label for="hinne1">Hinne: </label>
    <input type="radio" id="hinne1" name="grade" value="1"
        <?php
        if ($inputgrade == 1): ?>
            checked="checked"
        <?php endif; ?>
    >1
    <input type="radio" id="hinne2" name="grade" value="2"
        <?php
        if ($inputgrade == 2): ?>
            checked="checked"
        <?php endif; ?>
    >2
    <input type="radio" id="hinne3" name="grade" value="3"
        <?php
        if ($inputgrade == 3): ?>
            checked="checked"
        <?php endif; ?>
    >3
    <input type="radio" id="hinne4" name="grade" value="4"
        <?php
        if ($inputgrade == 4): ?>
            checked="checked"
        <?php endif; ?>
    >4
    <input type="radio" id="hinne5" name="grade" value="5"
        <?php
        if ($inputgrade == 5): ?>
            checked="checked"
        <?php endif; ?>
    >5 <br>
    <input type="submit" id="submitButton" name="submitButton" value="Lisa">


</form>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>
