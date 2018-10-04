<?php

include '../includes/jwt.php';


$encodedJWT = JWTEncode($_COOKIE['user']);


if(!$encodedJWT['verify']) {
  http_response_code(401);
  exit();
};

if(!isset($_POST['task_text'])) {
  http_response_code(403);
  exit();
};

include '../includes/db.php';

$user_id = $encodedJWT['data'][0]->user_id;
$TASK_TEXT = $_POST['task_text'];

mysqli_query($connection, "INSERT INTO `tasks` (`text`, `user_id`) VALUES ('$TASK_TEXT', '$user_id')");

$error = mysqli_error($connection);

if($error) {
  echo $error;
  http_response_code(500);
  exit();
}