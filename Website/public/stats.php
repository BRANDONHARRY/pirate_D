<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once  "config.php";

$new_password = "";
$confirm_password = "";
$new_password_err = "";
$confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $query = "UPDATE comp2003_d.usertbl SET password = ? WHERE userID = ?";

        if ($stmt = mysqli_prepare($con, $query)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            if(mysqli_stmt_execute($stmt)){
//              Password updated
                session_destroy();
                header("location: login.php");
            } else{
                echo ("Something went wrong try again.");
            }
            mysqli_stmt_close();
        }
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

    <title>Pirates Treasure - Stats</title>

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
                    <li class="nav-item active">
                        <a class="nav-link" href="stats.php">Stats</a>
                    </li>
                    </ul>';
        }
        ?>
        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="welcome.php">Account</a>
            </li>
        </ul>
        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        </ul>
        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container d-flex align-items-center flex-column text-center">
    <div class="form">
        <h2>Stats</h2>
        <p>Please enter the scores you have gained in the game.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group
                <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>High Score</label>
                <input type="number" name="new_password" class="form-control" value="<?php echo $new_password; ?>">

                <span class="help-block">
                    <?php echo $new_password_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Kills</label>
                <input type="number" name="confirm_password" class="form-control">

                <span class="help-block">
                    <?php echo $confirm_password_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Time Survived</label>
                <input type="number" name="confirm_password" class="form-control">

                <span class="help-block">
                    <?php echo $confirm_password_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Balls Fired</label>
                <input type="number" name="confirm_password" class="form-control">

                <span class="help-block">
                    <?php echo $confirm_password_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Chests Collected</label>
                <input type="number" name="confirm_password" class="form-control">

                <span class="help-block">
                    <?php echo $confirm_password_err; ?>
                </span>
            </div>



            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
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

