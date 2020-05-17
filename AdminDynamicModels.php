<?php

namespace App\Panel;

use App\Models\Article;
use BadMethodCallException;

class AdminDynamicModels
{
  public static function getModels()
  {
    $records = [];
    foreach (glob("../app/" . str_replace('\\', '', MODEL_PREFIX) . "/*.php") as $mainModel) {
      $model = new Model();
      $parts = explode("/", $mainModel);
      $modelName = str_replace(".php", "", $parts[3]);
      $classPath = "App" . MODEL_PREFIX . "\\$modelName";

      try {
        $classPath::isDynamicPanelMode();
      } catch (BadMethodCallException $e) {
        continue;
      }


      $modelName = str_replace(".php", "", strtolower($modelName));
      $route = $classPath::getRoute();
      $model->setTitle($classPath::getTitle());
      $model->setPluralTitle($classPath::getPluralTitle());
      $model->setClassPath($classPath);
      $model->setIndexRoute("/admin/" . $route);
      $model->setResourceRoute($route);
      $model->setCreateRoute("/admin/" . $route . "/create");
      $model->setStorePath("/admin/" . $route);
      $model->setShowPath($route);
      $records[] = $model;
    }
    return $records;
  }

  public static function initialize()
  {
    require_once "loader.php";
    generateAdminRoutes();
  }
}