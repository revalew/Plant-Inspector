<?php
    include_once 'header.php'
?>
<main>
    <div class="wrapper">
        <section class="signup-form">

            <h2>Sign up</h2>

            <!-- post -> data is passed to next page but we can not see it in the url (we have sensitive data here so it is important) -->
            <form action="./includes/signup.inc.php" method="post">

                <!-- name -> very important (super global variable ??)-->
                <!-- placeholder -> faded/blured text explaining what to type inside the textbox -->
                <input type="text" name="name" placeholder="Full name...">
                <input type="text" name="email" placeholder="Email...">
                <input type="text" name="uid" placeholder="Username...">
                <input type="password" name="pwd" placeholder="Password...">
                <input type="password" name="pwdrepeat" placeholder="Repeat password...">
                <button type="submit" name="submit">Sign Up</button>
            </form>


            <?php


            // $_POST -> checking for data inside the url which we CAN NOT see
            // $_GET -> chechong fordata inside the url which we CAN see
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'emptyinput') {
                        echo '<p>Fill in all fields!</p>';
                    } elseif ($_GET['error'] == 'invaliduid') {
                        echo '<p>Choose a proper username!</p>';
                    } elseif ($_GET['error'] == 'invalidemail') {
                        echo '<p>Choose a proper email!</p>';
                    } elseif ($_GET['error'] == 'passworddontmatch') {
                        echo "<p>Passwords don't match!</p>";
                    } elseif ($_GET['error'] == 'usernametaken') {
                        echo '<p>This username is already taken!</p>';
                    } elseif($_GET['error'] == 'stmtfailed') {
                        echo '<p>Something went wrong, try again!</p>';
                    } elseif($_GET['error'] == 'none') {
                        echo '<p>You have signed up!</p>';
                        echo '<p>Now you can log in <a href="login.php">here</a>.</p>';
                    }
                }
            ?>

        </section>
    </div>
</main>

<?php
    include_once 'footer.php'
?>
