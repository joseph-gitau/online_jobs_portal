<?php
// if session is not started, start it
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - Online Patient Information Management System (OPIMS):</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h2>OPIMS Login</h2>
    </div>

    <form method="post" action="../reg_exe.php">
        <?php
        // if session msg is set, display it
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            // unset the session msg
            unset($_SESSION['msg']);
            // if session errors is set, display it
            if (isset($_SESSION['errors'])) {
                // loop through the errors
                foreach ($_SESSION['errors'] as $error) {
                    echo "<p class='error'>" . $error . "</p>";
                }
                // unset the errors
                unset($_SESSION['errors']);
            }
        }
        ?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="login_user">Login</button>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>
</body>

</html>