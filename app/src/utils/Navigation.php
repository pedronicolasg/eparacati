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
    $script = "alert('$message');";
    if ($location !== null) {
      $script .= "location.href='$location';";
    }
    self::outputScript($script);
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
