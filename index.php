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
<table class="contents-list">
    <thead>
    <tr>
        <th>Pealkiri</th>
        <th>Autorid</th>
        <th>Hinne</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $lines = file('books.txt');
    foreach ($lines as $line) {
        $parts = explode(',', trim($line));
        list($pealkiri, $autor, $hinne) = $parts;
        $pealkiri = urldecode($pealkiri);
        $autor = urldecode($autor);
        $hinne = urldecode($hinne);
        print '<tr>';
        print '<td>' . $pealkiri . '</td>';
        print '<td>' . $autor . '</td>';
        print '<td>' . $hinne . '</td>';
        print '</tr>';
    }
    ?>
    </tbody>
</table>
<footer>ICD0007 Näidisrakendus</footer>
</body>
</html>
