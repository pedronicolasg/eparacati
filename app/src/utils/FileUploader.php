<?php
require_once 'Navigation.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUploader
{
  public function uploadImage($file, string $uploadPath, int $maxHeight, int $maxWidth, int $quality, ?int $specificId = null): ?string
  {
    try {
      $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
      if (!in_array($file['type'], $allowedTypes)) {
        Navigation::alert('Tipo de arquivo inválido');
      }

      if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0755, true);
      }

      $manager = new ImageManager(new Driver());
      $image = $manager->read($file['tmp_name']);

      $image->scaleDown($maxWidth, $maxHeight);

      $fileName = $specificId
        ? $specificId . '.webp'
        : uniqid() . '.webp';
      $fullPath = rtrim($uploadPath, '/') . '/' . $fileName;

      if (file_exists($fullPath)) {
        unlink($fullPath);
      }

      $image->save($fullPath, ['quality' => $quality]);

      return $fullPath;
    } catch (Exception $e) {
      Navigation::alert('Erro no upload: ' . $e->getMessage());
      return null;
    }
  }
}
