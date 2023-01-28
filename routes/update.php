<?php

// prevent user from visiting update page if session is not active or has been destroyed on logout
session_start();
include "../php/config.php";

if (!isset($_SESSION["user_id"])) {
    header("location: ./login.php");
} else {
    $user_id = $_SESSION["user_id"];
}

// define variables and set to empty values
$email_error = $password_error = "";
$first_name = $last_name = $father_name = $mother_name = $gender = $date_of_birth = $email_id = $address = $pincode = $state = $city = $password = $confirm_password =
    "";

if (isset($email_error) || isset($password_error)) {
    $email_error = "";
    $password_error = "";
}

/************** RETRIEVE DETAILS FROM THE DATABASE START **************/
/************** MAIN START **************/
$sql = "SELECT * FROM student_details WHERE id = '$user_id'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);

$id_val = $row["id"];
$first_name_val = $row["first_name"];
$last_name_val = $row["last_name"];
$father_name_val = $row["father_name"];
$mother_name_val = $row["mother_name"];
$gender_val =
    $row["gender"] == 1 ? "Male" : ($row["gender"] == 2 ? "Female" : "Others");
$date_of_birth_val = $row["date_of_birth"];
$email_id_val = $row["email_id"];
$address_val = $row["address"];
$pincode_val = $row["pincode"];
$state_val = $row["state"];
$city_val = $row["city"];
$profile_pic_val = $row["profile_pic"];

// calculate age
$date = new DateTime($date_of_birth_val);
$now = new DateTime();
$interval = $now->diff($date);
$age_val = $interval->format("%Y");

/************** RETRIEVE DETAILS FROM THE DATABASE END **************/

/*________________________________________________________________________________________________
 /************** EMAIL VALIDATION START **************/
// function for email validation
function is_valid_email($email_ip)
{
    global $connect;
    global $email_error;

    if (empty($email_ip)) {
        $email_error =
            "<i style='font-size:24px' class='fas'>&#xf06a;</i> Email is required";
        return false;
    } else {
        $email_ip = test_input($email_ip);

        // check if the email address is in correct format/well-formed
        if (!filter_var($email_ip, FILTER_VALIDATE_EMAIL)) {
            $email_error =
                "<i style='font-size:24px' class='fas'>&#xf06a;</i> Invalid email";
            return false;
        }
    }

    // if everything checks out to be correct, then allow to proceed with the current email id
    return true;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/************** EMAIL VALIDATION END **************/

/*________________________________________________________________________________________________
 /************** PASSWORD VALIDATION  START **************/
// function for password validation
function is_valid_password($password, $confirm_password)
{
    global $password_error;

    // validation code.
    if (empty($password)) {
        $password_error =
            "<i style='font-size:24px' class='fas'>&#xf06a;</i> Password is required";
        return false;
    } elseif ($password != $confirm_password) {
        // error for mismatch of passwords
        $password_error =
            "<i style='font-size:24px' class='fas'>&#xf06a;</i> Passwords mismatch";
        return false;
    }

    // if everything checks out to be correct, then allow to proceed with the current email id

    return true;
}

/************** PASSWORD VALIDATION END **************/
/*________________________________________________________________________________________________
 /************** CREATE USER START **************/
// function for creating user/new user record
function update_user(
    $first_name,
    $last_name,
    $father_name,
    $mother_name,
    $gender,
    $date_of_birth,
    $email_id,
    $address,
    $pincode,
    $state,
    $city,
    $password
) {
    global $connect;
    global $user_id;

    $password_hash = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);

    $sql = "UPDATE student_details 
    SET first_name = '$first_name', last_name = '$last_name',	father_name = '$father_name', mother_name = '$mother_name', gender = '$gender', 
    date_of_birth = '$date_of_birth', email_id = '$email_id', address = '$address',	pincode = '$pincode', state = '$state',	
    city = '$city', password = '$password', password_hash = '$password_hash'
    WHERE id = '$user_id'";

    if (mysqli_query($connect, $sql)) {
        // echo "New record inserted successfully!";
        $sql = "UPDATE student_login
        SET first_name = '$first_name', last_name = '$last_name', email_id = '$email_id', password = '$password', password_hash = '$password_hash'
        WHERE id = '$user_id'";

        mysqli_query($connect, $sql);
    } else {
        echo "<i style='font-size:24px' class='fas'>&#xf06a;</i> Error inserting new record!";
        return false;
    }

    return true;
}

