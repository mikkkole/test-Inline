<?php
$posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);

$comments = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);

$dbConnect = mysqli_connect('localhost', 'root', 'root', 'testInlane');

if ($dbConnect == false){
    print("Ошибка подключения к БД: " . mysqli_connect_error());
}
else {

    foreach ($posts as $post) {
        foreach ($post as $elem){
            $var = "'" . mysqli_real_escape_string($dbConnect, $elem). "'";
            $sqlElem[] = $var;
        }
        $row = "(" . implode(',', $sqlElem) . ")";
        unset($sqlElem);
        $sqlPost[] = $row;
    }

    foreach ($comments as $comment) {
        foreach ($comment as $elem){
            $var = "'" . mysqli_real_escape_string($dbConnect, $elem). "'";
            $sqlElem[] = $var;
        }
        $row = "(" . implode(',', $sqlElem) . ")";
        unset($sqlElem);
        $sqlComments[] = $row;
    }

    $query = "INSERT INTO posts (userId, id, title, body) VALUES " . implode(',', $sqlPost);
    $resultPosts = mysqli_query($dbConnect, $query);

    $query = "INSERT INTO comments (postId, id, name, email, body) VALUES " . implode(',', $sqlComments);
    $resultComments = mysqli_query($dbConnect, $query);

    if ($resultPosts and $resultComments) {
        echo "Загружено " . count($sqlPost) . " записей и " . count($sqlComments) . " комментариев";
    }

    //var_dump($sqlComments);
}

