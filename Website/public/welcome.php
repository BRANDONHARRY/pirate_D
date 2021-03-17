<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Pirates Treasure - Login</title>

    <style>
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            line-height: 60px;
            background-color: #343a40;
        }
        .bottom{
            position: absolute;
            bottom: 65px;
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
        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="login.php">Account</a>
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
    <h1>Welcome to your account</h1>
    <h4 class="font-weight-bold mb-0">
        <?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]?>
        <span class="text-muted font-weight-normal">
            <?php echo "@" . $_SESSION["username"]?>
        </span>
    </h4>

    <p></p>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table user-view-table m-0">
                <tbody>
                <tr>
                    <td class="font-weight-bold mb-0">First name:</td>
                    <td><?php echo $_SESSION["firstName"]?></td>
                </tr>

                <tr>
                    <td class="font-weight-bold mb-0">Last Name:</td>
                    <td><?php echo $_SESSION["lastName"]?></td>
                </tr>

                <tr>
                    <td class="font-weight-bold mb-0">User Name:</td>
                    <td><?php echo $_SESSION["username"]?></td>
                </tr>

                <tr>
                    <td class="font-weight-bold mb-0">Email:</td>
                    <td><?php echo $_SESSION["email"]?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bottom">
        <a href="stats.php" class="btn btn-primary">Submit a score</a>
        <a href="password_reset.php" class="btn btn-dark">Reset Your Password</a>
        <a href="edit_account.php" class="btn btn-warning">Change account details</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </div>
</div>

</body>

<footer class="footer">
    <div class="container">
            <span class="text-muted">Created by COMP2003 Group_D. Link to Github:
            <a href="https://github.com/BRANDONHARRY/COMP2003_pirate_D">https://github.com/BRANDONHARRY/COMP2003_pirate_D</a></span>
    </div>
</footer>