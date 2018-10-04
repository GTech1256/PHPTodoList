<?php

include '../includes/jwt.php';


$encodedJWT = JWTEncode($_COOKIE['user']);


if(!$encodedJWT['verify']) {
  http_response_code(401);
  exit();
};

if(isset($_POST['task_id'])) {
  post($_POST['task_id']);
} else {
  get($encodedJWT);
}


function get($encodedJWT) {
  include '../includes/db.php';
  $user = $encodedJWT['data'][0];

  $user_id = $user->user_id;

  $tasks_q = mysqli_query($connection, "SELECT `_id`, `text`, `done` FROM `tasks` WHERE `user_id`='$user_id' ORDER BY `created_at`");

  $tasks = array();

  while( $task = mysqli_fetch_assoc($tasks_q)) {
    $tasks[] = $task;
  };

  $data = array(
    'tasks' => $tasks,
    'user_login' => $user->user_login
  );

  echo json_encode($data);
}

function post($taskID) {
  include '../includes/db.php';
  $done = $_POST['done'];

  $tasks_q = mysqli_query($connection, "UPDATE `tasks` SET `done`=$done WHERE `_id`='$taskID' ");
  
  $error = mysqli_error($connection);
  if($error) {
    http_response_code(500);
    echo $error;
    exit();
  }
};