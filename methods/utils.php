<?php

class Utils
{
  public static function sanitizeInput($input)
  {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    if (preg_match('/[\'";#\-]/', $input)) {
      die("Entrada inválida detectada.");
    }

    return $input;
  }

  public static function alertAndRedirect($message, $location)
  {
    echo "<meta charset='UTF-8' />";
    echo "<script type='text/javascript'>alert('$message'); location.href='$location';</script>";
    exit;
  }
}
