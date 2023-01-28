<?php

session_start();
include "./php/config.php";

if (isset($_SESSION["user_id"])) {
    $login_url = "http://localhost/PROJECT/CRUD_OPERATIONS/routes/profile.php";
} else {
    $login_url = "http://localhost/PROJECT/CRUD_OPERATIONS/routes/login.php";
}

// define variables and set to empty values
$email_error = $password_error = "";
$first_name = $last_name = $father_name = $mother_name = $gender = $date_of_birth = $email_id = $address = $pincode = $state = $city = $password = $confirm_password =
    "";

if (isset($email_error) || isset($password_error)) {
    $email_error = "";
    $password_error = "";
}

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

    // check if the email already exist in the database/already registered
    $sql = "SELECT email_id FROM student_details WHERE email_id = '$email_ip'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        $email_error =
            "<i style='font-size:24px' class='fas'>&#xf06a;</i> Email Id is already exist";
        return false;
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
function create_user(
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
    $password,
    $password_hash,
    $profile_pic,
    $website,
    $github,
    $twitter,
    $instagram,
    $facebook
) {
    global $connect;

    $unique_id = uniqid();

    $sql = "INSERT INTO student_details 
    (id, first_name, last_name,	father_name, mother_name, gender, date_of_birth, email_id, address,	pincode, state,	city, password, password_hash, profile_pic, website, github, twitter, instagram ,facebook)
    VALUES
    ('$unique_id' , '$first_name', '$last_name', '$father_name', '$mother_name', '$gender', '$date_of_birth', '$email_id', '$address', '$pincode', '$state', '$city', '$password', '$password_hash', '$profile_pic', '$website', '$github', '$twitter', '$instagram', '$facebook')";

    if (mysqli_query($connect, $sql)) {
        // echo "New record inserted successfully!";
        $sql = "INSERT INTO student_login
        SELECT id, first_name, last_name, email_id, password, password_hash, profile_pic
        FROM student_details WHERE id = '$unique_id'";

        mysqli_query($connect, $sql);

        return true;
    } else {
        echo "<i style='font-size:24px' class='fas'>&#xf06a;</i> Error inserting new record!";
        return false;
    }
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

    // default avatar pic
    $profile_pic = "default_avatar.png";

    // default media links
    $website = $github = $twitter = $instagram = $facebook = "---";

    if (
        is_valid_email($email_id) &&
        is_valid_password($password, $confirm_password)
    ) {
        // Hashing passowrd for security purpose
        $password_hash = password_hash($password, PASSWORD_DEFAULT, [
            "cost" => 5,
        ]);

        if (
            create_user(
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
                $password,
                $password_hash,
                $profile_pic,
                $website,
                $github,
                $twitter,
                $instagram,
                $facebook
            )
        ) {
            echo "
                <script>
                    alert('Registration Successful!');
                    window.location = './routes/login.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Error Registering User!');
                    window.location = './routes/login.php';
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
    <title>Register</title>
    <link rel="stylesheet" href="./css/style.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" />
</head>

<body onload="reset()">
    <section class="h-100 bg-dark">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card card-registration my-4">
                        <div class="row g-0">
                            <div class="col-xl-6 d-none d-xl-block">
                                <img src="./img/register_img.png" alt="Sample photo" class="img-fluid"
                                    style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
                            </div>
                            <div class="col-xl-6">
                                <div class="card-body p-md-5 text-black">
                                    <h3 class="mb-5 text-uppercase">Student registration form</h3>

                                    <!------------- FORM Start ------------->
                                    <form id="registration_form"
                                        action="<?php echo htmlspecialchars(
                                            $_SERVER["PHP_SELF"]
                                        ); ?>" method="POST">

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="first_name" id="form3Example1m"
                                                        class="form-control form-control-lg"
                                                        value="<?php echo $first_name; ?>"
                                                        style="text-transform: uppercase" required />
                                                    <label class="form-label" for="form3Example1m">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="last_name" id="form3Example1n"
                                                        class="form-control form-control-lg"
                                                        value="<?php echo $last_name; ?>"
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
                                                        value="<?php echo $father_name; ?>"
                                                        style="text-transform: uppercase" required />
                                                    <label class="form-label" for="form3Example1n1">Father's
                                                        name</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="mother_name" id="form3Example1m1"
                                                        class="form-control form-control-lg"
                                                        value="<?php echo $mother_name; ?>"
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
                                                    id="maleGender" value="1" required />
                                                <label class="form-check-label" for="maleGender">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline mb-0 me-4">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="femaleGender" value="2" required />
                                                <label class="form-check-label" for="femaleGender">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline mb-0">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="otherGender" value="3" required />
                                                <label class="form-check-label" for="otherGender">Other</label>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-outline mb-4">
                                                    <input type="date" name="date_of_birth" id="datePickerId"
                                                        class="form-control form-control-lg"
                                                        value="<?php echo $date_of_birth; ?>" required />
                                                    <label class="form-label" for="form3Example9">DOB</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-outline mb-4">
                                                    <input type="text" name="email_id" id="form3Example97"
                                                        class="form-control form-control-lg"
                                                        value="<?php echo $email_id; ?>"
                                                        style="text-transform: lowercase" required />
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
                                                        value="<?php echo $address; ?>" style="text-transform: uppercase"
                                                        required />
                                                    <label class="form-label" for="form3Example8">Address</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-outline mb-4">
                                                    <input type="text" name="pincode" maxlength="6" id="form3Example90"
                                                        pattern="[1-9]{1}[0-9]{5}"
                                                        title="Must start with a digit between 1-9"
                                                        class="form-control form-control-lg"
                                                        value="<?php echo $pincode; ?>" required />
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
                                                        as $state
                                                    ) {
                                                        echo "<option value='$state'>$state</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-md-6 col-sm-6 mb-4">
                                                <select class="select" name="city" id="citySelect" size="1"
                                                    style="width: 100%" required>
                                                    <option value=selected disabled>City</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-outline mb-4">
                                                    <input type="password" name="password" id="password"
                                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                                                        class="form-control form-control-lg"
                                                        value="<?php echo $password; ?>" required />
                                                    <label class="form-label" for="form3Example8">Password</label>
                                                    <!-- <span class="error">
                                                        <?php echo $password_error; ?>
                                                    </span> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-outline mb-4">
                                                    <input type="password" name="confirm_password" id="confirm_password"
                                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                        title="Must contain at least one number <br> and one uppercase and lowercase letter, and at least 8 or more characters"
                                                        class="form-control form-control-lg"
                                                        value="<?php echo $confirm_password; ?>" required />
                                                    <label class="form-label" for="form3Example90">Confirm
                                                        Password</label>
                                                    <span class="error">
                                                        <?php echo $password_error; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-center">Already registered?
                                            <a href="<?php echo $login_url; ?>">&nbsp;&nbsp;Login
                                            </a>
                                        </p>
                                        <div class="d-flex justify-content-center pt-3">
                                            <button type="button" onclick="resetForm()"
                                                class="btn btn-light btn-lg">Reset all</button>
                                            <button type="submit" class="btn btn-warning btn-lg ms-2">Submit
                                                form</button>
                                        </div>

                                    </form>
                                    <!------------- FORM End ------------->

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
    <script type="text/javascript" src="./js/script.js"></script>

</body>

</html>