<?php
require_once("functions.php");
$postToDelete = $_POST["post-to-delete"];
deleteBookByTitle($postToDelete);
header("Location: index.php?message=deleted");