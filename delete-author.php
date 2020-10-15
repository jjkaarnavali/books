<?php
require_once("functions.php");
$postToDelete = $_POST["post-to-delete"];
deleteAuthorByFirstname($postToDelete);
header("Location: author-list.php?message=deleted");
