

<?php
//<!-- we are going to upload files to our root folder in which we created a folder named uploads. Each user gets separate folder for all their photos -->;

session_start();
include_once './dbh.inc.php';

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
    // $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    $allowed = array('jpg', 'jpeg', 'png');

    // check if the extension of the uploaded file is one of the allowed extensions
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) {
                // file size less then 5 000 000 B (BYTE) => 5 MB
                $fileNameNew = "user" . $id . "." . $fileActualExt;
                $fileDestination = '../uploads/user' . $id . '/' . $fileNameNew;
                //print_r($fileTmpName);

                // function that actually moves the file from tmp location to our uploads folder
                move_uploaded_file($fileTmpName, $fileDestination);
                // $sql = "INSERT INTO img (imgFilename) VALUES ('$fileNameNew');
                $sql = "UPDATE `profileImg` SET `profileImgFilename` = '$fileNameNew', `status` = 0 WHERE `profileImgUserid` = '$id';";
                $result = mysqli_query($conn, $sql);
                header('Location: ../profile.php?uploadsuccessful');
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
