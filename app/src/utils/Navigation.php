<?php

class Navigation
{
  public static function redirect($location, $removeParams = false)
  {
    if ($removeParams) {
      $location = preg_replace('/\?.*/', '', $location);
    }
    self::outputScript("location.href='$location';");
  }

  public static function alert($message, $location = null)
  {
    $script = 'alert("' . $message . '");';
    if ($location !== null) {
      $script .= "location.href='$location';";
    }
    self::outputScript($script);
  }

  public static function redirectToLogin()
  {
    $loginUrl = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . "/eparacati/app/login.php";
    self::redirect($loginUrl);
    exit();
  }

  private static function outputScript($script)
  {
    echo "<meta charset='UTF-8' />
        <script type='text/javascript'>
            $script
        </script>";
    exit;
  }
}
