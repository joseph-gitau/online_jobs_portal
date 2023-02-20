<?php
// if seession is not started, start it

if (!isset($_SESSION)) {
    session_start();
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
    <div class="header">
        <h2>online jobs portal Register</h2>
    </div>

    <form method="post" action="../reg_exe.php">
        <?php
        include '../reg_exe.php';
        // if $_session[$errors] is set, display it
        if (isset($_SESSION['errors'])) {
            // loop through the errors
            foreach ($_SESSION['errors'] as $error) {
                echo "<p class='error'>" . $error . "</p>";
            }
            // unset the errors
            unset($_SESSION['errors']);
        }
        ?>
        <div class="input-group">
            <label>Full name</label>
            <input type="text" name="name" value="">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" value="">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm password</label>
            <input type="password" name="password_2">
        </div>
        <!-- role -->
        <div class="input-group">
            <label>Role</label>
            <select name="role" class="chosen-select">
                <option value="jobseeker">Jobseeker</option>
                <option value="employer">Employer</option>
            </select>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="register_user">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
</body>

</html>