
<?php
//<!-- database handler -->
//<!-- writing something after closing tag for PHP like adding space or anything in a file containing only PHP can cause real trouble SO we can open the tag "<.?php" and just do not close it in this situation-->
    // configuration for XAMPP local server
    $serverName = "localhost";
    $dBUsername = "";
    $dBPassword = "";
    $dBName = "itproject";

    $conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
