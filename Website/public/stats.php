<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once  "config.php";

$highscore = 0;
$kills = 0;
$time = 0;
$ballsFired = 0;
$chestsCollected = 0;

$highscore_err = "";
$kills_err = "";
$time_err = "";
$ballsFired_err = "";
$chestsCollected_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty(trim($_POST["highscore"]))){
        $highscore_err = "Please enter your highscore";
    } else{
        $highscore = trim($_POST["highscore"]);
    }

    if(empty(trim($_POST["kills"]))){
        $kills_err = "Please enter the number of balls kills";
    } else{
        $kills = trim($_POST["kills"]);
    }

    if(empty(trim($_POST["time"]))){
        $time_err = "Please enter your time survived";
    } else{
        $time = trim($_POST["time"]);
    }

    if(empty(trim($_POST["ballsFired"]))){
        $ballsFired_err = "Please enter the number of balls fired";
    } else{
        $ballsFired = trim($_POST["ballsFired"]);
    }

    if(empty(trim($_POST["chestsCollected"]))){
        $chestsCollected_err = "Please enter the number of chests collected";
    } else{
        $chestsCollected = trim($_POST["chestsCollected"]);
    }

    // Check input errors
    if (empty($highscore_err) && empty($kills_err) && empty($time_err) && empty($ballsFired_err) && empty($chestsCollected_err)) {

        $query = "call comp2003_d.insertStats(?, ?, ?, ?, ?, ?);";

        if ($stmt = mysqli_prepare($con, $query)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iiiiii", $id, $param_highscore, $param_kills, $param_time, $param_balls, $param_chests);

            // Set parameters
            $id = $_SESSION["userID"];
            $param_highscore = $highscore;
            $param_kills = $kills;
            $param_time = $time;
            $param_balls = $ballsFired;
            $param_chests = $chestsCollected;

            if(mysqli_stmt_execute($stmt)){
//              Stats been submited

            } else{
                echo ("Something went wrong try again.");
            }
            mysqli_stmt_close($stmt);
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
        .popup {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .popup .popuptext {
            visibility: hidden;
            width: 160px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -80px;
        }

        .popup .popuptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .popup .show {
            visibility: visible;
            -webkit-animation: fadeIn 1s;
            animation: fadeIn 1s
        }

        @-webkit-keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity:1 ;}
        }
    </style>
    <script>
        function myFunction() {
            var popup = document.getElementById("myPopup");
            popup.classList.toggle("show");
        }
    </script>
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
        <h2>Stats</h2>
        <p>Please enter the scores you have gained in the game.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group
                <?php echo (!empty($highscore_err)) ? 'has-error' : ''; ?>">
                <label>High Score</label>
                <input type="number" name="highscore" class="form-control" value="<?php echo $highscore; ?>">

                <span class="help-block">
                    <?php echo $highscore_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($kills_err)) ? 'has-error' : ''; ?>">
                <label>Kills</label>
                <input type="number" name="kills" class="form-control" value="<?php echo $kills; ?>">

                <span class="help-block">
                    <?php echo $kills_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($time_err)) ? 'has-error' : ''; ?>">
                <label>Time Survived</label>
                <input type="number" name="time" class="form-control" value="<?php echo $time; ?>">

                <span class="help-block">
                    <?php echo $time_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($ballsFired_err)) ? 'has-error' : ''; ?>">
                <label>Balls Fired</label>
                <input type="number" name="ballsFired" class="form-control" value="<?php echo $ballsFired; ?>">

                <span class="help-block">
                    <?php echo $ballsFired_err; ?>
                </span>
            </div>

            <div class="form-group
                <?php echo (!empty($chestsCollected_err)) ? 'has-error' : ''; ?>">
                <label>Chests Collected</label>
                <input type="number" name="chestsCollected" class="form-control" value="<?php echo $chestsCollected; ?>">

                <span class="help-block">
                    <?php echo $chestsCollected_err; ?>
                </span>
            </div>

            <div class="popup" onclick="myFunction()">
                Click me!
                <span class="popuptext" id="myPopup">Your stats have been submitted!</span>
            </div>

            <div class="form-group">
                <div class="popup" onclick="myFunction()">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <span class="popuptext" id="myPopup">Your stats have been submitted!</span>
                </div>

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

