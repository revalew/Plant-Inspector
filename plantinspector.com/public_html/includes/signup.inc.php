<?php

// isset() -> if something (in parenthesis) is set inside the code then continue
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['uid'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdrepeat'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // can not be set to just === true because some errors would be treated as if they were not errors
    if (emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false) {
        // create error massage inside url (after question mark ?) to display error message pop-up
        header('location: ../signup.php?error=emptyinput');
        exit();
    }
    
    if (invalidUid($username) !== false) {
        header('location: ../signup.php?error=invaliduid');
        exit();
    }

    if (invalidEmail($email) !== false) {
        header('location: ../signup.php?error=invalidemail');
        exit();
    }

    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header('location: ../signup.php?error=passworddontmatch');
        exit();
    }

    if (uidExists($conn, $username, $email) !== false) {
        header('location: ../signup.php?error=usernametaken');
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd);
    
} else {
    // PHP function that can send user into set place
    header('location: ../signup.php');
    exit();
}