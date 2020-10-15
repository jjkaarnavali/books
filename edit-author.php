<?php
require_once("functions.php");


$messageFirst = "";
$messageSecond = "";
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $originalFirstName = $_POST["original-firstname"];
    $input = isset($_POST["firstName"])
        ? $_POST["firstName"]
        : "";
    $inputLastName = isset($_POST["lastName"])
        ? $_POST["lastName"]
        : "";
    $inputgrade = isset($_POST["grade"])
        ? $_POST["grade"]
        : 0;
    if (strlen($input) < 1 || strlen($input) > 21){
        if (strlen($inputLastName) < 1 || strlen($inputLastName) > 22){

        $messageSecond = "Perenimi peab sisaldama 2 kuni 22 märki!";
        }
        $messageFirst = "Eesnimi peab sisaldama 1 kuni 21 märki!";

    }elseif (strlen($inputLastName) < 1 || strlen($inputLastName) > 22){

        $messageSecond = "Perenimi peab sisaldama 2 kuni 22 märki!";

    }else{
        $originalFirstName = $_POST["original-firstname"];
        $firstName = trim($_POST["firstName"]);
        $lastName = trim($_POST["lastName"]);
        $grade = $_POST["grade"];
        editAuthor($originalFirstName, $firstName, $lastName, $grade);
        header("Location: author-list.php?message=changed");
    }


}else{
    $firstName = $_GET["firstName"];
    $originalFirstname = $firstName;
    $post = getAuthorByFirstname($firstName);

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
<?php if($messageFirst !== ""): ?>
    <div id="error-block"><?= $messageFirst?><br></div>
<?php endif; ?>
<?php if($messageSecond !== ""): ?>
    <div id="error-block"><?= $messageSecond?><br></div>
<?php endif; ?>
<form class="contents-add" action="edit-author.php" method="post">
    <label for="eesnimi">Eesnimi: </label>
    <?php if($messageFirst !== "" || $messageSecond !== ""): ?>
        <input type="text" id="eesnimi" name="firstName" value="<?=$input?>"><br>
    <?php else: ?>
        <input type="text" id="eesnimi" name="firstName" value="<?=$post["firstName"]?>"><br>
    <?php endif; ?>

    <label for="perenimi">Perekonnanimi: </label>
    <?php if($messageFirst !== "" || $messageSecond !== ""): ?>
        <input type="text" id="perenimi" name="lastName" value="<?=$inputLastName?>"><br>
        <input type="text" id="perenimi" name="lastName" value="<?=$post["lastName"]?>"><br>
    <?php else: ?>
        <input type="text" id="perenimi" name="lastName" value="<?=$post["lastName"]?>"><br>
    <?php endif; ?>

    <label for="hinne1">Hinne: </label>
    <input type="radio" id="hinne1" name="grade" value="1"
        <?php
        if ($post["grade"] == 1): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 1): ?>
            checked="checked"
        <?php endif; ?>
    >1
    <input type="radio" id="hinne2" name="grade" value="2"
        <?php
        if ($post["grade"] == 2): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 2): ?>
            checked="checked"
        <?php endif; ?>
    >2
    <input type="radio" id="hinne3" name="grade" value="3"
        <?php
        if ($post["grade"] == 3): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 3): ?>
            checked="checked"
        <?php endif; ?>
    >3
    <input type="radio" id="hinne4" name="grade" value="4"
        <?php
        if ($post["grade"] == 4): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 4): ?>
            checked="checked"
        <?php endif; ?>
    >4
    <input type="radio" id="hinne5" name="grade" value="5"
        <?php
        if ($post["grade"] == 5): ?>
            checked="checked"
        <?php
        elseif ($inputgrade == 5): ?>
            checked="checked"
        <?php endif; ?>
    >5 <br>
    <?php if($messageFirst !== "" || $messageSecond !== ""): ?>
        <input type="hidden" name="original-firstname" value="<?=$originalFirstname?>">

    <?php else: ?>
        <input type="hidden" name="original-firstname" value="<?=$post["firstName"]?>">

    <?php endif; ?>

    <input type="submit" id="submitButton" name="submitButton" value="Salvesta">

</form>
<form action="delete-author.php" method="post">
    <?php if($messageFirst === "" && $messageSecond === ""): ?>
        <input type="hidden" name="post-to-delete" value="<?= $post["firstName"]?>"/>
    <?php else: ?>
        <input type="hidden" name="post-to-delete" value="<?=$originalFirstname?>"/>
    <?php endif; ?>
    <input type="submit" name="deleteButton" value="Kustuta"/>
</form>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>
