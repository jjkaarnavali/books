<?php
require_once("functions.php");
error_reporting(E_ALL ^ E_NOTICE);

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $originalTitle = $_POST["original-title"];
    $input = isset($_POST["title"])
        ? $_POST["title"]
        : "";
    $inputread = isset($_POST["isRead"])
        ? $_POST["isRead"]
        : 0;
    $inputgrade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;
    if (strlen($input) < 3 || strlen($input) > 23){


        $message = "Pealkiri peab sisaldama 3 kuni 23 märki!";

    }else{
        $originalTitle = $_POST["original-title"];
        $originalId = $_POST["original-id"];
        $title = trim($_POST["title"]);
        $author1id = $_POST["author1"];
        $author2id = $_POST["author2"];
        $grade = $_POST["grade"];
        $is_read = $_POST["isRead"];
        editBook($originalTitle, $title, $author1id, $author2id, $grade, $originalId, $is_read);
        header("Location: index.php?message=changed");
    }

}else{
    $id = $_GET["id"];
    $post = getBookByTitle($id);
    $originalId = $post['id'];
    $originalTitle = $post['title'];
    list($a1first, $a1last) = explode(" ", $post['author1']);
    list($a2first, $a2last) = explode(" ", $post['author2']);

}
$authorsPosts = getAuthorsPosts();

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
<form class="contents-add" action="edit-book.php" method="post">
    <label for="title">Pealkiri: </label>
    <?php if($message !== ""): ?>
        <input type="text" id="title" name="title" value="<?= $input?>"><br>
    <?php else: ?>
        <input type="text" id="title" name="title" value="<?= $post["title"]?>"><br>
    <?php endif; ?>


    <label for="author1">Autor 1: </label>
    <select id="author1" name="author1">
        <option value="0"></option>
        <?php
        foreach ($authorsPosts as $apost):?>
            <option value="<?=$apost["id"]?>" <?php if ($a1first == $apost["firstName"] && $a1last == $apost["lastName"]): ?>
               selected="selected"
               <?php endif; ?>
            ><?=$apost["firstName"]?> <?=$apost["lastName"]?></option>
        <?php endforeach; ?>
    </select><br>
    <label for="author2">Autor 2: </label>
    <select id="author2" name="author2">
        <option value="0"></option>
        <?php
        foreach ($authorsPosts as $apost):?>
            <option value="<?=$apost["id"]?>" <?php if ($a2first == $apost["firstName"] && $a2last == $apost["lastName"]): ?>
                selected="selected"
            <?php endif; ?>
            ><?=$apost["firstName"]?> <?=$apost["lastName"]?></option>
        <?php endforeach; ?>
    </select><br>
    <label for="isRead">Loetud: </label>
    <input type="checkbox" id="isRead" name="isRead" value="1"
        <?php
        if ($post["is_read"] == 1): ?>
            checked="checked" value="1"
        <?php
        elseif ($inputread == true): ?>
            checked="checked" value="1"
        <?php endif; ?>
    > <br>
    <label for="hinne1">Hinne: </label>
    <input type="radio" id="hinne1" name="grade" value="1"
        <?php
    if ($post["book_grade"] == 1): ?>
        checked="checked"
    <?php
    elseif ($inputgrade == 1): ?>
            checked="checked"
    <?php endif; ?>
    >1
    <input type="radio" id="hinne2" name="grade" value="2"
        <?php
        if ($post["book_grade"] == 2): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 2): ?>
            checked="checked"
        <?php endif; ?>
    >2
    <input type="radio" id="hinne3" name="grade" value="3"
        <?php
        if ($post["book_grade"] == 3): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 3): ?>
            checked="checked"
        <?php endif; ?>
    >3
    <input type="radio" id="hinne4" name="grade" value="4"
        <?php
        if ($post["book_grade"] == 4): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 4): ?>
            checked="checked"
        <?php endif; ?>
    >4
    <input type="radio" id="hinne5" name="grade" value="5"
        <?php
        if ($post["book_grade"] == 5): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 5): ?>
            checked="checked"
        <?php endif; ?>
    >5 <br>
    <?php if($message !== ""): ?>
        <input type="hidden" name="original-title" value="<?= $originalTitle?>">

    <?php else: ?>
        <input type="hidden" name="original-title" value="<?= $post["title"]?>">

    <?php endif; ?>
    <input type="hidden" name="original-id" value="<?= $originalId?>">

    <input type="submit" id="submitButton" name="submitButton" value="Salvesta"/>

</form>
<form action="delete-book.php" method="post">

        <input type="hidden" name="post-to-delete" value="<?= $originalId?>"/>

    <input type="submit" name="deleteButton" value="Kustuta"/>
</form>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>
