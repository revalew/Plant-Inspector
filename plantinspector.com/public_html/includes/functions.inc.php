<?php

// SIGN UP FUNCTIONS

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
    $result = true;
    
    // empty() is a built in PHP function that is going to check if there is any data insidethe function
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result = true;
    
    // if string does not match with search parameter (from search algorithm) throw an error
    // the example shown below allows the use of letters from a to z (including capitalized versions) and numbers from 0 to 9
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result = true;
    
    // buitl in PHP function to check if email is correct
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result = true;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = 'SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;';
    
    // everything we are doing in here is tied to the var $stmt because that is our prepared statement inside our code
    // initialize prepared statement:
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../signup.php?error=stmtfailed');
        exit();
    }

    // bind together -> prepared statement , 2 strings (sss if there were 3 strings) , data submited by the user (2 parameters were passed to the function by the user co we write 2 parameters. Theese are going to fill the "?" signs in the $sql prepared statement)
    mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
    
    // execute the statement specified in the brackets:
    mysqli_stmt_execute($stmt);

    // grab the data from database
    $resultData = mysqli_stmt_get_result($stmt);

    // check if the data that we fetch is associative array (arrays with columns set to their name inside the array) and see if there is anything using $resultData
    // if we get a match from database this is going to return true
    if ($row = mysqli_fetch_assoc($resultData)) {
        // if there is the matching data in DB we want to grab the data with the username - alternative purpose -> $row
        // return all the data inside $row if this user already exists inside the database. We can use it to log in the user instead
        return $row;
    } else {
        $result = false;
        return $result;
    }

    // close the prepared statement we created in here
    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd) {
    
    // pass the data to the DB in proper order
    $sql = 'INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);';
    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../signup.php?error=stmtfailed');
        exit();
    }
    
    // hashing the password - hiding the actual passwords
    // using the built in PHP function. The one used here updates automatically when the new hashing algorithms are released by PHP
    // PASSWORD_DEFAULT - default password hashing algorithm
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // connect new user to profile img table
    bindUserToImg($conn, $name, $username);
    // create table and folder for user files
    createUserContentTableAndFolder($conn, $name, $username);

    header('location: ../signup.php?error=none');
    exit();
}

// LOG IN FUNCTIONS

function emptyInputLogin($username, $pwd) {
    $result = true;

    if (empty($username) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd){
    
    // using the second purpose of our $row var created inside uidExists() function
    // we are checking for uid OR email so we pass $username as both because we prepared SQL statement to check for either one of those ($sql in uidExists())
    $uidExists = uidExists($conn, $username, $username);

    // error handler if uid does not exist
    if ($uidExists === false) {
        header('location: ../login.php?error=wronglogin');
        exit();
    }
    
    // check if hashed password passed by the user matches with the one that is hashed inside our database
    $pwdHashed = $uidExists['usersPwd'];
    // PHP function verifying passwords
    $checkPwd = password_verify($pwd, $pwdHashed);
    
    if ($checkPwd === false) {
        header('location: ../login.php?error=wronglogin');
        exit();
    } elseif ($checkPwd === true) {
        // creating sessions so that we can add content for users that already logged in
        session_start();
        $_SESSION['userid'] = $uidExists['usersId'];
        $_SESSION['useruid'] = $uidExists['usersUid'];
        header('location: ../profile.php');
        exit();
    }
}

// CONNECT profileImg AND users TABLES

function bindUserToImg($conn, $name, $username){
    // adding a row inside profileImg 
    $sql = "SELECT * FROM users WHERE usersUid = '$username' AND usersName = '$name'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userid = $row['usersId'];
            $sql = "INSERT INTO profileImg (profileImgUserid, profileImgFilename, status) VALUES ('$userid','', 1)";
            mysqli_query($conn, $sql);
            // header('Location: index.php');
        }
    } else {
        echo 'You have an error.';
    }
}

// CREATE USER SPECIFIC FOLDER AND TABLE
// TABLE IS UNNECEESARY!!! So we opted out of this solution

function createUserContentTableAndFolder($conn, $name, $username) {
    // creating user specific comntent table
    $sql = "SELECT * FROM users WHERE usersUid = '$username' AND usersName = '$name'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userid = $row['usersId'];

            if (!file_exists("../uploads/user$userid")) {
                mkdir("../uploads/user$userid", 0777, true);
            }


            // $tableName = "user" . $userid . "content";
            // $sql = "CREATE TABLE `$tableName` (userImgId int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL, userImgFilename varchar(256) NOT NULL)";
            // mysqli_query($conn, $sql);
            // // header('Location: index.php');

            // // creating user's content folder if it does not already exist
            // if (!file_exists("../uploads/user$userid")) {
            //     mkdir("../uploads/user$userid", 0777, true);
            // }
        }
    } else {
        echo 'You have an error.';
    }
}
