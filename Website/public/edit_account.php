<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once  "config.php";

$new_firstname = "";
$new_lastname = "";
$new_username = "";
$new_email = "";

$new_firstname_err = "";
$new_lastname_err = "";
$new_username_err = "";
$new_email_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["new_firstname"]))) {
        $new_firstname_err = "Please enter your first name.";
    } else {
        $new_firstname = trim($_POST["new_firstname"]);
    }

    if (empty(trim($_POST["new_lastname"]))) {
        $new_lastname_err = "Please enter your last name.";
    } else {
        $new_lastname = trim($_POST["new_lastname"]);
    }

    if (empty(trim($_POST["new_username"]))) {
        $new_username_err = "Please enter your username.";
    } else {
        $new_username = trim($_POST["new_username"]);
    }

    if (empty(trim($_POST["new_email"]))) {
        $new_email_err = "Please enter your email.";
    } else {
        $new_email = trim($_POST["new_email"]);
    }

    // Check input errors
    if (isset($new_firstname)  && isset($new_lastname) && isset($new_username) && isset($new_email) ){
        // Prepare an update statement
        $query = "call comp2003_d.updateUserDetails(?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "issss", $param_id, $param_firstname, $param_lastname, $param_username, $param_email);

            // Set parameters
            $param_id = $_SESSION["userID"];
            $param_firstname = $new_firstname;
            $param_lastname = $new_lastname;
            $param_username = $new_username;
            $param_email = $new_email;

            $_SESSION["firstName"] = $new_firstname;
            $_SESSION["lastName"] = $new_lastname;
            $_SESSION["username"] = $new_username;
            $_SESSION["email"] = $new_email;

            echo " set parameters ";
            echo $param_id, $param_firstname,$param_lastname,$param_username,$param_email;

            if(mysqli_stmt_execute($stmt)){
//              Account updated
                header("location: welcome.php");
            } else{
                echo ("Something went wrong try again.");
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Pirates Treasure - Edit account</title>

    <style>
        .form{
            border-radius: 35px;
            background-color: #f2f2f2;
            padding: 20px;
            width: 70%;
            margin-top: 50px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            line-height: 60px;
            background-color: #343a40;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="index.php"><img src="../assets/img/pirate.png" class="d-inline-block align-top"
                                                      width="77.5" height="56"></a>

        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="leaderboard.php">Leaderboards</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="news.php">News</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="download.php">Download</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about_us.php">About us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact_us.php">Contact us</a>
            </li>
        </ul>
        <?php

        session_start();

        if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true){
            echo '<ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="stats.php">Stats</a>
                    </li>
                    </ul>

                    <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Account</a>
                    </li>
                </ul>';
        }
        else{
            echo '<ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>';
        }
        ?>
    </div>
</nav>

<div class="container d-flex align-items-center flex-column text-center">
    <div class="form">
        <h2>Enter the areas you want to change</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group
                <?php echo (!empty($new_email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="new_email" class="form-control" value="<?php session_start(); echo $_SESSION["email"]?>">

                <span class="help-block">
                    <?php echo $new_email_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($new_firstname_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="new_firstname" class="form-control" value="<?php session_start(); echo $_SESSION["firstName"]?>">

                <span class="help-block">
                    <?php echo $new_firstname_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($new_lastname_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="new_lastname" class="form-control" value="<?php session_start(); echo $_SESSION["lastName"]?>">

                <span class="help-block">
                    <?php echo $new_lastname_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($new_username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="new_username" class="form-control" value="<?php session_start(); echo $_SESSION["username"]?>">

                <span class="help-block">
                    <?php echo $new_username_err; ?>
                </span>
            </div>

            <div class="form-group">
                <input name="submitBtn "type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-primary" value="Reset">
            </div>

            <a href="welcome.php">Cancel</a>

        </form>
    </div>
</div>
</div>





</body>

<footer class="footer">
    <div class="container">
            <span class="text-muted">Created by COMP2003 Group_D. Link to Github:
            <a href="https://github.com/BRANDONHARRY/COMP2003_pirate_D">https://github.com/BRANDONHARRY/COMP2003_pirate_D</a></span>
    </div>
</footer>

