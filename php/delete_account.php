<?php

session_start();
include_once "./config.php";

$user_id = $_SESSION["user_id"];

$sql = "DELETE a.*, b.*
FROM student_details a
LEFT JOIN student_login b
ON a.id = b.id
WHERE a.id = '$user_id';
";

if (mysqli_query($connect, $sql)) {
    echo "
        <script>
            alert('Account Deleted Successfully!');
            window.location = '../routes/login.php';
        </script>
    ";

    session_destroy();
} else {
    echo "
        <script>
            alert('Error Deleting Account!');
            window.location = '../routes/profile.php';
        </script>
    ";
}

?>
