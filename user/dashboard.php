<?php

// if session is not started, start it

if (!isset($_SESSION)) {
    session_start();
}
// if $_SESSION['id'] and $_SESSION['username] is not set then redirect to login page with the page as referer page
if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    $_SESSION['referer_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.php");
} else {
    $user_type = $_SESSION['user_type'];
    $user_id = $_SESSION['user_id'];
    /* echo $user_type;
    echo $user_id; */
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php
    // include header_links.php
    include '../partials/header_links.php';
    ?>
    <title>online jobs portal Register</title>

</head>

<body>
    <header>
        <?php
        // include header.php
        include '../partials/header.php';
        ?>
    </header>
    <div class="container" id="container">
        <div class="header">
            <h2>online jobs portal Register</h2>
        </div>

        <form method="post" action="../reg_exe.php" id="register_form">
            <div class="input-group">
                <label>Full name</label>
                <input type="text" name="name" id="name" value="">
            </div>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" id="username" value="">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" id="email" value="">
            </div>
            <div class="input-group">
                <label>Phone</label>
                <input type="text" name="phone" id="phone" value="">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1" id="password_1">
            </div>
            <div class="input-group">
                <label>Confirm password</label>
                <input type="password" name="password_2" id="password_2">
            </div>
            <!-- role -->
            <div class="input-group">
                <label>Role</label>
                <select name="role" class="chosen-select" id="role">
                    <option value="jobseeker">Jobseeker</option>
                    <option value="employer">Employer</option>
                </select>
            </div>
            <div class="input-group">
                <button type="submit" class="btn register_user" id="register_user" name="register_user">Register</button>
            </div>
            <p>
                Already a member? <a href="login.php">Sign in</a>
            </p>
        </form>
    </div>

    <?php
    // include footer_scripts.php
    include '../partials/footer_scripts.php';
    ?>
</body>

</html>