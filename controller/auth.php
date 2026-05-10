<?php
session_start();
$email    = $_REQUEST['email'];
$password = $_REQUEST['password'];
$errors = [];
include_once '../admin/database/env.php';
if (empty($email)) {
    $errors['email_error'] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email_error'] = "Invalid email format.";
}
if (empty($password)) {
    $errors['password_error'] = "Password is required.";
} 
$query = "SELECT * FROM users WHERE email = '$email'";
$response = mysqli_query($db, $query);
if (mysqli_num_rows($response) == 0) {
    $errors['email_error'] = "Email or password is incorrect.";
    $_SESSION ['form_errors'] = $errors;
    header('Location: ../login.php');
} else{
$users = mysqli_fetch_assoc($response);
$result = password_verify($password, $users['password']);
if (!$result) {
    $errors['email_error'] = "Email or password is incorrect.";
    $_SESSION ['form_errors'] = $errors;
    header('Location: ../login.php');
} else {
    $_SESSION['auth'] = $users;
    header('Location: ../admin/index.php');
}}

