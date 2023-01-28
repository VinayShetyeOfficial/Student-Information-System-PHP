<?php

session_start();
include_once "./config.php";

$user_id = $_SESSION["user_id"];

// function to check if link is valid or not
// if $link is alphanumeric, then its valid else invalid
function check_if_valid($link)
{
    if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9.-_?]+$/', $link)) {
        return false;
    }

    return true;
}

// Get the edited link value
if (isset($_POST["website"])) {
    $media = "website";
    $link =
        $_POST["website"] != "" && check_if_valid($_POST["website"])
            ? $_POST["website"]
            : "---";
} elseif (isset($_POST["github"])) {
    $media = "github";
    $link =
        $_POST["github"] != "" && check_if_valid($_POST["github"])
            ? $_POST["github"]
            : "---";
} elseif (isset($_POST["twitter"])) {
    $media = "twitter";
    $link =
        $_POST["twitter"] != "" && check_if_valid($_POST["twitter"])
            ? $_POST["twitter"]
            : "---";
} elseif (isset($_POST["instagram"])) {
    $media = "instagram";
    $link =
        $_POST["instagram"] != "" && check_if_valid($_POST["instagram"])
            ? $_POST["instagram"]
            : "---";
} elseif (isset($_POST["facebook"])) {
    $media = "facebook";
    $link =
        $_POST["facebook"] != "" && check_if_valid($_POST["facebook"])
            ? $_POST["facebook"]
            : "---";
} else {
    echo "No link set";
}

$sql = "UPDATE student_details SET $media = '$link' WHERE id = '$user_id'";

mysqli_query($connect, $sql);

// Update the link value in the database
?>