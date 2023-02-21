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

    <?php
    // include header_links.php
    include '../partials/header_links.php';
    ?>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h2>OPIMS Login</h2>
    </div>

    <form method="post" action="../reg_exe.php">

        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" id="username">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" id="login" name="login_user">Login</button>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>

    <?php
    // include footer_scripts.php
    include '../partials/footer_scripts.php';
    ?>

    <script>
        <?php
        // echo $_SESSION['referer_page   '] in js variable
        if (isset($_SESSION['referer_page'])) {
            echo "var referer_page = '" . $_SESSION['referer_page'] . "';";
        } else {
            echo "var referer_page = 'index.php';";
        }
        ?>
    </script>
</body>

</html>