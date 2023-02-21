<?php
/* unset($_SESSION['referer_page']);
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['user_type']); */
// if session is not set then start session
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
}
if ($user_type == 2) {

?>

    <nav>
        <!-- logo -->
        <div class="logo">
            <a href="../user/dashboard.php">Online jobs portal</a>
        </div>
        <!-- search -->
        <div class="search">
            <form action="search.php" method="GET">
                <input type="text" name="search" placeholder="Search a job">
                <button type="submit">Search</button>
            </form>
        </div>
        <ul>
            <li><a href="index.php">Browse jobs</a></li>
            <li><a href="jobseeker/login.php">Employers</a></li>
            <li><a href="auth/register.php">Messages</a></li>
            <li><a href="../user/profile.php" id="profile-u">Profile</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>
        </ul>
    </nav>
<?php  } else { ?>
    <nav>
        <!-- logo -->
        <div class="logo">
            <a href="index.php">Online jobs portal</a>
        </div>
        <!-- search -->
        <div class="search">
            <form action="search.php" method="GET">
                <input type="text" name="search" placeholder="Search a job or a talent">
                <button type="submit">Search</button>
            </form>
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="jobseeker/login.php">Job seekers</a></li>
            <li><a href="employer/login.php">Employers</a></li>
            <li><a href="auth/register.php">Register</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
<?php } ?>
<script>
    $('#profile-ux').click(function() {
        event.preventDefault();
        var current_effect = 'slide';
        run_waitMe(current_effect);
        // console.log('clicked');
        // get profile.php page contents and display it in the #container div
        $.ajax({
            url: 'profile.php',
            type: 'GET',
            success: function(data) {
                $('#container').html(data);
            }
        });
    });
</script>