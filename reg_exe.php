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
            $password = password_hash($password, PASSWORD_DEFAULT); //encrypt the password before saving in the database
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
    // var_dump($_FILES);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $county = mysqli_real_escape_string($conn, $_POST['county']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $m_status = mysqli_real_escape_string($conn, $_POST['m_status']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $temp = mysqli_real_escape_string($conn, $_POST['temp']);
    // $password = mysqli_real_escape_string($conn, $_POST['password']);
    $uid = $_SESSION['user_id'];
    // check if image exists
    if ($temp == "no_image") {
        // get the image from the database
        $sql0 = "SELECT u_image FROM users WHERE u_id='$uid'";
        $result0 = mysqli_query($conn, $sql0);
        $row0 = mysqli_fetch_assoc($result0);
        $image = $row0['u_image'];
    } else {
        $image = $_FILES['image']['name'];
        $target = "resources/images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $sql = "UPDATE users SET u_name = '$name', u_username='$username',u_email='$email',u_phone='$phone',u_county='$county', u_address='$address',u_gender='$gender',u_m_status='$m_status',u_dob='$dob',u_image='$image' WHERE u_id='$uid'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo 'Error: ' . mysqli_error($conn);
    } else {
        echo 'success';
    }
}

// login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // check if refferer page exists in the $_SESSION['referer_page']
    if (isset($_SESSION['referer_page'])) {
        $referer_page = $_SESSION['referer_page'];
        // pass the referer page js variable
        // echo '<script>var referer_page = "' . $referer_page . '";</script>';
    } else {
        $referer_page = 'index.php';
        // pass the referer page js variable
        // echo '<script>var referer_page = "' . $referer_page . '";</script>';
    }

    // verify the data from the form
    $errors = [];
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    if (count($errors) == 0) {
        // check if username or email already exists
        $sql = "SELECT * FROM users WHERE u_username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $tot = mysqli_num_rows($result);
        if ($tot > 0) {
            // get the data from the database
            $row = mysqli_fetch_assoc($result);
            $db_password = $row['u_password'];
            $db_username = $row['u_username'];
            $db_id = $row['u_id'];
            /* echo $db_password;
            echo $password;
            echo password_hash('123', PASSWORD_DEFAULT) . 'ret';*/

            // verify password
            if (password_verify($password, $db_password)) {
                // create session variables
                $_SESSION['username'] = $db_username;
                $_SESSION['user_id'] = $db_id;
                // get user type
                $_SESSION['user_type'] = $row['role_id'];

                echo 'success';
            } else {
                echo 'Incorrect password';
            }
        } else {
            echo 'Username does not exist';
        }
    } else {
        // loop through the errors and display them
        foreach ($errors as $error) {
            echo '=> ' . $error;
        }
    }
}

// upload_qualification
if (isset($_POST['upload_qualification'])) {
    // dd the $_POST array
    // dd($_POST);
    $uid = $_SESSION['user_id'];
    $cv = mysqli_real_escape_string($conn, $_POST['cv']);
    $place = mysqli_real_escape_string($conn, $_POST['place']);
    if ($place == 'no_file') {
        $resume = '';
    } else {
        $resume = $_FILES['file']['name'];
    }
    // echo '-------------' . $resume;

    if (!empty($resume)) {
        // var_dump($_FILES['file']);
        $resume1 = $_FILES['file']['name'];
        // add user id to file name
        $resume = $uid . '_' . $resume1;
        $target = "resources/resumes/" . basename($resume);

        // move renamed file to folder
        move_uploaded_file($_FILES['file']['tmp_name'], $target);
    } else {
        $resume = '';
    }
    // check if user has already uploaded a resume
    $sql = "SELECT * FROM qualifications WHERE u_id = '$uid'";
    $result = mysqli_query($conn, $sql);
    $tot = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $cv_d = $row['q_cv'];
    $resume_d = $row['q_resume'];
    if ($tot > 0) {
        if (empty($resume)) {
            $resume = $resume_d;
        }
        if (empty($cv)) {
            $cv = $cv_d;
        }

        $sql1 = "UPDATE qualifications SET u_id = '$uid', q_cv='$cv', q_resume='$resume' WHERE u_id='$uid'";
        $result1 = mysqli_query($conn, $sql1);
        if (!$result1) {
            echo 'Error: ' . mysqli_error($conn);
        } else {
            echo 'success';
        }
    } else {
        $sql2 = "INSERT INTO qualifications(u_id, q_cv, q_resume) VALUES('$uid', '$cv', '$resume')";
        $result2 = mysqli_query($conn, $sql2);
        if (!$result2) {
            echo 'Error: ' . mysqli_error($conn);
        } else {
            echo 'success';
        }
    }
}

