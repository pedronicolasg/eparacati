<?php

class Crypt
{
  public static function HIDE($tx)
  {
    if (!empty($tx)) {
      $tx = base64_encode(base64_encode(base64_encode($tx)));
    }
    return $tx;
  }

  public static function SHOW($tx)
  {
    if (!empty($tx)) {
      $tx = base64_decode(base64_decode(base64_decode(base64_decode(base64_encode($tx)))));
    }
    return $tx;
  }
  public static function passwcrypt($senha)
  {
    $senha = Crypt::HIDE($senha);
    return md5($senha);
  }
}
