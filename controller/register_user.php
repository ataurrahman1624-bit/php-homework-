<?php
session_start();
// Import the database connection file
include '../admin/database/env.php'; 

$name     = $_REQUEST['name'];
$email    = $_REQUEST['email'];
$password = $_REQUEST['password'];
$terms    = $_REQUEST['terms'] ?? false;
$errors = [];

if (empty($name) || strlen($name) < 3) {
    $errors['name_error'] = "Name must be at least 3 characters long.";
}
if (empty($email)) {
    $errors['email_error'] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email_error'] = "Invalid email format.";
}
if (empty($password)) {
    $errors['password_error'] = "Password is required.";
} elseif (strlen($password) < 8) {
    $errors['password_error'] = "Password must be at least 8 characters long.";
}
if (!$terms) {
    $errors['terms_error'] = "You must accept the terms and conditions.";
}

if(count($errors) > 0) {
    $_SESSION['form_errors'] = $errors;
    header('Location: ../register.php');
    exit; // Stop executing script
} else {
    // Encrypt password before database insertion
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name', '$email', '$hashed_password')";
    $response = mysqli_query($db, $query);

    if($response) {
        header("Location: ../login.php");
        exit;
    } else {
        header("Location: ../register.php");
        exit;
    }
}   
