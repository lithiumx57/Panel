<?php


namespace App\Panel;


use Illuminate\Support\Facades\File;
use ZipArchive;

class XFileHelper
{
  public static function generateRoleModel()
  {
    File::copy(self::getExamplesFolder() . "\\Role.txt", self::getModelFolder() . "\\Role.php");
    File::copy(self::getExamplesFolder() . "\\Permission.txt", self::getModelFolder() . "\\Permission.php");
    return redirect()->route('panel');
//    $basePath = $artisanPath = App::basePath() . "\\artisan";
//    shell_exec("php " . $basePath . " make:model Models\\Role");
//    shell_exec("php " . $basePath . " make:model Models\\Permission");
//    return redirect()->route('panel');
  }


  public static function getExamplesFolder()
  {
    return getAppBasePath() . "\\app\\Panel\\examples";
  }

  public static function getModelFolder()
  {
    return getAppBasePath() . "\\app\\Models";
  }


  public static function publishAdminFolder()
  {
    $zip = new ZipArchive;
    if ($zip->open(self::getExamplesFolder() . "\\p_path.zip") === TRUE) {
      $zip->extractTo(public_path());
      $zip->close();
      return redirect()->route('panel');
    } else {
      echo 'ERROR';
    }

  }


}