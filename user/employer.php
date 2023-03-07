<?php

// // if session is not started, start it

// if (!isset($_SESSION)) {
//     session_start();
// }
// // if $_SESSION['id'] and $_SESSION['username] is not set then redirect to login page with the page as referer page
// if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
//     $_SESSION['referer_page'] = $_SERVER['REQUEST_URI'];
//     header("Location: ../auth/login.php");
// } else {
//     $user_type = $_SESSION['user_type'];
//     $user_id = $_SESSION['user_id'];
//     /* echo $user_type;
//     echo $user_id; */
// }
/* unset($_SESSION['referer_page']);
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['user_type']); */
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
        <!-- open jobs -->
        <div class="open-jobs">

            <div class="card">
                <?php
                include '../dbh.php';
                $id = $_SESSION['user_id'];
                $sql = "SELECT * FROM job_post WHERE u_id = '$id'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                ?>
                <h3>Your currently open jobs</h3>
                <?php echo $resultCheck; ?> jobs
            </div>
            <!-- reccomedation -->
            <div class="card">
                <h3>Reccomendations</h3>
                <p>Best employee Reccomendations based on your job postings</p>
                <!-- employee recommendation cards -->
                <div class="employee-recommendation">
                    <?php
                    $sql2 = "SELECT * FROM job_post WHERE u_id = '$id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $resultCheck2 = mysqli_num_rows($result2);
                    if ($resultCheck2 > 0) {
                        // get job categories and store in array
                        $job_categories = array();
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $job_categories[] = $row['jp_category'];
                        }
                        // print_r($job_categories);
                        // search for keywords in job categories from q_cv qualification table and store id of matched keywords in array
                        $matched_keywords_id = array();
                        foreach ($job_categories as $job_category) {
                            $sql3 = "SELECT * FROM qualifications WHERE q_cv LIKE '%$job_category%'";
                            $result3 = mysqli_query($conn, $sql3);
                            $resultCheck3 = mysqli_num_rows($result3);
                            if ($resultCheck3 > 0) {
                                while ($row = mysqli_fetch_assoc($result3)) {
                                    $temparray = array();
                                    // check if id is already in array
                                    if (!in_array($row['q_id'], $matched_keywords_id)) {
                                        $temparray[] = $row['q_id'];
                                        $temparray[] = $row['u_id'];
                                        $temparray[] = $row['q_cv'];
                                        $temparray[] = $row['q_resume'];
                                        $matched_keywords_id[] = $temparray;
                                    }
                                }
                            }
                        }
                        // print_r($matched_keywords_id);
                        // echo matched keywords to script tag
                        echo "<script>var matched_keywords_id = " . json_encode($matched_keywords_id) . ";</script>";
                        // get user details from user table using id from matched_keywords_id array
                        $matched_users = array();
                        foreach ($matched_keywords_id as $matched_keyword_id) {
                            $sql4 = "SELECT * FROM users WHERE u_id = '$matched_keyword_id[1]'";
                            $result4 = mysqli_query($conn, $sql4);
                            $resultCheck4 = mysqli_num_rows($result4);
                            if ($resultCheck4 > 0) {
                                while ($row = mysqli_fetch_assoc($result4)) {
                                    $temparray = array();
                                    $temparray[] = $row['u_id'];
                                    $temparray[] = $row['u_name'];
                                    $temparray[] = $row['u_email'];
                                    $temparray[] = $row['u_phone'];
                                    // $temparray[] = $row['u_type'];
                                    $temparray[] = $row['u_county'];
                                    $temparray[] = $row['u_address'];
                                    $temparray[] = $row['u_gender'];
                                    $temparray[] = $row['u_m_status'];
                                    $tmpimage = $row['u_image'];
                                    if ($tmpimage == "") {
                                        $temparray[] = "default_profile.jpg";
                                    } else {
                                        $temparray[] = $row['u_image'];
                                    }
                                    $temparray[] = $row['u_status'];
                                    // $temparray[] = $row['u_created_at'];
                                    // $temparray[] = $row['u_updated_at'];
                                    $matched_users[] = $temparray;
                                }
                            }
                        }
                        // print_r($matched_users);
                        // echo matched users to script tag
                        echo "<script>var matched_users = " . json_encode($matched_users) . ";</script>";
                        // loop through matched_users array and display user details
                        foreach ($matched_users as $matched_user) {
                            // get q_cv from matched_keywords_id where u_id = $matched_user[0]
                            $matched_user_cv = "";
                            foreach ($matched_keywords_id as $matched_keyword_id) {
                                if ($matched_keyword_id[1] == $matched_user[0]) {
                                    $matched_user_cv = $matched_keyword_id[2];
                                }
                            }
                            echo "<div class='card'>
                            <div class='card-header'>
                                <div class='profile-img'>
                                    <img src='../resources/images/$matched_user[8]' alt='profile_image'>
                                </div>
                                <div class='profile-name'>
                                    <h4>$matched_user[1]</h4>
                                    <!-- <p>Web developer</p> -->
                                </div>
                            </div>
                            <div class='card-body'>
                                <p>
                                $matched_user_cv
                                </p>
                            </div>
                            <div class='card-footer'>
                                <a href='#user-view' rel='modal:open' id='$matched_user[0]' class='view-user-profile'>View profile</a>
                            </div>
                        </div>";
                        }
                    } else {
                        echo "No jobs posted";
                    }
                    ?>
                    <!-- <div class="card">
                        <div class="card-header">
                            <div class="profile-img">
                                <img src="../images/profile.png" alt="">
                            </div>
                            <div class="profile-name">
                                <h4>John Doe</h4>
                                <p>Web developer</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
                        </div>
                        <div class="card-footer">
                            <a href="">View profile</a>
                        </div>
                    </div> -->

                    <!-- nw -->
                    <!-- Modal HTML embedded directly into document -->
                    <div id="ex1" class="modal">
                        <p>Thanks for clicking. That felt good.</p>
                        <a href="#" rel="modal:close">Close</a>
                    </div>
                    <div id="user-view" class="modal">
                        <!-- view user profile details -->
                        <div class="view">
                            <h3>View user details</h3>
                            <div class="view-profile">
                                <div class="profile-img">
                                    <img id="vimage" src="../resources/images/default_profile.jpg" alt="profile_image">
                                </div>
                                <!-- <div class="profile-name">
                                    <h4>John Doe</h4>
                                    <p>Web developer</p>
                                </div> -->
                                <!-- Array ( [0] => Array ( [0] => 2 [1] => 1 [2] => php, java [3] => 1_An Empirical Study of Lookback Option Pricing.pdf ) [1] => Array ( [0] => 3 [1] => 1 [2] => php, java [3] => 1_An Empirical Study of Lookback Option Pricing.pdf ) ) Array ( [0] => Array ( [0] => 1 [1] => joseph gitau [2] => crosetsw09@gmail.com [3] => +254724772046 [4] => centra [5] => 10300, 10200 [6] => male [7] => single [8] => apple-touch-icon.png [9] => ) [1] => Array ( [0] => 1 [1] => joseph gitau [2] => crosetsw09@gmail.com [3] => +254724772046 [4] => centra [5] => 10300, 10200 [6] => male [7] => single [8] => apple-touch-icon.png [9] => ) ) -->
                                <div class="profile-details">
                                    <p><span id="vname">Name:</span></p>
                                    <p><a href="mailto:" id="vemail">Email: </a>
                                    <p><a href="tel:+" id="vphone">Phone: </a></p>
                                    <p><span id="vcounty">County: </span></p>
                                    <p><span id="vgender">Gender: </span></p>
                                    <p><span id="vmstatus">Marital status: </span></p>
                                    <p><span id="vaddress">Address: </span></p>
                                    <p><span id="vcv">CV: </span></p>
                                    <p><a href="#" id="vresume">Resume: </a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Link to open the modal -->
                    <!-- <p><a href="#ex1" rel="modal:open">Open Modal</a></p> -->
                    <!-- nw -->
                </div>
            </div>
        </div>
    </div>

    <?php
    // include footer_scripts.php
    include '../partials/footer_scripts.php';
    ?>

    <script>
        $('.view-user-profile').click(function() {
            // get this id
            var id = $(this).attr('id');
            console.log(id);
            // matched_users, matched_keywords_id
            // find user details from matched_users array
            var user_details = [];
            for (var i = 0; i < matched_users.length; i++) {
                if (matched_users[i][0] == id) {
                    user_details = matched_users[i];
                }
            }
            // find user cv from matched_keywords_id array
            var user_cv = [];
            for (var i = 0; i < matched_keywords_id.length; i++) {
                if (matched_keywords_id[i][1] == id) {
                    user_cv = matched_keywords_id[i];
                }
            }
            console.log(user_details);
            console.log(user_cv);
            // attach user details to view user modal
            $('#vimage').attr('src', '../resources/images/' + user_details[8]);
            $('#vname').text('Name: ' + user_details[1]);
            $('#vemail').text('Email: ' + user_details[2]);
            $('#vphone').text('Phone: ' + user_details[3]);
            $('#vcounty').text('County: ' + user_details[4]);
            $('#vgender').text('Gender: ' + user_details[6]);
            $('#vmstatus').text('Marital status: ' + user_details[7]);
            $('#vaddress').text('Address: ' + user_details[5]);
            $('#vcv').text('CV: ' + user_cv[2]);
            $('#vresume').attr('href', '../resources/resumes/' + user_cv[3]);


        });
    </script>
</body>

</html>