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
    <title>online jobs portal - Profile</title>

</head>

<body>
    <header>
        <?php
        // include header.php
        include '../partials/header.php';
        ?>
    </header>
    <div class="container" id="container">
        <div class="container" id="container">
            <div class="jobs">
                <div class="header">
                    <h2>Contact/message job seekers</h2>
                </div>
                <!-- list all job seekers -->
                <div class="jobseeker-list">
                    <?php
                    include '../dbh.php';
                    $sql = "SELECT * FROM users WHERE role_id = 2";
                    $result = mysqli_query($conn, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $image = $row['u_image'];
                            $name = $row['u_name'];
                            $email = $row['u_email'];
                            if ($image == "") {
                                $image = "default_profile.jpg";
                            }
                            $c_uid = $row['u_id'];
                            // get cv, resume from qualifications table
                            $sql2 = "SELECT * FROM qualifications WHERE u_id = '$c_uid'";
                            $result2 = mysqli_query($conn, $sql2);
                            $resultCheck2 = mysqli_num_rows($result2);
                            if ($resultCheck2 > 0) {
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    $cv = $row2['q_cv'];
                                    $resume = $row2['q_resume'];
                                }
                            } else {
                                $cv = "";
                                $resume = "";
                            }
                            echo '
                            <div class="jobseeker-card">
                            <!-- include name, image, address, email, location, cv, message button -->
                            <div class="jobseeker-card-header">
                                <div class="jobseeker-card-header-left">
                                    <img src="../resources/images/' . $image . '" alt="' . $row['u_name'] . ' avatar">
                                    <div class="jobseeker-card-header-left-info">
                                        <h3 class="jobseeker-card-header-left-info-name">' . $row['u_name'] . '</h3>
                                        <p class="jobseeker-card-header-left-info-address">' . $row['u_address'] . '</p>
                                        <p class="jobseeker-card-header-left-info-email">
                                            <a href="mailto:" class="jobseeker-card-header-left-info-email-link">
                                                <i class="fas fa-envelope"></i> ' . $row['u_email'] . '
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <!-- cv and resume -->
                                <div class="jobseeker-card-header-rights">
                                    <p>
                                        ' . $cv . '
                                    </p>
                                </div>
                                <!-- message button -->
                                <div class="jobseeker-card-header-right">
                                <a href="../resources/resumes/' . $resume . '" target="_blank" class="btn btn-primary">Download Resume</a>
                                    <a href="#message" rel="modal:open" class="btn btn-primary">Message</a>
                                </div>
                            </div>
                        </div>
                            ';
                        }
                    } else {
                        echo "No job seekers found";
                    }
                    ?>
                    <!-- <div class="jobseeker-card">
                        <div class="jobseeker-card-header">
                            <div class="jobseeker-card-header-left">
                                <img src="../resources/images/avatars/avatar-1.png" alt="avatar">
                                <div class="jobseeker-card-header-left-info">
                                    <h3 class="jobseeker-card-header-left-info-name">John Doe</h3>
                                    <p class="jobseeker-card-header-left-info-address">Kathmandu, Nepal</p>
                                    <p class="jobseeker-card-header-left-info-email">
                                        <a href="mailto:" class="jobseeker-card-header-left-info-email-link">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="jobseeker-card-header-rights">
                                <p>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam deleniti doloribus soluta illo ad, harum voluptas aspernatur adipisci quae dicta. Tempore ad, modi quisquam facere illum provident nihil ea tempora!
                                </p>
                                <a href="#" class="btn btn-primary">Download Resume</a>
                            </div>
                            <div class="jobseeker-card-header-right">
                                <a href="#message" rel="modal:open" class="btn btn-primary">Message</a>
                            </div>
                        </div>
                        
                    </div> -->
                    <!-- nw -->
                </div>
            </div>
            <!-- nw -->
            <!-- message modal -->
            <div class="message modal" id="message">
                <!-- msg employer regarding -->
                <div class="header">
                    <h3 class="msg-dny-hd"></h3>
                </div>
                <div class="body">
                    <form action="../reg_exe.php" method="post" enctype="multipart/form-data">
                        <!-- hidden employer id -->
                        <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <!-- msg title -->
                        <div class="form-control">
                            <label for="msg_title">Message title</label>
                            <input type="text" name="msg_title" id="msg_title" placeholder="Message title" required>
                            <input type="hidden" name="msg_id" id="msg_id" value="<?php echo rand(); ?>">
                        </div>
                        <!-- msg body -->
                        <div class="form-control">
                            <label for="msg_body">Message body</label>
                            <textarea name="msg_body" id="msg_body" cols="30" rows="10" placeholder="Message body" required></textarea>
                        </div>
                        <!-- msg attachment -->
                        <div class="form-control">
                            <label for="msg_attachment">Message attachment</label>
                            <input type="file" name="msg_attachment" id="msg_attachment">
                        </div>
                        <!-- msg submit -->
                        <div class="form-control msg_submit">
                            <input type="submit" name="msg_submit" id="msg_submit" class="btn" value="Send message">
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
    <!-- nw -->
    <!-- Modal HTML embedded directly into document -->
    <div id="ex1" class="modal">
        <p>Thanks for clicking. That felt good.</p>
        <a href="#" rel="modal:close">Close</a>
    </div>

    <?php
    // include footer_scripts.php
    include '../partials/footer_scripts.php';
    ?>
</body>

</html>