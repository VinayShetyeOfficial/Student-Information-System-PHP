<?php

// prevent user from visiting profile page if session is not active or has been destroyed on logout
session_start();
include "../php/config.php";

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
} else {
    $user_id = $_SESSION["user_id"];
}

// define variables and set to empty values
$upload_error = "";

/************** RETRIEVE DETAILS FROM THE DATABASE START **************/

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

// converting DOB in words
$timestamp = strtotime($date_of_birth);
$date_of_birth_in_words = date("F d, Y", $timestamp);

/************** RETRIEVE DETAILS FROM THE DATABASE END **************/

/*________________________________________________________________________________________________
 /************** UPLOADED PICTURE VALIDATION  START **************/

// 😭 Below validation function Not WOrking 😢 [Please fix for me!]

// function is_image($path)
// {
//     echo $path;
//     $a = getimagesize(asset("storage/" . $path));
// 	$image_type = $a[2];

// 	if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
// 	{
// 		return true;
// 	}
// 	return false;
// }

/************** UPLOADED PICTURE VALIDATION END **************/

/************** UPLOADED PICTURE TO DATABASE START **************/

/*________________________________________________________________________________________________
 /************** MAIN START **************/
// code execution starts here when submit [- uploaded pic and clicked save]
if (isset($_POST["upload"])) {
    $filename = $_FILES["upload_file"]["name"];
    $tempname = $_FILES["upload_file"]["tmp_name"];

    // rename the file with user name in the format [firstname_lastname.extension];
    // $arr = explode(".", $filename);                                // function to split string on '.'
    // $filename = $first_name . "_" . $last_name . "_" . strtoupper(substr($user_id, 6)) . "." . $arr[1];

    // Keeping file extension same for all uploaded files, just to avoid redundancy of files with same names - different extensions
    // Eg. JOHN_DOE_D092078.jpg    &    JOHN_DOE_D092078.png    &    FILENAME_ID.*EXTENSIONS
    $filename = strtoupper(
        $first_name . "_" . $last_name . "_" . substr($user_id, 6) . ".png"
    );

    $folder = "../img/upload/" . $filename;

    move_uploaded_file($tempname, $folder);

    $sql = "UPDATE student_details SET profile_pic = '$filename' WHERE id = '$user_id';";
    $sql .= "UPDATE student_login SET profile_pic = '$filename' WHERE id = '$user_id';";

    $upload = mysqli_multi_query($connect, $sql);

    // Now let's move the uploaded image into the folder: image
    if ($upload) {
        echo "
        <script>
            alert('Photo Uploaded Successfully!');
            window.location = './profile.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Failed to upload image!');
            window.location = './profile.php';
        </script>
        ";
    }
}

