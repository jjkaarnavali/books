<?php
require_once("functions.php");
$message = "";

$success = $_GET["message"];
if ($success == "success")
    $message = "Lisatud!";
if ($success == "changed")
    $message = "Muudetud!";
if ($success == "deleted")
    $message = "Kustutatud!";
$posts = getAuthorsPosts();
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
    <div id="message-block"><?= $message?><br></div>
<?php endif; ?>
<table class="contents-list">
    <thead>
    <tr>
        <th>Eesnimi</th>
        <th>Perekonnanimi</th>
        <th>Hinne</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($posts as $post): ?>
        <tr>
            <td><a href="edit-author.php?firstName=<?=$post["firstName"]?>"><?=$post["firstName"]?></a></td>
            <td><?=$post["lastName"]?></td>
            <td><?=$post["grade"]?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>
