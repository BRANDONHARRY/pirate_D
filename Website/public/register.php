<?php
require_once  "config.php";

// Define variables and initialize with empty values
$email = "";
$password = "";
$confirm_password = "";
$firstName = "";
$lastName = "";
$username = "";

$email_err = "";
$password_err = "";
$confirm_password_err = "";
$firstName_err = "";
$lastName_err = "";
$username_err = "";


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    }
    else{
        $query_email = "SELECT userID FROM comp2003_d.usertbl WHERE email = ?;";

        if($stmt = mysqli_prepare($con, $query_email)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $checkEmail);

            // Set parameters
            $checkEmail = trim($_POST["email"]);

            // Attempt to execute the prepared statements
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) > 0){
                    echo ("email taken ");
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate first name
    if(empty(trim($_POST["firstname"]))){
        $firstName_err = "Please enter your first name.";
    } else{
        $firstName = trim($_POST["firstname"]);
    }

    // Validate last name
    if(empty(trim($_POST["lastname"]))){
        $lastName_err = "Please enter your last name.";
    } else{
        $lastName = trim($_POST["lastname"]);
    }

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        $query_username = "SELECT userID FROM comp2003_d.usertbl WHERE username = ?;";
        if($stmt = mysqli_prepare($con, $query_username)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $checkUsername);

            // Set parameters
            $checkUsername = trim($_POST["username"]);

            // Attempt to execute the prepared statements
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) > 0){
                    $username_err = "This username is already taken. Try again.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }


    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($firstName_err) && empty($lastName_err) && empty($username_err)){
        $query = "call comp2003_d.register(?, ?, ?, ?, ?);";

        if($stmt = mysqli_prepare($con,$query)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $firstNameInput, $lastNameInput, $usernameInput, $emailInput, $passwordInput);


            // Set parameters
            $firstNameInput = $firstName;
            $lastNameInput = $lastName;
            $usernameInput = $username;
            $emailInput = $email;
            $passwordInput = $password;


//             Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                echo '<script language="javascript">';
                echo 'alert("User registered")';
                echo '</script>';
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

//     Close connection
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Pirates Treasure - Register</title>

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
            <a class="navbar-brand" href="index.php" aria-label="banner">
                <img src="../assets/img/pirate.png" class="d-inline-block align-top" width="78" height="56" alt="banner">
            </a>

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
                        <li class="nav-item active">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    </ul>';
            }
            ?>
        </div>
    </nav>

    <div class="container d-flex align-items-center flex-column text-center">
        <div class="form">
            <h1>Sign Up</h1>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group
                    <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="">

                    <span class="help-block">
                        <?php echo $email_err; ?>
                    </span>
                </div>

                <div class="form-group
                    <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>

                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">

                    <span class="help-block">
                        <?php echo $password_err; ?>
                    </span>
                </div>

                <div class="form-group
                    <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>

                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">

                    <span class="help-block">
                        <?php echo $confirm_password_err; ?>
                    </span>
                </div>

                <div class="form-group
                    <?php echo (!empty($firstName_err)) ? 'has-error' : ''; ?>">
                    <label>First Name</label>
                    <input type="text" name="firstname" class="form-control" value="">

                    <span class="help-block">
                        <?php echo $firstName_err; ?>
                    </span>
                </div>

                <div class="form-group
                    <?php echo (!empty($lastName_err)) ? 'has-error' : ''; ?>">
                    <label>Last Name</label>
                    <input type="text" name="lastname" class="form-control" value="">

                    <span class="help-block">
                        <?php echo $lastName_err; ?>
                    </span>
                </div>

                <div class="form-group
                    <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="">

                    <span class="help-block">
                        <?php echo $username_err; ?>
                    </span>
                </div>



                <div class="form-group">
                    <input name = "submitBtn" type ="submit" class = "btn btn-primary" value = "Submit">
                    <input type="reset" class="btn btn-primary" value="Reset">
                </div>

                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </div>



    <footer class="footer">
        <div class="container">
                <span class="text-muted">Created by COMP2003 Group_D. Link to Github:
                <a href="https://github.com/BRANDONHARRY/COMP2003_pirate_D">https://github.com/BRANDONHARRY/COMP2003_pirate_D</a></span>
        </div>
    </footer>

</body>
</html>