/************** CREATE USER END **************/

/*________________________________________________________________________________________________
 /************** MAIN START **************/
// code execution starts here when submit
if (isset($_POST["email_id"]) && isset($_POST["password"])) {
    // Reading from values
    $first_name = ucwords(strtolower($_POST["first_name"]));
    $last_name = ucwords(strtolower($_POST["last_name"]));
    $father_name = ucwords(strtolower($_POST["father_name"]));
    $mother_name = ucwords(strtolower($_POST["mother_name"]));
    $gender = $_POST["gender"];
    $date_of_birth = $_POST["date_of_birth"];
    $email_id = strtolower($_POST["email_id"]);
    $address = ucwords(strtolower($_POST["address"]));
    $pincode = $_POST["pincode"];
    $state = ucwords(strtolower($_POST["state"]));
    $city = ucwords(strtolower($_POST["city"]));
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (
        is_valid_email($email_id) &&
        is_valid_password($password, $confirm_password)
    ) {
        if (
            update_user(
                $first_name,
                $last_name,
                $father_name,
                $mother_name,
                $gender,
                $date_of_birth,
                $email_id,
                $address,
                $pincode,
                $state,
                $city,
                $password
            )
        ) {
            echo "
                <script>
                    alert('Profile Updated Successfully!');
                    window.location = './profile.php';
                </script>
            ";
        } else {
            echo "
            <script>
                alert('Error Updating Profile!');
                window.location = './update.php';
            </script>
        ";
        }
    }
}

