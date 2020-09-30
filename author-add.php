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
<form class="contents-add" action="author-list.php">
    <label for="eesnimi">Eesnimi: </label>
    <input type="text" id="eesnimi" name="firstName"><br>
    <label for="perenimi">Perekonnanimi: </label>
    <input type="text" id="perenimi" name="lastName"><br>
    <label for="hinne1">Hinne: </label>
    <input type="radio" id="hinne1" name="grade" value="1">1
    <input type="radio" id="hinne2" name="grade" value="2">2
    <input type="radio" id="hinne3" name="grade" value="3">3
    <input type="radio" id="hinne4" name="grade" value="4">4
    <input type="radio" id="hinne5" name="grade" value="5">5
    <input type="submit" id="submitButton" name="submitButton" value="Lisa">
</form>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>
