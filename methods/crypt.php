<?php

class Crypt
{
  public static function hide($tx)
  {
    if (!empty($tx)) {
      $tx = base64_encode(base64_encode(base64_encode($tx)));
    }
    return $tx;
  }

  public static function show($tx)
  {
    if (!empty($tx)) {
      $tx = base64_decode(base64_decode(base64_decode(base64_decode(base64_encode($tx)))));
    }
    return $tx;
  }
  public static function passw($senha)
  {
    $senha = Crypt::hide($senha);
    return md5($senha);
  }
}