/************** MAIN END **************/
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

        .details{
            margin-left: 1rem;
        }

        @media only screen and (max-width: 460px) {
            .card>div {
                flex-direction: column !important;
            }

            .card>div:first-child>div:first-child {
                margin: 2rem 0 0 !important;
            }

            .btn-del {
                width: 150px !important;
                margin: auto !important;
            }

            .card > div:first-child + div {
                padding-top: 5rem !important;
            }

            .card>div+div>div {
                justify-content: center !important;
            }

            .details{
                margin-left: 0rem !important;
            }

            .details > h5{
                margin-top: -370px !important;
                matgin-left: !important;
                text-align: center
            }

            .details > p{
                display: none;
            }
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
                        <h3 class="mb-0 ms-2 nav_title">Update Profile</h3>
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
                                            <a href="./profile.php"
                                                style="color: #3b71ca">My Profile
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">Update</li>
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
                                <a href="../php/logout.php" role="button" class="btn btn-primary mt-1 mt-lg-0">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </nav>
                    <!-- Navbar -->
                </div>
            </div>

            <section class="h-100 gradient-custom-2">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col col-lg-9 col-xl-7">
                            <div class="card rounded-3" style="overflow: hidden">
                                <div class="rounded-top text-white d-flex flex-row"
                                    style="background-color: #000; height:200px;">
                                    <div class="ms-4 mt-5 d-flex flex-column" style="height: 230px;">
                                        <div alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                            style="width: 150px; height: 200px; z-index: 1; background-image: url('<?php echo "../img/upload/" .
                                                $profile_pic_val; ?>'); background-size: cover; background-position: top center; margin: auto;">
                                        </div>
                                        <button type="button" class="btn btn-danger btn-del" onclick="confirm_delete()"
                                            style="z-index: 1; height: 40px">
                                            Delete profile
                                        </button>
                                    </div>
                                    <div class="details" style="margin-top: 130px;">
                                        <h5>
                                            <?php echo $first_name_val .
                                                " " .
                                                $last_name_val; ?>
                                        </h5>
                                        <p><?php echo $state_val; ?>, India</p>
                                    </div>
                                </div>
                                <div class="p-4 text-black" style="background-color: #f8f9fa;">
                                    <div class="d-flex justify-content-end text-center py-1">
                                        <div>
                                            <p class="mb-1 h5">
                                                <?php echo "#" .
                                                    strtoupper(
                                                        substr($id_val, 6)
                                                    ); ?>
                                            </p>
                                            <p class="small text-muted mb-0">Student ID</p>
                                        </div>
                                        <div class="px-3">
                                            <p class="mb-1 h5"><?php echo substr(
                                                $gender_val,
                                                0,
                                                1
                                            ); ?></p>
                                            <p class="small text-muted mb-0">Gender</p>
                                        </div>
                                        <div>
                                            <p class="mb-1 h5">
                                                <?php echo $age_val; ?>
                                            </p>
                                            <p class="small text-muted mb-0">Age</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="card-body p-md-5 text-black">
                                        <!------------- FORM Start ------------->
                                        <form id="registration_form" action="update.php" method="POST">

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-outline">
                                                        <input type="text" name="first_name" id="form3Example1m"
                                                            class="form-control form-control-lg"
                                                            value="<?php echo $first_name_val; ?>"
                                                            style="text-transform: uppercase" required />
                                                        <label class="form-label" for="form3Example1m">First
                                                            name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-outline">
                                                        <input type="text" name="last_name" id="form3Example1n"
                                                            class="form-control form-control-lg"
                                                            value="<?php echo $last_name_val; ?>"
                                                            style="text-transform: uppercase" required />
                                                        <label class="form-label" for="form3Example1n">Last name</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div class="form-outline">
                                                        <input type="text" name="father_name" id="form3Example1n1"
                                                            class="form-control form-control-lg"
                                                            value="<?php echo $father_name_val; ?>"
                                                            style="text-transform: uppercase" required />
                                                        <label class="form-label" for="form3Example1n1">Father's
                                                            name</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <div class="form-outline">
                                                        <input type="text" name="mother_name" id="form3Example1m1"
                                                            class="form-control form-control-lg"
                                                            value="<?php echo $mother_name_val; ?>"
                                                            style="text-transform: uppercase" required />
                                                        <label class="form-label" for="form3Example1m1">Mother's
                                                            name</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">

                                                <h6 class="mb-1 me-4">Gender: </h6>

                                                <div class="form-check form-check-inline mb-0 me-4">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="maleGender" value="1" <?php echo $gender_val ==
                                                        "Male"
                                                            ? "checked"
                                                            : ""; ?> required />
                                                    <label class="form-check-label" for="maleGender">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0 me-4">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="femaleGender" value="2" <?php echo $gender_val ==
                                                        "Female"
                                                            ? "checked"
                                                            : ""; ?> required />
                                                    <label class="form-check-label" for="femaleGender">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="otherGender" value="3" <?php echo $gender_val ==
                                                        "Others"
                                                            ? "checked"
                                                            : ""; ?> required />
                                                    <label class="form-check-label" for="otherGender">Other</label>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-outline mb-4">
                                                        <input type="date" name="date_of_birth" id="datePickerId"
                                                            class="form-control form-control-lg"
                                                            value="<?php echo $date_of_birth_val; ?>" required />
                                                        <label class="form-label" for="form3Example9">DOB</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-outline mb-4">
                                                        <input type="text" name="email_id" id="form3Example97"
                                                            class="form-control form-control-lg"
                                                            value="<?php echo $email_id
                                                                ? $email_id
                                                                : $email_id_val; ?>"
                                                            style="text-transform: lowercase" readonly />
                                                        <label class="form-label" for="form3Example97">Email ID</label>
                                                        <span class="error">
                                                            <?php echo $email_error; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-outline mb-4">
                                                        <input type="text" name="address" id="form3Example8"
                                                            class="form-control form-control-lg"
                                                            value="<?php echo $address_val; ?>"
                                                            style="text-transform: uppercase" required />
                                                        <label class="form-label" for="form3Example8">Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-outline mb-4">
                                                        <input type="text" name="pincode" maxlength="6"
                                                            id="form3Example90" pattern="[1-9]{1}[0-9]{5}"
                                                            title="Must start with a digit between 1-9"
                                                            class="form-control form-control-lg"
                                                            value="<?php echo $pincode_val; ?>" required />
                                                        <label class="form-label" for="form3Example90">Pincode</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 mb-4">
                                                    <select class="select" name="state" id="countrySelect" size="1"
                                                        onchange="makeSubmenu(this.value)" style="width: 100%" required>
                                                        <option value="" selected disabled>State</option>
                                                        <?php
                                                        $states = [
                                                            "Andaman and Nicobar Islands",
                                                            "Andhra Pradesh",
                                                            "Arunachal Pradesh",
                                                            "Assam",
                                                            "Bihar",
                                                            "Chandigarh",
                                                            "Chhattisgarh",
                                                            "Dadar and Nagar Haveli",
                                                            "Daman and Diu",
                                                            "Delhi",
                                                            "Goa",
                                                            "Gujarat",
                                                            "Haryana",
                                                            "Himachal Pradesh",
                                                            "Jammu and Kashmir",
                                                            "Jharkhand",
                                                            "Karnataka",
                                                            "Kerala",
                                                            "Lakshadweep",
                                                            "Madhya Pradesh",
                                                            "Maharashtra",
                                                            "Manipur",
                                                            "Meghalaya",
                                                            "Mizoram",
                                                            "Nagaland",
                                                            "Odisha",
                                                            "Puducherry",
                                                            "Punjab",
                                                            "Rajasthan",
                                                            "Sikkim",
                                                            "Tamil Nadu",
                                                            "Telangana",
                                                            "Tripura",
                                                            "Uttar Pradesh",
                                                            "Uttarakhand",
                                                            "West Bengal",
                                                        ];

                                                        foreach (
                                                            $states
                                                            as $val
                                                        ) {
                                                            echo "<option value='$val' " .
                                                                ($state_val ==
                                                                $val
                                                                    ? "selected"
                                                                    : "") .
                                                                " >$val</option>";
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                                <div class="col-md-6 col-sm-6 mb-4">
                                                    <select class="select" name="city" id="citySelect" size="1"
                                                        style="width: 100%" required>
                                                        <option value=selected disabled>City</option>
                                                        <?php echo "<option value='$city_val'>$city_val</option>"; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-outline mb-4">
                                                        <input type="password" name="password" id="password"
                                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                            class="form-control form-control-lg" value="" required />
                                                        <label class="form-label" for="form3Example8">New
                                                            Password</label>
                                                        <!-- <span class="error">
                                                        <?php echo $password_error; ?>
                                                    </span> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="form-outline mb-4">
                                                        <input type="password" name="confirm_password"
                                                            id="confirm_password"
                                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                            title="Must contain at least one number <br> and one uppercase and lowercase letter, and at least 8 or more characters"
                                                            class="form-control form-control-lg" value="" required />
                                                        <label class="form-label" for="form3Example90">Confirm
                                                            Password</label>
                                                        <span class="error">
                                                            <?php echo $password_error; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center pt-3">
                                                <button type="button" onclick="resetForm()"
                                                    class="btn btn-outline-warning btn-lg"
                                                    data-mdb-ripple-color="warning">Reset all</button>
                                                <button type="submit" class="btn btn-primary btn-lg ms-2">Save</button>
                                            </div>

                                        </form>
                                        <!------------- FORM End ------------->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>

    <!-- Delete Profile -->
    <script>
        function confirm_delete() {
            if (confirm("Are you sure?\nDo you really want to delete your account.\n\nPlease Note: This process cannot be undone.")) {
                window.location = '../php/delete_account.php';
            }
            else {
                console.log('Account Not Deleted');
            }
        }
    </script>

</body>

</html>