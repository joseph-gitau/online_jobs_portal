<?php
if (!isset($_SESSION)) {
    session_start();
}
// get user type from  $_SESSION['user_type']
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];
    // if user type is 2 then redirect to user dashboard
    if ($user_type == 2) {
        header("Location: ../user/dashboard.php");
    } else {
        // if user type is 3 then redirect to employer dashboard
        header("Location: ../user/employer.php");
    }
}
