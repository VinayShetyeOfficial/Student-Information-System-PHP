<?php

// prevent user from visiting view page if session is not active or has been destroyed on logout
session_start();
include "../php/config.php";

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
}

$user_id = $_REQUEST["id"];

/************** RETRIEVE DETAILS FROM THE DATABASE START **************/
/************** MAIN START **************/
$sql = "SELECT * FROM student_details WHERE id = '$user_id'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);

$id = $row["id"];
$first_name = $row["first_name"];
$last_name = $row["last_name"];
$father_name = $row["father_name"];
$mother_name = $row["mother_name"];
$gender =
    $row["gender"] == 1 ? "Male" : ($row["gender"] == 2 ? "Female" : "Others");
$date_of_birth = $row["date_of_birth"];
$email_id = $row["email_id"];
$address = $row["address"];
$pincode = $row["pincode"];
$state = $row["state"];
$city = $row["city"];
$profile_pic = $row["profile_pic"];

//media links
$website = $row["website"] != "---" ? $row["website"] : "";
$github = $row["github"] != "---" ? $row["github"] : "";
$twitter = $row["twitter"] != "---" ? $row["twitter"] : "";
$instagram = $row["instagram"] != "---" ? $row["instagram"] : "";
$facebook = $row["facebook"] != "---" ? $row["facebook"] : "";

/************** RETRIEVE DETAILS FROM THE DATABASE END **************/
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

    <style>
        .disable-link {
            pointer-events: none !important;
            color: grey !important;
        }

        a.media-link {
            display: block;
            max-width: 180px;
            text-align: right;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 p-3 mb-4">
                        <a class="navbar-brand me-0" href="https://mdbgo.com/">
                        </a>
                        <h3 class="mb-0 ms-2 nav_title">View Profile</h3>
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
                                        <li class="breadcrumb-item">
                                            <a href="http://localhost/PROJECT/CRUD_OPERATIONS/routes/students.php"
                                                style="color: #3b71ca">Students
                                            </a>
                                        </li>
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
                                <a href="../php/logout.php" role="button" class="btn btn-primary mt-1 mt-lg-0">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </nav>
                    <!-- Navbar -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="img-thumbnail img-fluid"
                                style="width: 200px; height: 200px; border-radius: .5em; background-image: url('<?php echo "../img/upload/" .
                                    $profile_pic; ?>'); background-size: cover; background-position: top center; margin: auto;"
                                alt="User Image">
                                <!-- <div class="fa-3x" style="position: relative; top: -15px; left: -15px; width: 25px; height: 25px; background-image: url('../img/eye.svg'); border: 2px solid #e0e0e0; border-radius: 50%; background-color: #333333;">
                                </div> -->
                            </div>
                            <h5 class="my-3" style="text-transform: uppercase">
                                <?php echo $first_name . " " . $last_name; ?>
                            </h5>
                            <p class="mb-3"><strong>Student ID:</strong> <?php echo strtoupper(
                                substr($id, 6)
                            ); ?></p>
                            <div class="d-flex justify-content-center mb-2">
                                <a href="mailto:<?php echo $email_id; ?>" role="button"
                                    class="btn btn-primary">Connect</a>
                                <a href="#" role="button" class="btn btn-outline-primary ms-1"
                                    data-mdb-ripple-color="primary">Message</a>
                            </div>

                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fas fa-globe fa-lg text-warning"></i>
                                    <p class="mb-0"><a href="<?php echo $website !=
                                    ""
                                        ? "https://" . $website
                                        : ""; ?>"
                                            class="media-link" target="_blank">
                                            <?php echo $website != ""
                                                ? $website
                                                : "---"; ?>
                                        </a></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-github fa-lg" style="color: #333333;"></i>
                                    <p class="mb-0"><a
                                            href="<?php echo $github != ""
                                                ? "https://github.com/" .
                                                    $github
                                                : ""; ?>"
                                            class="media-link" target="_blank">
                                            <?php echo $github != ""
                                                ? $github
                                                : "---"; ?>
                                        </a></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                    <p class="mb-0"><a
                                            href="<?php echo $twitter != ""
                                                ? "https://twitter.com/" .
                                                    $twitter
                                                : ""; ?>"
                                            class="media-link" target="_blank">
                                            <?php echo $twitter != ""
                                                ? $twitter
                                                : "---"; ?>
                                        </a></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                    <p class="mb-0"><a
                                            href="<?php echo $instagram != ""
                                                ? "https://instagram.com/" .
                                                    $instagram
                                                : ""; ?>"
                                            class="media-link" target="_blank">
                                            <?php echo $instagram != ""
                                                ? $instagram
                                                : "---"; ?>
                                        </a></p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                    <p class="mb-0"><a
                                            href="<?php echo $facebook != ""
                                                ? "https://facebook.com/" .
                                                    $facebook
                                                : ""; ?>"
                                            class="media-link" target="_blank">
                                            <?php echo $facebook != ""
                                                ? $facebook
                                                : "---"; ?>
                                        </a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4 d-lg-flex flex-lg-row">
                        <div class="col-lg-6">
                            <div class="card-body" style="padding-right: 1rem">
                                <div class="row">
                                    <h5>Personal Information</h5>
                                    <hr>
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>Full Name</strong></strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0">
                                            <?php echo $first_name .
                                                " " .
                                                $last_name; ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>Gender</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0"><?php echo $gender; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>Birth Date</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0">
                                            <?php echo $date_of_birth; ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>Email</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0">
                                            <!-- <a href="mailto:<?php echo "" .
                                                $email_id; ?>"> -->
                                            <?php echo $email_id; ?>
                                            <!-- </a> -->
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>Father's Name</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0">
                                            <?php echo $mother_name; ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>Mother's Name</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0"><?php echo $mother_name; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card-body">
                                <div class="row">
                                    <h5>Contact Information</h5>
                                    <hr>
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>Address</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0">
                                            <?php echo $address; ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>City</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0"><?php echo $city; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>State</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0">
                                            <?php echo $state; ?>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p class="mb-0"><strong>Pincode</strong></p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted mb-0">
                                            <?php echo $pincode; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span>
                                        Project
                                        Status
                                    </p>
                                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 80%"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 72%"
                                            aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 89%"
                                            aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 55%"
                                            aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                    <div class="progress rounded mb-2" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 66%"
                                            aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span>
                                        Project
                                        Status
                                    </p>
                                    <p class="mb-1" style="font-size: .77rem;">Web Design</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 80%"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Website Markup</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 72%"
                                            aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">One Page</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 89%"
                                            aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Mobile Template</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 55%"
                                            aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Backend API</p>
                                    <div class="progress rounded mb-2" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 66%"
                                            aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        // disabling pointer event if links are empty
        function toggleLink() {
            var link_status = document.querySelectorAll('.media-link');
            link_status.forEach(element => {
                if (element.textContent.trim() === "" || element.textContent.trim() === "---") {
                    element.classList.add('disable-link');
                }
            });
        }

        toggleLink();
    </script>

</body>

</html>