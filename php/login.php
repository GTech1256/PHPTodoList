<?php
header('Content-Type: application/json');

include '../includes/db.php';
include '../includes/jwt.php';

$login = $_POST['login'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$errors = array();

if( !isset($_POST['login']) || trim($_POST['login']) == '') {
  $errors[] = 'Логин не введен';
};

if( !isset($_POST['password']) || trim($_POST['password']) == '') {
  $errors[] = 'Пароль не введен';
};

$LOGIN = $_POST['login'];
$PASSWORD = $_POST['password'];

if( count($errors) > 0) {
  http_response_code(403);
  echo json_encode($errors);
  exit();
};

$response_q = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$LOGIN'");

$count = mysqli_num_rows($response_q);

if($count === 0) {
  http_response_code(404);
  exit();
};

$user = mysqli_fetch_assoc($response_q);

if(!password_verify($PASSWORD, $user['password'])){
  http_response_code(404);
  exit();
};

setcookie('user', JWTDecode($user), time()+60*60*24*30, '/');

// echo ;