// add-jobps
if (isset($_POST['add-jobps'])) {
    $uid = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $place = mysqli_real_escape_string($conn, $_POST['place']);
    if ($place == 'no_file') {
        $file = '';
    } else {
        $file = $_FILES['image']['name'];
        // var_dump($_FILES['image']);
        // echo 'here';
    }
    $errors = [];
    if (empty($title)) {
        $errors['title'] = 'Title is required';
    }
    if (empty($description)) {
        $errors['description'] = 'Description is required';
    }
    if (empty($type)) {
        $errors['type'] = 'Type is required';
    }
    if (empty($category)) {
        $errors['category'] = 'Category is required';
    }
    if (empty($location)) {
        $errors['location'] = 'Location is required';
    }
    if (empty($salary)) {
        $errors['salary'] = 'Salary is required';
    }
    if (count($errors) == 0) {
        if (!empty($file)) {
            // add user id to file name
            $file = $uid . '_' . $file;
            $target = "resources/jobps/" . basename($file);

            // move renamed file to folder
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        }
        $sql = "INSERT INTO job_post(u_id, jp_title, jp_description, jp_type, jp_category, jp_location, jp_salary, jp_image) VALUES('$uid', '$title', '$description', '$type', '$category', '$location', '$salary', '$file')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'Error: ' . mysqli_error($conn);
        } else {
            echo 'success';
        }
    } else {
        // loop through the errors and display them
        foreach ($errors as $error) {
            echo '=> ' . $error;
        }
    }
}

// delete_posting
if (isset($_POST['delete_posting'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM job_post WHERE jp_id = '$id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo 'Error: ' . mysqli_error($conn);
    } else {
        echo 'success';
    }
}
// msg_submit
if (isset($_POST['msg_submit'])) {
    $uid = $_SESSION['user_id'];
    $emp_id = $_POST['emp_id'];
    $msg_id = $_POST['msg_id'];
    $msg_title = mysqli_real_escape_string($conn, $_POST['msg_title']);
    $msg_body = mysqli_real_escape_string($conn, $_POST['msg_body']);
    $place = mysqli_real_escape_string($conn, $_POST['place']);
    if ($place == 'no_file') {
        $file = '';
    } else {
        $file = $_FILES['msg_attachment']['name'];
        // var_dump($_FILES['msg_attachment']);
    }
    $errors = [];
    if (empty($msg_title)) {
        $errors['msg_title'] = 'Title is required';
    }
    if (empty($msg_body)) {
        $errors['msg_body'] = 'Message is required';
    }
    if (count($errors) > 0) {
        // loop through the errors and display them
        foreach ($errors as $error) {
            echo '=> ' . $error;
        }
    } else {
        // insert message to messages table
        $sql = "INSERT INTO messages (u_id, jp_id, emp_id, m_title, m_message, m_attachment) VALUES ('$uid', '$msg_id', '$emp_id', '$msg_title', '$msg_body', '$file')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'Error: ' . mysqli_error($conn);
        } else {
            // move renamed file to folder if file is not empty
            if (!empty($file)) {
                // add user id to file name
                $file = $uid . '_' . $file;
                $target = "resources/messages/" . basename($file);

                // move renamed file to folder
                move_uploaded_file($_FILES['msg_attachment']['tmp_name'], $target);
            }
            echo 'success';
        }
    }
}

// view_msg_deft
if (isset($_POST['view_msg_deft'])) {
    $user_id = $_SESSION['user_id'];
    $id = $_POST['id'];
    $sql = "SELECT * FROM messages WHERE jp_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $tot = mysqli_num_rows($result);
    if ($tot > 0) {
        // expandable variable to hold the messages
        $msg = '';
        $i = 0;
        $j = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $uid = $row['u_id'];
            $jp_id = $row['jp_id'];
            $emp_id = $row['emp_id'];
            $subject = $row['m_title'];
            $message = $row['m_message'];
            $sql1 = "SELECT role_id FROM users WHERE u_id = '$uid'";
            $result1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_assoc($result1);
            $role_id = $row1['role_id'];
            // echo $role_id;
            if ($role_id == 2) {
                if ($i == 0) {
                    echo '<p class="self">' . $message . '</p>
                    <span class="hidden msg-title">' . $subject . '</span>
                    <span class="hidden jpr_id">' . $jp_id . '</span>
                    <span class="hidden emp_id">' . $emp_id . '</span>
                    ';
                    $i++;
                } else {
                    echo '<p class="other">' . $message . '</p>
                    <span class="hidden msg-title">' . $subject . '</span>
                    ';
                    $i++;
                }
            } else {
                if ($j == 0) {
                    echo '<p class="self">' . $message . '</p>
                    <span class="hidden msg-title">' . $subject . '</span>
                    <span class="hidden jpr_id">' . $jp_id . '</span>
                    <span class="hidden emp_id">' . $emp_id . '</span>
                    ';
                    $j++;
                } else {
                    echo '<p class="other">' . $message . '</p>
                    <span class="hidden msg-title">' . $subject . '</span>
                    ';
                }
            }
            // reset role_id
            $role_id = '';
        }
    }
}
