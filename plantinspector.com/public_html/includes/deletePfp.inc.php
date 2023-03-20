<?php

session_start();
include_once 'dbh.inc.php';

$id = $_SESSION['userid'];

// does not aply to our project as we have user specific directories and we use ".*" instead of just "*" in the $fileName so it is for ilustrative purposes only
// code to find the file we do not know the extension of
$fileName = "../uploads/user" . $id . "/user" . $id . ".*";
// glob -> goes and searches for a specific file we have the name for
$fileInfo = glob($fileName);
$fileExt = explode(".", $fileInfo[0]);
$fileActualExt = end($fileExt);

$file = "../uploads/user" . $id . "/user" . $id . "." . $fileActualExt;
//$file = chmod($file, 0777);
print_r($file);

// unlink() -> goes in and deletes the file
if (!unlink($file)) {
    // if the file could not be deleted -> error
    echo "File was not deleted.";
} else {
    echo "File was deleted.";
}

$sql = "UPDATE `profileImg` SET `status` = 1, `profileImgFilename` = '' WHERE `profileImgUserid` = '$id';";
mysqli_query($conn, $sql);header("Location: ../profile.php?deletesuccess");
