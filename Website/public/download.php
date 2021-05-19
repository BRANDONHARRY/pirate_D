<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Pirates Treasure - Download</title>

        <style>
            .header {
                padding: 80px;
                text-align: center;
                color: white;
                background-size:100% 100%;
                background-image: url("../assets/img/Game.png");
            }
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                height: 60px;
                line-height: 60px;
                background-color: #343a40;
            }
            br{
                display: block;
                content: "";
                margin-top: 100px;
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
                        <a class="nav-link active" href="download.php">Download</a>
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

        <div class="header">
            <img src="../assets/img/pirate_treasure.png" aria-label="logo">
            <p>A website created by group_D</p>
        </div>
        <div class="container text-center mt-5 px-5">
            <h1>
                Download guide
            </h1>
            <h2>
                Step 1:
            </h2>
            <p>
                Head to the github page shown below:
            </p>
            <img src="../assets/img/step1.PNG" width="70%" height="70%" alt="banner">
            <h2>
                Step 2:
            </h2>
            <p>
                Click on the green "Code" button this will display the popup below where you will want to click download ZIP:
            </p>
            <img src="../assets/img/step2.PNG" width="70%" height="70%" alt="banner">
            <h2>
                Step 3:
            </h2>
            <p>
                Download the file to a location of your choice:
            </p>
            <img src="../assets/img/step3.PNG" width="70%" height="70%" alt="banner">
            <h2>
                Step 4:
            </h2>
            <p>
                Extract the zipped file here like so:
            </p>
            <img src="../assets/img/step4.png" width="70%" height="70%" alt="banner">
            <h2>
                Step 5:
            </h2>
            <p>
                Locate the "Pirate Treasure" and open it to find the game executable:
            </p>
            <img src="../assets/img/step5.png" width="70%" height="70%" alt="banner">
            <h2>
                Step 5:
            </h2>
            <p>
                Once you have found this file you are able to open the game and play it as much as you desire!
            </p>
            <img src="../assets/img/step6.png" width="70%" height="70%" alt="banner">
        </div>

        <footer class="footer">
            <div class="container">
                <span class="text-muted">Created by COMP2003 Group_D. Link to Github:
                <a href="https://github.com/BRANDONHARRY/COMP2003_pirate_D">https://github.com/BRANDONHARRY/COMP2003_pirate_D</a></span>
            </div>
        </footer>
    <br>
    </body>
</html>
