<?php

// prevent user from visiting sudents page if session is not active or has been destroyed on logout
session_start();
include "../php/config.php";

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
} else {
    $user_id = $_SESSION["user_id"];
}

/************** RETRIEVE DETAILS FROM THE DATABASE START **************/

$sql = "SELECT * FROM student_login WHERE id != '$user_id' ORDER BY first_name";
$result = mysqli_query($connect, $sql);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

// $id = $row['id'];
// $first_name = $row['first_name'];
// $last_name = $row['last_name'];
// $father_name = $row['father_name'];
// $mother_name = $row['mother_name'];
// $gender = $row['gender'] == 1 ? "Male" : ($row['gender'] == 2 ? "Female" : "Others");
// $date_of_birth = $row['date_of_birth'];
// $email_id = $row['email_id'];
// $address = $row['address'];
// $pincode = $row['pincode'];
// $state = $row['state'];
// $city = $row['city'];
// $profile_pic = $row['profile_pic'];

/************** RETRIEVE DETAILS FROM THE DATABASE END **************/

/*________________________________________________________________________________________________*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" />
</head>

<body style="background-color: #eee;">

    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 p-3 mb-4">
                        <!-- Container wrapper -->
                        <!-- <div class="container"> -->
                        <!-- Navbar brand -->
                        <a class="navbar-brand me-0" href="https://mdbgo.com/">
                            <!-- <img src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp" height="16"
                                    alt="MDB Logo" loading="lazy" style="margin-top: -1px;" /> -->
                        </a>
                        <h3 class="mb-0 ms-2 nav_title">Student Profiles</h3>
                        <!-- Toggle button -->
                        <button class="navbar-toggler p-0 mb-0" type="button" data-mdb-toggle="collapse"
                            data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>

                        <!-- Collapsible wrapper -->
                        <div class="collapse navbar-collapse" id="navbarButtonsExample">
                            <!-- Left links -->
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <!-- <a class="nav-link" href="#">Student Profile</a> -->
                                </li>
                                <li class="nav-item">
                                    <ol class="breadcrumb mt-2 mt-lg-0"
                                        style="background-color: #e9ecef; padding: 12px 16px; border-radius:0.5rem">
                                        <li class="breadcrumb-item">
                                            <a href="http://localhost/PROJECT/CRUD_OPERATIONS/routes/profile.php"
                                                style="color: #3b71ca">My Profile
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="http://localhost/PROJECT/CRUD_OPERATIONS/routes/update.php"
                                                style="color: #3b71ca">Update
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">Students</li>
                                        <li class="breadcrumb-item">
                                            <a href="http://localhost/PROJECT/CRUD_OPERATIONS/register.php"
                                                style="color: #3b71ca">Register
                                                New
                                            </a>
                                        </li>
                                    </ol>
                                </li>
                            </ul>
                            <!-- Left links -->

                            <div class="d-flex justify-content-end justify-content-xs-center align-items-center">
                                <!-- <button type="button" class="btn btn-link px-3 me-2">
                                        Login
                                    </button> -->
                                <a href="../php/logout.php" role="button" class="btn btn-primary mt-1 mt-lg-0">
                                    Logout
                                </a>
                                <!-- <a class="btn btn-dark px-3" href="https://github.com/mdbootstrap/mdb-ui-kit"
                                        role="button"><i class="fab fa-github"></i></a> -->
                            </div>
                        </div>
                        <!-- Collapsible wrapper -->
                        <!-- </div> -->
                        <!-- Container wrapper -->
                    </nav>
                    <!-- Navbar -->
                </div>
            </div>
            <div class="row">
                <?php foreach ($students as $student) {
                    echo "
                        <div class='col-lg-3 col-md-4 col-sm-6 col-xs-6'>
                            <div class='card mb-4'>
                                <div class='card' style='border-radius: 15px;'>
                                    <div class='card-body text-center'>
                                        <div class='mt-3 mb-4'>
                                            <div class='img-thumbnail rounded-circle img-fluid' style='width: 150px; height: 150px;background-image: url(../img/upload/{$student["profile_pic"]}); background-size: cover; background-position: top center;
                                            margin: auto;' alt='Student Image'></div>
                                        </div>
                                        <h6 class='mb-2'>" .
                        strtoupper(
                            $student["first_name"] . " " . $student["last_name"]
                        ) .
                        "</h6>
                                        <p class='text-muted mb-4'>#" .
                        strtoupper(substr($student["id"], 6)) .
                        " | <a href='mailto:{$student["email_id"]}'>@" .
                        strtolower($student["first_name"]) .
                        "</a></p>                                
                                        <a href='./view.php?id={$student["id"]}' role='button' class='btn btn-primary btn-rounded btn-lg'>
                                            View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                ";
                } ?>
            </div>
    </section>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</body>

</html>