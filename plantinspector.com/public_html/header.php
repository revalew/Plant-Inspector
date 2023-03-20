<?php
    // every single page on our website will have a session started so user will be loged in on every single page
    session_start();
    include_once 'includes/dbh.inc.php';
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
//print_r($curPageName);
    // echo '<p style="margin-top: 300px; z-index: 10;">The current page name is: '.$curPageName.'</p>';  
    // echo "</br>";  
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="Maksymilian Kisiel">
    <meta name="keywords" content="project, internet technologies">
    <meta name="description"
        content="The website is supposed to be a tool reminding us to take care of our plants/flowers and share that with other users.">

    <title>Plant Inspector - The best plant caretaking tool</title>
    <link rel="stylesheet" href="./css/style.css">
    <!-- font awesome icons -->
</head>
<body>
    <nav>
        <div class="wrapper">
            <!-- desktop menu -->
            <div class="nav-items">
                <ul>
                    <li class="first"><a href="index.php#">home</a></li>
                    <?php
                    if ($curPageName == "index.php") {
                        echo '<li class="menu-list"><a href="index.php#about-us">about us</a></li>';
                        echo '<li class="menu-list"><a href="index.php#products">progress</a></li>';
                        echo '<li class="menu-list"><a href="index.php#contact">contact</a></li>';
                    }
                    ?>
                </ul>
                
                <?php
                    if (isset($_SESSION['useruid'])) {
                        echo '<a href="chart_ajax.php">charts</a>';
                        echo '<a href="profile.php">profile page</a>';
                        echo '<a href="includes/logout.inc.php">Log out</a>';
                    } else {
                        echo '<a href="signup.php">Sign Up</a>';
                        echo '<a href="login.php">Log In</a>';
                    }
                ?>
            </div>
            <!-- mobile menu -->
            <!-- <button class="burger-icon"><i class="fa-solid fa-bars"></i></button> -->
            <button class="burger-icon"><img src="./img/menu-2.svg"></button>
            <div class="nav-items-mobile hide">
                <a class="nav-link" href="index.php#">home</a>
                <?php
                    if ($curPageName == "index.php") {
                        echo '<a class="nav-link" href="index.php#about-us">about us</a>';
                        echo '<a class="nav-link" href="index.php#products">progress</a>';
                    }
                ?>

                <a class="nav-link" href="index.php#contact">contact</a>
                
                <?php
                    if (isset($_SESSION['useruid'])) {
                        echo '<a class="nav-link" href="chart_ajax.php">charts</a>';
                        echo '<a class="nav-link" href="profile.php">profile page</a>';
                        echo '<a class="nav-link" href="includes/logout.inc.php">Log out</a>';
                    } else {
                        echo '<a class="nav-link" href="signup.php">Sign Up</a>';
                        echo '<a class="nav-link" href="login.php">Log In</a>';
                    }
                ?>
            </div>
        </div>
    </nav>
    
