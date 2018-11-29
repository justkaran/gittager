<?php
require_once 'config.php';

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
}

if (isset($_POST['create'])) {
    $tags = trim($_POST['tags']);
    $user = trim($_POST['user']);
    $url = trim($_POST['url']);

        $sql = "INSERT INTO gits (created, user, url) VALUES (NOW(), '{$user}', '{$url}')";
        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        $tags = explode(",", $tags);

        foreach ($tags as $tag) {
            $tag = str_ireplace("#", "", $tag);
            $tag = trim($tag);
            $sql = "INSERT INTO tags (created, user, git, tag) VALUES (NOW(), '{$user}', '{$id}', '{$tag}')";
            if (mysqli_query($conn, $sql)) {
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['item'];
    echo $sql = "DELETE FROM gits WHERE id=" . $id;
    if (mysqli_query($conn, $sql)) {
    }else {
        echo "Error: ". mysqli_error($conn);
    }
    echo $sql = "DELETE FROM tags WHERE git=" . $id;
    if (mysqli_query($conn, $sql)) {
    }else {
        echo "Error: ". mysqli_error($conn);
    }
    exit();
}

?>