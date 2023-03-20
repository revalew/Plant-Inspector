<?php
    include 'header.php'
?>
<main>
    <div class="wrapper">
    <?php
        if (isset($_SESSION['userid'])) {

            echo '<div class="greetings">';
            echo '<h1>Hello there, ' . $_SESSION['useruid'] . '!</h1>';
            echo "<p>You are logged in as user #".$_SESSION['userid']."</p>";
            echo '<p>Good to see you again.</p>';
            echo '</div>';
            
            $sql = "SELECT * FROM users WHERE usersId = ".$_SESSION['userid'].";";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<h2>Your profile:</h2>";
                echo "<div class='users-container'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['usersId'];
                    $sqlImg = "SELECT * FROM profileImg WHERE profileImgUserid = '$id'";
                    $resultImg = mysqli_query($conn, $sqlImg);
                    while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        echo "<div class='user-container'>";
                        if ($rowImg['status'] == 0) {
                                // to make shure the browser loads the new image right after we change it we add "?" after .jpg and random number
                                
                                // profile image can be viewed in fullscreen
                                $x = 'if(document.fullscreenElement){document.exitFullscreen();window.scrollTo({top: document.getElementById("user-file-section").offsetTop})} else {this.requestFullscreen()}';
                                echo "<img class='photo' onclick='$x' src='./uploads/user" . $id . '/' . $rowImg['profileImgFilename'] . "?". mt_rand() . "'>";

                                // profile image can not be seen in fullscreen
                                // echo "<img src='./uploads/user" . $id . '/' . $rowImg['profileImgFilename'] . "?". mt_rand() . "'>";
                                echo "<p>".$row['usersUid']."</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='users-container'>";
                            echo "<div class='user-container'>";
                                // enable file upload -> upload the profile picture
                                echo '<div class="upload">';
                                echo '<p>You can upload your profile picture here:</p>';
                                // enctype specifies the way to encode our data in forms
                                echo '<form action="./includes/uploadPfp.inc.php" method="POST" enctype="multipart/form-data">
                                <input type="file" name="file">
                                <button type="submit" name="submit">upload</button>
                                </form>';
                                echo '</div>';
                            echo "</div>";
                            echo "<div class='user-container'>";
                                // delete uploaded profile image and set it to default
                                echo '<div class="upload">';
                                echo '<p>You can delete your profile picture here:</p>';
                                echo '<form action="./includes/deletePfp.inc.php" method="POST">
                                <button type="submit" name="submit">delete profile image</button>
                                </form>';
                                echo "</div>";
                            echo '</div>';
                        echo "</div>";
                        } else {
                                echo "<img src='./uploads/defaultProfilePicture.png'>";
                                echo "<p>".$row['usersUid']."</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class='users-container'>";
                            echo "<div class='user-container'>";
                                // enable file upload -> upload the profile picture
                                echo '<div class="upload">';
                                echo '<p>You can upload your profile picture here:</p>';
                                // enctype specifies the way to encode our data in forms
                                echo '<form action="./includes/uploadPfp.inc.php" method="POST" enctype="multipart/form-data">
                                <input type="file" name="file">
                                <button type="submit" name="submit">upload</button>
                                </form>';
                                echo '</div>';
                            echo "</div>";
                        echo "</div>";
                        }
                    }
                }
            } else {
                echo '<p class="users-info">There are no users yet...</p>';
            }
            
            echo '<hr>';
            // enable file upload
            echo '<div class="upload" id="user-file-section">';
                echo '<p>You can upload your files below:</p>';
                echo '<p style="font-size: 12px">(Each file has to be uploaded separately).</p>';
                // enctype specifies the way to encode our data in forms
                echo '<form action="./includes/uploadFile.inc.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="file">
                <button type="submit" name="submit">upload</button>
                </form>';
            echo '</div>';

                    
            // display files uploaded by user
            $directory = "./uploads/user" . $_SESSION['userid'] . "/user" . $_SESSION['userid'] . "_*.*";
            $fileCount = count(glob($directory));
            // print_r($fileCount);
            // echo "<br>";
            $allFiles = glob($directory);
            // print_r($allFiles);
            // echo "<br>";
            // $allFiless = explode("_", $allFiles[0]);
            // print_r($allFiless);
            // echo "<br>";
            // $allFiless = explode(".", $allFiless[1]);
            // print_r($allFiless);
            // echo "<br>";
            // print_r($allFiless[0]);

            
            if ($fileCount > 0) {
                if ($fileCount === 1) {
                    echo "<h2 class='user-files'>You have uploaded $fileCount file. Here it is:</h2>";
                } else {
                    echo "<h2 class='user-files'>You have uploaded $fileCount files. Here they are:</h2>";
                }
                echo "<p class='user-files-text'>(You can see them in full screen when you click on them.)</p>";
                echo "<div class='users-container'>";
                    foreach ($allFiles as $value) {
                        // print_r($value);
                        // echo "<br>";
                        echo "<div class='user-container'>";
                        $x = 'if(document.fullscreenElement){document.exitFullscreen();window.scrollTo({top: document.getElementById("user-file-section").offsetTop})} else {this.requestFullscreen()}';
                        $y = 'location.href = "#user-file-section";';
                        $xy = 'if(document.fullscreenElement){document.exitFullscreen(), location.href = "#user-file-section";} else {this.requestFullscreen()}';
                        // window.scrollTo({top: document.getElementById("user-file-section").offsetTop})
                        // document.getElementById("user-file-section").scrollIntoView()
                        // why is it not scrolling ;-;

                            echo "<img onclick='$xy' class='photo' src='" . $value . "?". mt_rand() . "'>";
                            // echo "</div>";
                            $value = explode("_", $value);
                            // print_r($value);
                            // echo "<br>";
                            $value = explode(".", $value[1]);
                            // print_r($value);
                            // echo "<br>";
                            $value = $value[0];
                            // print_r($value);
                            // echo "<br>";
                            echo '<div class="delete">';
                                    //echo '<p>You can delete this picture by pressing the button below:</p>';
                                    echo '<form action="./includes/deleteFile.inc.php" method="POST">
                                    <button type="submit" name="submit" value="'.$value.'">delete this file</button>
                                    </form>';
                            echo '</div>';
                                
                        echo "</div>";
                        
                        // echo "<div class='user-container'>";
                        // // path to image
                        // $path = "./uploads/user" . $_SESSION['userid'] . "/user" . $_SESSION['userid'] . "_" . $value . ".*";
                        // $fileInfo = glob($path);
                        // $fileExt = explode(".", $fileInfo[0]);
                        // $fileActualExt = end($fileExt);
                        // $file = "./uploads/user" . $_SESSION['userid'] . "/user" . $_SESSION['userid'] . "_" . $value . "." . $fileActualExt;
                        
                        // // show the image
                        // echo "<img src='$file'>";
                        
                        // // assign values to each delete button
                        // echo '<div class="delete">';
                        //         echo '<p>You can delete this picture by pressing the button below:</p>';
                        //         echo '<form action="includes/deleteFile.inc.php" method="POST">
                        //         <button type="submit" name="submit" value="'.$value.'">delete file</button>
                        //         </form>';
                        //         echo '</div>';
                                
                        // echo "</div>";
                            
                    }
                echo "</div>";
                    
                unset($value);

                echo "<hr>";
                echo "<div class='users-container'>";
                    echo "<div class='user-container'>";
                        echo '<div class="delete">';
                        echo '<p class="caution">PROCEED WITH CAUTION. THIS  OPERATION <strong>CAN NOT</strong> BE REVERTED!</p>';
                        echo '<p>You can delete <strong>ALL</strong> pictures by pressing the button below:</p>';
                                echo '<form action="./includes/deleteFile.inc.php" method="POST">
                                <button type="submit" name="submit" value="0" onclick="return confirm('."'\\n\\n\\n\\nAre you sure you want to delete ALL the files?\\n\\n'".');">delete <strong>ALL</strong> files</button>
                                </form>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
    
            } else {
                echo "<h2 class='user-files'>Nothing to show. You have not uploaded any files yet. You can change that using the form above.</h2>";
            }
            
        } else {
            echo '<div class="greetings">';
            echo '<h1 class="warrning">You are not logged in!</h1>';
            echo '<p>If you do not have an account you can sign up <a href="signup.php">here</a>.</p>';
            echo '<p>If you already have an account you can log in <a href="login.php">here</a>.</p>';
            echo '</div>';
        }
    ?>
    </div>
</main>
<?php
    include_once 'footer.php'
?>
