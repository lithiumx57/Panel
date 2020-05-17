<?php
require_once "AdminController.php";

use App\Http\Controllers\AdminController;
use App\Panel\AdminDynamicModels;
use App\Panel\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

function getAdminResourceRoute($route, $model)
{
  AdminController::$model = $model;
  Route::resource($route, "AdminController");
}

function generateAdminRoutes()
{
  $uri = request()->getRequestUri();
  $uri = explode("/", $uri);
  if (count($uri) < 2 || $uri[1] != getAdminPrefix()) return;
  $route = $uri[2];

  if ($route == null) return;
  $route = explode("?", $route)[0];

  Route::get('/admin/panel', "AdminController@panel")->name('panel');

  preUseAdmin();
  foreach (AdminDynamicModels::getModels() as $model) {
    if (!($model instanceof \App\Panel\Model)) continue;
    if (!$model->getClassPath()::isDynamicPanelMode()) continue;
    if ($route == $model->getResourceRoute()) {
      $resourcePath = $model->getResourceRoute();
      initModel($model);
      Route::group(['prefix' => getAdminPrefix()], function () use ($resourcePath) {
        Route::resource($resourcePath, "AdminController");
      });
      break;
    }
  }
}

function preUseAdmin()
{
  Config::set('view.paths', [
    app_path("Panel\\admin-views\\"),
  ]);
  $app = App::make('config');
}

function isShowRoute($route)
{
  $uri = request()->getRequestUri();
  $uri = explode("/", $uri);
  $uri3 = @$uri[3];
  if ($uri3 != null) {
    $uri3 = explode("?", $uri3);
    if (count($uri3) > 0) {
      $uri3 = $uri3[0];
    }
  }
  return @$uri[1] == getAdminPrefix() && @$uri[2] == $route && is_numeric(@$uri3);
}

function initModel(Model $model)
{
  AdminController::$model = $model->getClassPath();
  AdminController::$route = $model->getResourceRoute();
}


function getAdminPrefix()
{
  return "admin";
}







