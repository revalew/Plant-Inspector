

<?php

session_start();
include_once 'dbh.inc.php';

$id = $_SESSION['userid'];

if (isset($_POST['submit'])) {
    
    // $_FILES -> superglobal gets all the information from the file taht we want to upload from the input form
    // name inside brackets [] is set to file because we used it as a name inside of our <input>
    $file = $_FILES['file'];

    // get all the information about the file
    // could also be done as $fileName = $file['name'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    // check the extension of the file we try to upload
    // explode -> separate a string - here we set the explode point at the period sign so we can separate the extension from the name
    $fileExt = explode('.', $fileName);
    // always set the ext to lowercase before checking it
    $fileActualExt = strtolower(end($fileExt));
    
    // declare what formats are allowed
    //$allowed = array('jpg', 'jpeg', 'png', 'pdf');
    $allowed = array('jpg', 'jpeg', 'png');

    // check if the extension of the uploaded file is one of the allowed extensions
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) {
                // file size less then 5 000 000 B (BYTE) => 5 MB

                // find photo with max number and add 1 to it
                $directory = "../uploads/user" . $id . "/user" . $id . "_*.*";
                $fileCount = count(glob($directory));
                $allFiles = glob($directory);
                if ($fileCount > 0) {
                    $fileNew = 0;
                    foreach ($allFiles as $value) {
                        $value = explode("_", $value);
                        $value = explode(".", $value[1]);
                        $value = $value[0];
                        if ($value >= $fileNew) {
                            $fileNew = $value + 1;
                        }
                    }
                    unset($value);
                } else {
                    $fileNew = 1;
                }

                $fileNameNew = "user" . $id . '_' . $fileNew . "." . $fileActualExt;
                $fileDestination = '../uploads/user' . $id . '/' . $fileNameNew;

                move_uploaded_file($fileTmpName, $fileDestination);

                // // Increment file name by 1
                // $num = 1;
                // $fileNameNew = "user" . $id . '_' . $num . "." . $fileActualExt;
                // $fileDestination = '../uploads/user' . $id . '/' . $fileNameNew;
                // while (file_exists('../uploads/user' . $id . '/' . $fileNameNew)) {
                //     $num++;
                //     $fileNameNew = "user" . $id . '_' . $num . "." . $fileActualExt;
                //     $fileDestination = '../uploads/user' . $id . '/' . $fileNameNew;
                // }

                // function that actually moves the file from tmp location to our uploads folder
                // move_uploaded_file($fileTmpName, $fileDestination);

                // $tableName = "user" . $id . "content";
                // $sql = "INSERT INTO `$tableName` (userImgFilename) VALUES ('$fileNameNew');";
                // // $sql = "UPDATE profileImg SET profileImgFilename='$fileNameNew', status=0 WHERE profileImgUserid='$id';";
                // $result = mysqli_query($conn, $sql);

                header('Location: ../profile.php?uploadsuccessful#user-file-section');
            }
            else {
                echo 'Your file is too big!';
            }
        } else {
            echo 'There was an error uploading your file!';
        }
    } else {
        header('Location: ../profile.php?uploadfailed');
        echo 'You cannot upload files of this type!';
    }

}
