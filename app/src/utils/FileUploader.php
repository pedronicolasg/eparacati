<?php
require_once 'Navigation.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUploader
{
  private $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
  private $manager = null;

  public function uploadImage($file, string $uploadPath, int $maxHeight, int $maxWidth, int $quality, ?int $specificId = null): ?string
  {
    try {
      if (!isset($file['type']) || !in_array($file['type'], $this->allowedTypes)) {
        Navigation::alert(
          'Tipo de arquivo inválido',
          'Use .png, .jpeg ou .webp',
          'warning',
          $_SERVER['HTTP_REFERER']
        );
        return null;
      }

      if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0755, true);
      }

      if ($this->manager === null) {
        $this->manager = new ImageManager(new Driver());
      }

      $image = $this->manager->read($file['tmp_name']);

      $image->scaleDown($maxWidth, $maxHeight);

      $fileName = $specificId ? $specificId . '.webp' : uniqid('', true) . '.webp';
      $fullPath = rtrim($uploadPath, '/') . '/' . $fileName;

      if (file_exists($fullPath)) {
        unlink($fullPath);
      }

      $image->toWebp($quality)->save($fullPath);

      return $fullPath;
    } catch (Exception $e) {
      Navigation::alert(
        'Erro no Upload',
        $e->getMessage(),
        'error',
        $_SERVER['HTTP_REFERER']
      );
      return null;
    }
  }
}
