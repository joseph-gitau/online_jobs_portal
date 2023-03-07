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
                    $attachment = $row['jp_image'];
                    $emp_id = $row['u_id'];
                    echo '
                    <div class="card">
                        <div class="card-header">
                            <h3 class="title">' . $row['jp_title'] . '</h3>
                            <p class="txt-desc">' . $row['jp_description'] . '</p>
                        </div>
                        <div class="card-body">
                            <div class="card-body-left">
                                <p>' . $row['jp_type'] . '</p>
                                <p>' . $row['jp_category'] . '</p>
                                <p>' . $row['jp_location'] . '</p>
                                <p>' . $row['jp_salary'] .
                        '</p>
                            </div>
                        </div>
                        <div class="attachments">
                            <h3>Attachments</h3>';
                    if ($attachment != '') {
                        echo '
                        <ul>
                            <li><a href="../resources/jobps/' . $attachment . '" target="_blank">' . $attachment . '</a></li>
                        </ul>
                        ';
                    } else {
                        echo '
                        <p>No attachments</p>
                        
                        ';
                    }

                    echo '</div>
                        <div class="card-footer">
                            <a href="#message" rel="modal:open" class="btn contact-employer" id="' . $emp_id . '" jpid="' . $row['jp_id'] . '"><i class="fas fa-phone"></i> Contact employer</a>
                        </div>
                    </div>
                    ';
                }
            }
            ?>
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
                    <input type="hidden" name="emp_id" id="emp_id">
                    <!-- msg title -->
                    <div class="form-control">
                        <label for="msg_title">Message title</label>
                        <input type="text" name="msg_title" id="msg_title" placeholder="Message title" required>
                        <input type="hidden" name="msg_id" id="msg_id">
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

    <?php
    // include footer_scripts.php
    include '../partials/footer_scripts.php';
    ?>

    <script>
        $(".contact-employer").click(function() {
            // get this id
            var emp_id = $(this).attr("id");
            // set this id to hidden input
            $("#emp_id").val(emp_id);
            // console.log(emp_id); 
            // get job title
            var job_title = $(this).parent().parent().find(".title").text();
            // console.log(job_title);
            // set job title to msg_title
            $("#msg_title").val(job_title);
            // get attribute jpid
            var job_id = $(this).attr("jpid");
            // console.log(job_id);
            $("#msg_id").val(job_id);
        });
    </script>
</body>

</html>