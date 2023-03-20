<?php

session_start();
include_once 'dbh.inc.php';

$id = $_SESSION['userid'];
// $fileNumber = 1;
$fileNumber = $_POST['submit'];

if ($fileNumber == 0) {
    $path = "../uploads/user" . $id . "/user" . $id . "_*.*";
    $allFiles = glob($path);
    foreach ($allFiles as $value) {
        // print_r($value);
        if (!unlink($value)) {
            echo "You have an error.";
        } else {
            echo "You have deleted the the file.";
        }
    }
    unset($value);

} else {
    $path = "../uploads/user" . $id . "/user" . $id . "_" . $fileNumber . ".*";
    $fileInfo = glob($path);
    $fileExt = explode(".", $fileInfo[0]);
    $fileActualExt = end($fileExt);

    $file = "../uploads/user" . $id . "/user" . $id . "_" . $fileNumber . "." . $fileActualExt;

    if (!unlink($file)) {
        echo "You have an error.";
    } else {
        echo "You have deleted a file.";
    }
}
header("Location: ../profile.php?deletesuccess#user-file-section");