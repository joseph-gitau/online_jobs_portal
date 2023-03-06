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
        <!-- nw -->
        <div class="profile">
            <form action="../reg_exe.php" method="POST" enctype="multipart/form-data">
                <?php
                include '../dbh.php';

                $sql = "SELECT * FROM users WHERE u_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $name = $row['u_name'];
                $username = $row['u_username'];
                $email = $row['u_email'];
                $phone = $row['u_phone'];
                $county = $row['u_county'];
                $address = $row['u_address'];
                $gender = $row['u_gender'];
                $marital_status = $row['u_m_status'];
                $dob = $row['u_dob'];
                $image = $row['u_image'];
                if ($image == "") {
                    $image = "default_profile.jpg";
                }

                ?>
                <!-- header -->
                <div class="header">
                    <h2>Profile settings</h2>
                </div>
                <!-- name -->
                <div class="form-control">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your name" value="<?php echo $name; ?>">
                </div>
                <!-- username -->
                <div class="form-control">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" disabled value="<?php echo $username; ?>">
                </div>
                <!-- email -->
                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo $email; ?>">
                </div>
                <!-- phone -->
                <div class="form-control">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" placeholder="Enter your phone" value="<?php echo $phone; ?>">
                </div>
                <!-- county -->
                <div class="form-control">
                    <label for="county">County</label>
                    <input type="text" name="county" id="county" placeholder="Enter your county" value="<?php echo $county; ?>">
                </div>
                <!-- address -->
                <div class="form-control">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" placeholder="Enter your address" value="<?php echo $address; ?>">
                </div>
                <!-- gender -->
                <div class="form-control">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="chosen-select">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <!-- marital status -->
                <div class="form-control">
                    <label for="marital_status">Marital Status</label>
                    <select name="marital_status" id="marital_status" class="chosen-select">
                        <option value="single" <?php if ($marital_status == 'single') echo 'selected'; ?>>Single</option>
                        <option value="married" <?php if ($marital_status == 'married') echo 'selected'; ?>>Married</option>
                        <option value="divorced" <?php if ($marital_status == 'divorced') echo 'selected'; ?>>Divorced</option>
                        <option value="widowed" <?php if ($marital_status == 'windowed') echo 'selected'; ?>>Widowed</option>
                    </select>
                </div>
                <!-- dob -->
                <div class="form-control">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" value="<?php echo $dob; ?>">
                </div>
                <!-- image -->
                <div class="preview">
                    <img id="profile_pic_preview" src="../resources/images/<?php echo $image; ?>">
                </div>
                <div class="form-control">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" onchange="showPreview(event);">
                </div>
                <!-- password -->
                <!-- <div class="form-control">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password">
                </div> -->

                <!-- update details -->
                <div class="form-control">
                    <button type="submit" name="update_details" id="update_details">Update Details</button>
                </div>
            </form>
            <?php if ($user_type == 2) { ?>
                <!-- upload qualifications -->
                <div class="qualification">
                    <!-- show uploaded cv and resume -->

                    <div class="uploaded">
                        <h3>Uploaded cv, and resume</h3>
                        <?php
                        $sqlr = "SELECT * FROM qualifications WHERE u_id = '$user_id'";
                        $resultr = mysqli_query($conn, $sqlr);
                        $rowr = mysqli_fetch_assoc($resultr);
                        $tot = mysqli_num_rows($resultr);
                        if ($tot > 0) {
                            $cv = $rowr['q_cv'];
                            $resume = $rowr['q_resume'];
                            if ($cv == '') {
                                echo '<div class="cv">
                                <h4>CV</h4>
                                <p>No cv foumd!</p>
                            </div>';
                            } else {
                                echo '<div class="cv">
                                <h4>CV</h4>
                                <p>' . $cv . '</p>
                            </div>';
                            }
                        }
                        ?>
                        <!-- <div class="cv">
                        <h4>CV</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
                    </div>
                    <div class="resume">
                        <h4>Resume</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
                    </div> -->
                    </div>
                    <form action="../reg_exe.php" method="POST" enctype="multipart/form-data">
                        <div class="header">
                            <h2>Qualifications</h2>
                        </div>
                        <!-- cv  -->
                        <div class="form-control">
                            <label for="cv">CV</label>
                            <textarea name="cv" id="cv" cols="30" rows="10"></textarea>
                        </div>
                        <!-- resume upload -->
                        <div class="form-control">
                            <label for="resume">Resume</label>
                            <input type="file" name="resume" id="resume" accept="application/pdf,application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        </div>
                        <!-- upload -->
                        <div class="form-control">
                            <button type="submit" name="upload_qualification" id="upload_qualification">Upload</button>
                        </div>
                    </form>
                </div>
                <!-- nw -->
            <?php } ?>
        </div>
    </div>

    <?php
    // include footer_scripts.php
    include '../partials/footer_scripts.php';
    ?>
</body>

</html>