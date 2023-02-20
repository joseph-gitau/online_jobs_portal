<?php
//  include connection file
include 'dbh.php';
// REGISTER USER
if (isset($_POST['register_user'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // form validation
    if (empty($name)) {
        array_push($errors, "Fullname is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if (empty($role)) {
        array_push($errors, "Role is required");
    }
    if (count($errors) == 0) {

        // first check the database to make sure 
        // a user does not already exist with the same username and/or email
        $user_check_query = "SELECT * FROM users WHERE name='$name' OR email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['name'] === $name) {
                array_push($errors, "Username already exists");
            }

            if ($user['email'] === $email) {
                array_push($errors, "email already exists");
            }
        }

        // register user 

        $password = md5($password_1); //encrypt the password before saving in the database

        $query = "INSERT INTO users (name, email, password, role) 
  			  VALUES('$name', '$email', '$password', '$role')";
        mysqli_query($conn, $query);
        $_SESSION['name'] = $name;
        $_SESSION['success'] = "You are now logged in!";

        // get the id of the user
        $id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE name='$name' AND email = '$email'"))['id'];
        $_SESSION['id'] = $id;
        header('location: index.php');
    } else {
        // redirect to the registration page with errors
        $_SESSION['errors'] = $errors;
        header('location: ./auth/register.php');
    }
}
