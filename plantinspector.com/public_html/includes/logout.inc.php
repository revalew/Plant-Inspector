<?php

// start the session because that is something we have to do to finnish it
session_start();
// unset all of the sessions variables
session_unset();
// destroy thesession
session_destroy();
// send user to different page after logging them out
header('location: ../index.php');
exit();