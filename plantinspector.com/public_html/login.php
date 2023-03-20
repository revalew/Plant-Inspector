<?php
    include_once './header.php'
?>
<main>
    <div class="wrapper">
        <section class="signup-form">

            <h2>Log in</h2>

            <!-- post -> data is passed to next page but we can not see it in the url (we have sensitive data here so it is important) -->
            <form action="./includes/login.inc.php" method="post">

                <!-- name -> very important -->
                <!-- placeholder -> faded/blured text explaining what to type inside the textbox -->

                <!-- when profile image on the home (index) page is clicked user is transfered to log in page and his username is prefilled for him-->
                
                <!-- Ternary operator: -->
                <!-- Fetches the value of $_GET['uid'] or returns '' (empty) if it does not exist. Typically we assign it to variable that's why there is '=' at the beginning of the PHP tag instead of 'php'-->
                <input type="text" name="uid" placeholder="Username/Email..." 
                value="<?= isset($_GET["uid"])?$_GET["uid"]:"";?>">
                <input type="password" name="pwd" placeholder="Password...">
                <button type="submit" name="submit">Log in</button>
            </form>
            <?php

            // $_POST -> checking for data inside the url which we CAN NOT see
            // $_GET -> chechong fordata inside the url which we CAN see
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'emptyinput') {
                        echo '<p>Fill in all fields!</p>';
                    } elseif ($_GET['error'] == 'wronglogin') {
                        echo '<p>Wrong username or password!</p>';
                    }
                }
            ?>
        </section>
    </div>
</main>

<?php
    include_once './footer.php'
?>
