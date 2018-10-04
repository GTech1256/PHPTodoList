<?php
header('Content-Type: application/json');

include '../includes/db.php';
include 'jwt.php';

$login = $_POST['login'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$errors = array();

if( !isset($_POST['login']) || trim($_POST['login']) == '') {
  $errors[] = 'Логин не введен';
};

if( !isset($_POST['password']) || trim($_POST['password']) == '') {
  $errors[] = 'Пароль не введен';
};

if( $_POST['password'] != $_POST['repeat-password']) {
  $errors[] = 'Повторный пароль не совпадает';
};

if( count($errors) > 0) {
  http_response_code(403);
  echo json_encode($errors);
  exit();
}

$LOGIN = $_POST['login'];
$PASSWORD = password_hash($_POST['password'], PASSWORD_DEFAULT);


mysqli_query(
  $connection, 
  "INSERT INTO `users` (`login`, `password`) VALUES ('$LOGIN', '$PASSWORD')"
);


if (mysqli_error($connection)) {
  http_response_code(403);
  echo json_encode(array('Пользователь с данным логином уже зарегестрирован'));
  exit();
};