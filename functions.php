<?php

const BOOKS_DATA_FILE= "books.txt";

const AUTHORS_DATA_FILE= "authors.txt";

function getBooksPosts(){
    $lines = file(BOOKS_DATA_FILE);
    $posts = [];
    foreach ($lines as $line){
        list($title, $author, $grade) = explode(",", $line);
        $posts[] = ["title" =>urldecode($title), "author" =>urldecode($author),
            "grade" =>urldecode($grade)];
    }
    return $posts;
}
function getAuthorsPosts(){
    $lines = file(AUTHORS_DATA_FILE);
    $posts = [];
    foreach ($lines as $line){
        list($firstName, $lastName, $grade) = explode(",", $line);
        $posts[] = ["firstName" =>urldecode($firstName), "lastName" =>urldecode($lastName),
            "grade" =>urldecode($grade)];
    }
    return $posts;
}
function getBookByTitle($title){
    $posts = getBooksPosts();
    foreach ($posts as $post){
        if ($post["title"] === $title){
            return $post;
        }
    }
    return null;
}
function getAuthorByFirstname($firstName){
    $posts = getAuthorsPosts();
    foreach ($posts as $post){
        if ($post["firstName"] === $firstName){
            return $post;
        }
    }
    return null;
}

function addBook($title, $author, $grade){

    $line = urlencode($title) . "," . urlencode($author) . "," . urlencode($grade) . PHP_EOL;
    file_put_contents(BOOKS_DATA_FILE, $line, FILE_APPEND);
}
function addAuthor($firstName, $lastName, $grade){
    $line = urlencode($firstName) . "," . urlencode($lastName) . "," . urlencode($grade) . PHP_EOL;
    file_put_contents(AUTHORS_DATA_FILE, $line, FILE_APPEND);
}
function deleteBookByTitle($title){
    $posts = getBooksPosts();
    $data = "";

    foreach ($posts as $post){
        if ($post["title"] !== $title){
            $data = $data .  urlencode($post["title"]) . "," . urlencode($post["author"])
                . "," . urlencode($post["grade"]) . PHP_EOL;
        }
    }
    file_put_contents(BOOKS_DATA_FILE, $data);
}
function deleteAuthorByFirstname($firstName){
    $posts = getAuthorsPosts();
    $data = "";

    foreach ($posts as $post){
        if ($post["firstName"] !== $firstName){
            $data = $data .  urlencode($post["firstName"]) . "," . urlencode($post["lastName"])
                . "," . urlencode($post["grade"]) . PHP_EOL;
        }
    }
    file_put_contents(AUTHORS_DATA_FILE, $data);

}
function editBook($originalTitle, $title, $author, $grade){
    $posts = getBooksPosts();
    $data = "";
    foreach ($posts as $post){
        if ($post["title"] === $originalTitle){
            $post["title"] = $title;
            $post["author"] = $author;
            $post["grade"] = $grade;
        }
        $data = $data .  urlencode($post["title"]) . "," . urlencode($post["author"])
            . "," . urlencode($post["grade"]) . PHP_EOL;
    }

    file_put_contents(BOOKS_DATA_FILE, $data);

}
function editAuthor($originalFirstName, $firstName, $lastName, $grade){
    $posts = getAuthorsPosts();
    $data = "";
    foreach ($posts as $post){
        if ($post["firstName"] === $originalFirstName){
            $post["firstName"] = $firstName;
            $post["lastName"] = $lastName;
            $post["grade"] = $grade;
        }

        $data = $data .  urlencode($post["firstName"]) . "," . urlencode($post["lastName"])
            . "," . urlencode($post["grade"]) . PHP_EOL;

    }

    file_put_contents(AUTHORS_DATA_FILE, $data);

}
