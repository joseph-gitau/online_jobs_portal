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
                <h2>Your messages</h2>
            </div>
            <!-- nw -->
            <div class="message-container">
                <div class="left">
                    <div class="message-list">
                        <h3>Chats</h3>
                        <?php
                        include '../dbh.php';
                        $uid = $_SESSION["user_id"];
                        // echo $uid;
                        $sql = "SELECT * FROM messages WHERE u_id = '$uid'";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        if ($resultCheck > 0) {
                            // get employer id
                            // array to store unique data
                            $data = array();
                            while ($row = mysqli_fetch_assoc($result)) {
                                $temp_array = array();
                                $emp_id = $row['emp_id'];
                                $msg_id = $row['jp_id'];
                                $temp_array['emp_id'] = $emp_id;
                                $temp_array['msg_id'] = $msg_id;
                                $data[] = $temp_array;
                            }
                            // print_r($data);
                            // get unique data
                            $unique_data = array_map("unserialize", array_unique(array_map("serialize", $data)));
                            // print_r($unique_data);
                            // loop through unique data and get employer name
                            foreach ($data as $row) {
                                // access each column value using the column name as the key
                                $emp_id = $row['emp_id'];
                                $msg_id = $row['msg_id'];
                                // get employer name and image from user table
                                $sql2 = "SELECT * FROM users WHERE u_id = '$emp_id'";
                                $result2 = mysqli_query($conn, $sql2);
                                $resultCheck2 = mysqli_num_rows($result2);
                                if (
                                    $resultCheck2 > 0
                                ) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $emp_name = $row2['u_name'];
                                        $emp_image = $row2['u_image'];
                                        if ($emp_image == "") {
                                            $emp_image = "default_profile.jpg";
                                        }

                                        echo '
                                        <div class="list">
                                            <div class="list-icon">
                                                <img src="../resources/images/' . $emp_image . '" alt="user">
                                            </div>
                                            <div class="list-name">
                                                <h3><a href="#" class="view-msg-deft" id="' . $msg_id . '">' . $emp_name . '</a></h3>
                                            </div>
                                        </div>
                                        ';
                                    }
                                }
                            }
                        } else {
                            echo '<h3>No messages</h3>';
                            // echo script to remove the view message title
                        }
                        ?>
                        <!-- list user with icon and name -->
                        <!-- <div class="list">
                            <div class="list-icon">
                                <img src="../resources/images/default_profile.jpg" alt="user">
                            </div>
                            <div class="list-name">
                                <h3><a href="#">John Doe</a></h3>
                            </div>
                        </div> -->
                        <!-- nw -->
                        <!-- <div class="list mactive">
                            <div class="list-icon">
                                <img src="../resources/images/default_profile.jpg" alt="user">
                            </div>
                            <div class="list-name">
                                <h3>John Doe</h3>
                            </div>
                        </div> -->
                        <!-- nw -->

                    </div>
                </div>
                <div class="right">
                    <div class="message-body">
                        <h3 class="message-title-auto">Message list title</h3>
                        <div class="msg-content">
                            <div class="text-cont-view">
                                <!-- <p class="other"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium facilis, dicta alias dolorum necessitatibus sapiente reiciendis hic molestiae sit itaque, harum facere consectetur sequi sed quam veritatis inventore, obcaecati iure.</p>
                                <p class="self"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium facilis, dicta alias dolorum necessitatibus sapiente reiciendis hic molestiae sit itaque, harum facere consectetur sequi sed quam veritatis inventore, obcaecati iure.</p> -->
                            </div>

                            <!-- form to send a new message -->
                            <form action="../reg_exe.php" method="post">
                                <div class="form-control">
                                    <!-- // hidden input to store job post id -->
                                    <input type="hidden" name="msg_id" id="msg_id">
                                    <!-- // hidden input to store employer id -->
                                    <input type="hidden" name="emp_id" id="emp_id">
                                    <!-- hidden input for subject -->
                                    <input type="hidden" name="msg_subject" id="msg_subject" value="">
                                    <textarea name="msg_body" id="msg_body" cols="30" rows="10" placeholder="Write a message" required></textarea>
                                </div>
                                <!-- msg submit -->
                                <div class="form-control msg_submit">
                                    <!-- button to send message -->
                                    <button type="submit" name="msg_submit" id="msg_submit">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
</body>

</html>