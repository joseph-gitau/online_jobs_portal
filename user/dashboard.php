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
        <div class="jobs">
            <div class="header">
                <h2>Browse job listings</h2>
            </div>

            <?php
            include '../dbh.php';
            $sql = "SELECT * FROM job_post WHERE jp_status = 'active'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="card">
                        <div class="card-header">
                            <h3>' . $row['jp_title'] . '</h3>
                            <p>' . $row['jp_description'] . '</p>
                        </div>
                        <div class="card-body">
                            <div class="card-body-left">
                                <p>' . $row['jp_type'] . '</p>
                                <p>' . $row['jp_category'] . '</p>
                                <p>' . $row['jp_location'] . '</p>
                                <p>' . $row['jp_salary'] . '</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn" id="' . $row['jp_id'] . '"><i class="fas fa-phone"></i> Contact employer</a>
                        </div>
                    </div>
                    ';
                }
            }
            ?>
        </div>

    </div>

    <?php
    // include footer_scripts.php
    include '../partials/footer_scripts.php';
    ?>
</body>

</html>