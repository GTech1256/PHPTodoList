<?php

include 'config.php';

header('Content-Type: text/html; charset=utf-8');

$connection = mysqli_connect($config['db']['host'], $config['db']['login'], $config['db']['password'], $config['db']['name']);

if($connection == false) {
  echo 'Не удалось подключиться к БД <br>';
  echo mysqli_connect_error();
  exit();
}
?>