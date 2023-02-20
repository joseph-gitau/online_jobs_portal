<?php
if (!isset($_SESSION)) {
    session_start();
}
//  include connection file
include 'dbh.php';
// REGISTER USER
if (isset($_POST['register_user'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    // role id
    $role_id = ($role == 'jobseeker') ? 2 : 3;

    // form validation
    $errors = [];
    if (empty($name)) {
        $errors['name'] = "Name is required";
    }
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required";
    }
    if (empty($phone)) {
        $errors['phone'] = "Phone is required";
    }
    if (empty($password_1)) {
        $errors['password_1'] = "Password is required";
    }
    if (empty($password_2)) {
        $errors['password_2'] = "Confirm password is required";
    }

    if (count($errors) == 0) {

        // first check the database to make sure 
        // a user does not already exist with the same username and/or email
        $user_check_query = "SELECT * FROM users WHERE u_name='$name' OR u_email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['name'] === $name) {
                $errors['dup_username'] = "Username already exists";
            }

            if ($user['email'] === $email) {
                $errors['dup_email'] = "Email already exists";
            }
        } else {
            // register user 
            $password = md5($password_1); //encrypt the password before saving in the database
            // save user to database
            $sql = "INSERT INTO users (role_id, u_name, u_username, u_email, u_phone, u_password) 
                    VALUES('$role_id', '$name', '$username', '$email', '$phone', '$password')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo 'Error: ' . mysqli_error($conn);
            } else {
                $_SESSION['username'] = $username;
                // get inserted user id
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                // get user type
                $_SESSION['user_type'] = $role_id;
                $_SESSION['success'] = "You are now logged in";
                echo 'success';
            }
        }
    } else {
        foreach ($errors as $error) {
            echo '=> ' . $error;
        }
    }
}

// update_details
if (isset($_POST['update_details'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $county = mysqli_real_escape_string($conn, $_POST['county']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $m_status = mysqli_real_escape_string($conn, $_POST['m_status']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $image = $_FILES['file']['name'];
    // $password = mysqli_real_escape_string($conn, $_POST['password']);
    $uid = $_SESSION['user_id'];
    $target = "resources/images/" . basename($image);
    // check if image exists
    if (!empty($image)) {
        // move image to folder
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = '';
    }

    $sql = "UPDATE users SET u_name = '$name', u_username='$username',u_email='$email',u_phone='$phone',u_county='$county', u_address='$address',u_gender='$gender',u_m_status='$m_status',u_dob='$dob',u_image='$image' WHERE u_id='$uid'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo 'Error: ' . mysqli_error($conn);
    } else {
        echo 'success';
    }
}
