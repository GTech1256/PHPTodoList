<?php

function JWTDecode($user) {
  include '../includes/config.php';

  $data = array(
    'user_id' => $user['_id'],
    'user_login' => $user['login'],
  );

  
  $dataPart = json_encode(array($data));
  $secretPart = base64_encode($config['secretKey']);

  return base64_encode( $dataPart . '.' . $secretPart);
};

function JWTEncode($string) {
  include '../includes/config.php';

  $decodedString = base64_decode($string);

  $dataPart = explode('.', $decodedString)[0];

  $secretPart = explode('.', $decodedString)[1];

  $secretFromString = base64_decode($secretPart);

  if($secretFromString != $config['secretKey']) {
    return array(
      'verify' => false
    );
  } else {
    return array(
      'verify' => true,
      'data' => json_decode($dataPart)
    );
  };
};