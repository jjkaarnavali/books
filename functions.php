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
        list($firstname, $secondname, $grade) = explode(",", $line);
        $posts[] = ["firstname" =>urldecode($firstname), "secondname" =>urldecode($secondname),
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
function getAuthorByFirstname($firstname){
    $posts = getAuthorsPosts();
    foreach ($posts as $post){
        if ($post["firstname"] === $firstname){
            return $post;
        }
    }
    return null;
}

function addBook($title, $author, $grade){

    $line = urlencode($title) . "," . urlencode($author) . "," . urlencode($grade) . PHP_EOL;
    file_put_contents(BOOKS_DATA_FILE, $line, FILE_APPEND);
}
function addAuthor($firstname, $secondname, $grade){
    $line = urlencode($firstname) . "," . urlencode($secondname) . "," . urlencode($grade) . PHP_EOL;
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
function deleteAuthorByFirstname($firstname){
    $posts = getAuthorsPosts();
    $data = "";

    foreach ($posts as $post){
        if ($post["firstname"] !== $firstname){
            $data = $data .  urlencode($post["firstname"]) . "," . urlencode($post["secondname"])
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
function editAuthor($originalFirstname, $firstname, $secondname, $grade){
    $posts = getAuthorsPosts();
    $data = "";
    foreach ($posts as $post){
        if ($post["firstname"] === $originalFirstname){
            $post["firstname"] = $firstname;
            $post["secondname"] = $secondname;
            $post["grade"] = $grade;
        }

        $data = $data .  urlencode($post["firstname"]) . "," . urlencode($post["secondname"])
            . "," . urlencode($post["grade"]) . PHP_EOL;

    }

    file_put_contents(AUTHORS_DATA_FILE, $data);

}
