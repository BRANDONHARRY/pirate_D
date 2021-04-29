<?php
session_start();

//Check to see if user already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

require_once  "config.php";

// Define variables and initialize with empty values
$email = "";
$password = "";

$email_err = "";
$password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        $email_check = "SELECT userID, firstName, lastName, username, email FROM comp2003_d.usertbl WHERE email = ?";
        $login_query = "call comp2003_d.login(?, ?)";

        // Checks if the email is valid
        if ($stmt = mysqli_prepare($con, $email_check)) {
            mysqli_stmt_bind_param($stmt, "s", $email);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    mysqli_stmt_bind_result($stmt, $userID, $firstName, $lastName, $username, $email);

                    if (mysqli_stmt_fetch($stmt)){
                        if ($stmt = mysqli_prepare($con, $login_query)) {
                            mysqli_stmt_bind_param($stmt, "ss", $email, $password);

                            if (mysqli_stmt_execute($stmt)) {
                                mysqli_stmt_store_result($stmt);

                                if (mysqli_stmt_num_rows($stmt) > 0) {
                                    session_start();

                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["userID"] = $userID;
                                    $_SESSION["firstName"] = $firstName;
                                    $_SESSION["lastName"] = $lastName;
                                    $_SESSION["username"] = $username;
                                    $_SESSION["email"] = $email;

                                    // Redirect user to welcome page
                                    header("location: welcome.php");

                                }else {
                                    $password_err = "The password you entered was not valid.";
                                }
                            }
                        }
                    }
                }
            } else{
                    $email_err = "No account found with that email.";
            }
        } else{
                echo "Something went wrong. Please try again later.";
        }
        mysqli_close($con);
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Pirates Treasure - Login</title>

    <style>
        .form{
            border-radius: 35px;
            background-color: #f2f2f2;
            padding: 20px;
            width: 70%;
            margin-top: 50px;
        }
        .header {
            padding: 80px;
            text-align: center;
            color: white;
            background-size:100% 100%;
            background-image: url("../assets/img/Game.png");
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
                        <a class="nav-link" href="welcome.php">Account</a>
                    </li>
                </ul>';
            }
            else{
                echo '<ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item active">
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
                <h2>Login</h2>

                <p>Please fill in your credentials to login.</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group
                        <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">

                        <span class="help-block">
                            <?php echo $email_err; ?>
                        </span>
                    </div>

                    <div class="form-group
                        <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">

                        <span class="help-block">
                            <?php echo $password_err; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>

                    <p>
                        Don't have an account? <a href="register.php">Sign up now</a>.
                    </p>
                </form>
        </div>
    </div>
</body>

<footer class="footer">
    <div class="container">
            <span class="text-muted">Created by COMP2003 Group_D. Link to Github:
            <a href="https://github.com/BRANDONHARRY/COMP2003_pirate_D">https://github.com/BRANDONHARRY/COMP2003_pirate_D</a></span>
    </div>
</footer>