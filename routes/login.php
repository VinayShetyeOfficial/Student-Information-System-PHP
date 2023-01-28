<?php

session_start();
include "../php/config.php";

// define variable and set empty values
$email_error = $password_error = "";
$email_id = $password = "";
$email_exist = false;

/************** EMAIL VALIDATION START **************/
// function for email validation
function is_valid_email($email_ip)
{
    global $connect;
    global $email_error;
    global $email_exist;

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

        // check if the email exist in the database/already registered
        $sql = "SELECT id, email_id FROM student_login WHERE email_id = '$email_ip'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            $email_exist = true;

            $row = mysqli_fetch_array($result);
            $_SESSION["user_id"] = $row["id"];

            // echo $_SESSION['user_id'];
        } else {
            $email_exist = false;

            $email_error =
                "<i style='font-size:24px' class='fas'>&#xf06a;</i> Email does not exist";
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
function is_valid_password($password)
{
    global $connect;
    global $password_error;
    global $email_exist;

    // Validation code.
    if (empty($password)) {
        $password_error =
            "<i style='font-size:24px' class='fas'>&#xf06a;</i> Password is required";
        return false;
    } elseif ($email_exist) {
        $user_id = $_SESSION["user_id"];
        $sql = "SELECT * FROM student_login WHERE id = '$user_id'";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            if (password_verify($password, $row["password_hash"])) {
                return true;
            } else {
                $password_error =
                    "<i style='font-size:24px' class='fas'>&#xf06a;</i> Password is incorrect";
                return false;
            }
        } else {
            $password_error =
                "<i style='font-size:24px' class='fas'>&#xf06a;</i> User does not exist";
            return false;
        }
    }

    // if everything checks out to be correct, then allow to proceed with the current email id
    return true;
}

/************** CREATE USER END **************/

/*________________________________________________________________________________________________
 /************** MAIN START **************/
// code execution starts here when submit

if (isset($_POST["email_id"]) && isset($_POST["password"])) {
    // reading from values
    $email_id = $_POST["email_id"];
    $password = $_POST["password"];

    if (is_valid_email($email_id) && is_valid_password($password)) {
        echo "
        <script>
            alert('Login Successful!');
            window.location = './profile.php';
        </script>
        ";
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

<body>

    <section class="vh-100" style="background-color: #9A616D;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="../img/login_img.png" ; alt="login form" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form id="login_form" action="<?php echo htmlspecialchars(
                                        $_SERVER["PHP_SELF"]
                                    ); ?>"
                                        method="POST">

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <!-- <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> -->
                                            <span class="h1 fw-bold mb-0">Student Login</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your
                                            account</h5>

                                        <div class="form-outline mb-4">
                                            <input type="email" name="email_id" id="form2Example17"
                                                value="<?php echo $email_id; ?>" class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example17">Email address</label>
                                            <span class="error">
                                                <?php echo $email_error; ?>
                                            </span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" name="password" id="form2Example27"
                                                value="<?php echo $password; ?>" class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example27">Password</label>
                                            <span class="error">
                                                <?php echo $password_error; ?>
                                            </span>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                        </div>

                                        <a class="small text-muted" href="#!">Forgot password?</a>
                                        <p class="mb-5 pb-lg-2" style="color: #000000;">Don't have an account?<a href="../register.php
                                                " style="color: #386bc0;">&nbsp;&nbsp;Register here</a></p>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

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

</body>

</html>