/************** UPLOADED PICTURE VALIDATION  START **************/
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
        .list-group-flush>.list-group-item {
            height: 4rem !important;
        }

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
                        <!-- Container wrapper -->
                        <!-- <div class="container"> -->
                        <!-- Navbar brand -->
                        <a class="navbar-brand me-0" href="https://mdbgo.com/">
                            <!-- <img src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp" height="16"
                                alt="MDB Logo" loading="lazy" style="margin-top: -1px;" /> -->
                        </a>
                        <h3 class="mb-0 ms-2 nav_title">Your Profile</h3>
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
                                        <li class="breadcrumb-item">My Profile</li>
                                        <li class="breadcrumb-item">
                                            <a href="./update.php"
                                                style="color: #3b71ca">Update
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="./students.php"
                                                style="color: #3b71ca">Students
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="../register.php"
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
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="img-thumbnail img-fluid"
                                style="width: 200px; height: 200px; border-radius: .5em; background-image: url('<?php echo "../img/upload/" .
                                    $profile_pic; ?>'); background-size: cover; background-position: top center; margin: auto;">
                                <!-- <img src="<?php echo "../img/upload/" .
                                    $profile_pic; ?>" ; alt="avatar"
                                    class="img-thumbnail img-fluid"
                                    style="width: 100%; height: 100%; object-fit: cover;"> -->
                            </div>
                            <h5 class="my-3" style="text-transform: uppercase">
                                <?php echo $first_name . " " . $last_name; ?>
                            </h5>
                            <p class="mb-1"><strong>Student ID:</strong> <?php echo strtoupper(
                                substr($id, 6)
                            ); ?></p>
                            <p class="text-muted mb-4">
                                <a href="mailto:<?php echo "" . $email_id; ?>">
                                    <?php echo $email_id; ?>
                                </a>
                            </p>
                            <div class="d-flex justify-content-center mb-2">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    &nbsp;
                                    <a href="./update.php" role="button"
                                        class="btn btn-success">Update Profile</a>
                                    &nbsp;
                                    <a href="" id="upload_link" class="file btn btn-outline-warning mt-3"
                                        data-mdb-ripple-color="warning">Upload Pic</a>
                                    <input id="upload_file" name="upload_file" type="file"
                                        accept="image/x-png,image/gif,image/jpeg" onchange="showSaveBtn()"
                                        style="display: none">
                                    <button type="submit" name="upload" id="saveBtn" class="btn btn-default mt-3"
                                        style="background: #6600ff; display: none;">
                                        <i class="fas fa-save" style="font-size: 15px; color:#fff"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3 links">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fas fa-globe fa-lg text-warning"></i>
                                    <p class="mb-0 link-item" id="edit-item-1"><a class="media-link"
                                            href="<?php echo "https://" .
                                                $website; ?>" target="_blank">
                                            <?php echo $website != ""
                                                ? $website
                                                : "---"; ?>
                                        </a>
                                        <i style="font-size:13px; position: absolute; top: 5.5px; right: 5.5px; cursor:pointer; display:none"
                                            class="fa" onclick="editOn(1)">&#xf044;</i>
                                    </p>

                                    <input type="text" name="website" id="edit-ip-1"
                                        class="form-control form-control-md" onblur="updateLink(1)"
                                        style="width: 205px; display: none" placeholder="Eg. www.mywebsite.com">

                                </li>
                                <li class=" list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-github fa-lg" style="color: #333333;"></i>
                                    <p class="mb-0 link-item" id="edit-item-2"><a class="media-link"
                                            href="<?php echo "https://github.com/" .
                                                $github; ?>" target="_blank">
                                            <?php echo $github != ""
                                                ? $github
                                                : "---"; ?>
                                        </a> <i
                                            style="font-size:13px; position: absolute; top: 5.5px; right: 5.5px; cursor:pointer; display:none"
                                            class="fa" onclick="editOn(2)">&#xf044;</i></p>

                                    <input type="text" name="github" id="edit-ip-2" class="form-control form-control-md"
                                        onblur="updateLink(2)" style="width: 180px; display: none"
                                        placeholder="Eg. BradTraversy">
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                    <p class="mb-0 link-item" id="edit-item-3"><a class="media-link"
                                            href="<?php echo "https://twitter.com/" .
                                                $twitter; ?>" target="_blank">
                                            <?php echo $twitter != ""
                                                ? $twitter
                                                : "---"; ?>
                                        </a> <i
                                            style="font-size:13px; position: absolute; top: 5.5px; right: 5.5px; cursor:pointer; display:none"
                                            class="fa" onclick="editOn(3)">&#xf044;</i></p>

                                    <input type="text" name="twitter" id="edit-ip-3"
                                        class="form-control form-control-md" onblur="updateLink(3)"
                                        style="width: 180px; display: none" placeholder="Eg. BradTraversy">
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                    <p class="mb-0 link-item" id="edit-item-4"><a class="media-link"
                                            href="<?php echo "https://instagram.com/" .
                                                $instagram; ?>" target="_blank">
                                            <?php echo $instagram != ""
                                                ? $instagram
                                                : "---"; ?>
                                        </a> <i
                                            style="font-size:13px; position: absolute; top: 5.5px; right: 5.5px; cursor:pointer; display:none"
                                            class="fa" onclick="editOn(4)">&#xf044;</i></p>

                                    <input type="text" name="instagram" id="edit-ip-4"
                                        class="form-control form-control-md" onblur="updateLink(4)"
                                        style="width: 180px; display: none" placeholder="Eg. BradTraversy">
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                    <p class="mb-0 link-item" id="edit-item-5"><a class="media-link"
                                            href="<?php echo "https://facebook.com/" .
                                                $facebook; ?>" target="_blank">
                                            <?php echo $facebook != ""
                                                ? $facebook
                                                : "---"; ?>
                                        </a> <i
                                            style="font-size:13px; position: absolute; top: 5.5px; right: 5.5px; cursor:pointer; display:none"
                                            class="fa" onclick="editOn(5)">&#xf044;</i></p>

                                    <input type="text" name="facebook" id="edit-ip-5"
                                        class="form-control form-control-md" onblur="updateLink(5)"
                                        style="width: 180px; display: none" placeholder="Eg. BradTraversy">
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
                                            <?php echo $date_of_birth_in_words; ?>
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
                                            <?php echo $father_name; ?>
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

        // upload button function 
        $(function () {
            $("#upload_link").on('click', function (e) {
                e.preventDefault();
                $("#upload_file:hidden").trigger('click');
            });
        });

        function showSaveBtn() {
            document.getElementById('saveBtn').style.display = 'inline-block';
        }

        // disabling pointer event if links are empty
        function toggleLink() {
            var link_status = document.querySelectorAll('.media-link');
            link_status.forEach(element => {
                if (element.textContent.trim() === "" || element.textContent.trim() === "---") {
                    element.classList.add('disable-link');
                }
                else if (element.textContent.trim() != "") {
                    element.classList.remove('disable-link');
                }
            });
        }

        toggleLink();

        // edit button function
        function editOn(val) {
            var linkItem = document.getElementById("edit-item-" + val);
            var inputItem = document.getElementById("edit-ip-" + val);

            // toggle display of input and link element
            linkItem.style.display = "none";
            inputItem.style.display = "block";
            inputItem.value = linkItem.firstChild.text.trim() != "---" ? linkItem.firstChild.text.trim() : "";
            inputItem.focus();

            // add event listener to input element to save the changes
            inputItem.addEventListener("blur", function () {

                if (this.value.trim() === "") {
                    this.value = "---";
                    var currentVal = linkItem.firstChild.text = this.value;
                    //linkItem.firstChild.style.pointerEvents = "none";
                }
                else {
                    var currentVal = linkItem.firstChild.text = this.value;
                }

                if (currentVal.trim() == "---") {
                    currentVal = " ";
                }

                toggleLink();
                
                switch (val) {

                    case 1:
                        var media = this.value;
                        break;

                    case 2:
                        var media = "github.com/" + currentVal;
                        break;

                    case 3:
                        var media = "twitter.com/" + currentVal;
                        break;

                    case 4:
                        var media = "instagram.com/" + currentVal;
                        break;

                    case 5:
                        var media = "facebook.com/" + currentVal;
                        break;
                }

                linkItem.firstChild.href = "https://" + media;
                linkItem.style.display = "block";
                inputItem.style.display = "none";
            });
        }


        // Add event listener for edit-btns
        function displayBtn() {
            var listItems = document.querySelectorAll('.list-group-item');
            for (var i = 0; i < listItems.length; i++) {
                listItems[i].addEventListener('mouseover', function () {
                    var editIcon = this.querySelector('.fa');
                    editIcon.style.display = 'block';
                });
                listItems[i].addEventListener('mouseout', function () {
                    var editIcon = this.querySelector('.fa');
                    editIcon.style.display = 'none';
                });
            }
        }

        // call the function on window load
        displayBtn();

        // function to save links to database on input blur 
        function updateLink(linkId) {

            var link = document.getElementById("edit-ip-" + linkId).value;
            // Send the link value to the PHP script using AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "../php/update_links.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            switch (linkId) {
                case 1:
                    var link_item = "website";
                    break;

                case 2:
                    var link_item = "github";
                    break;

                case 3:
                    var link_item = "twitter";
                    break;

                case 4:
                    var link_item = "instagram";
                    break;

                case 5:
                    var link_item = "facebook";
                    break;
                default:
                    var link_item = "link";
                    break;

            }

            xhttp.send(link_item + "=" + link);
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // alert(this.responseText);
                }
            }
        }



    </script>

</body>

</html>