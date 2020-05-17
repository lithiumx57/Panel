<?php

namespace App\Http\Controllers;

use App\Panel\AdminRequest;
use App\Panel\DbHelper;
use App\Panel\XFileHelper;
use BadMethodCallException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
  public static $model;
  public static $route;

  public function panel()
  {
    $type = getRequest("type");

    if ($type == "roles") {
      return DbHelper::generateRolesTable();
    } else if ($type == "create-roles-models") {
      return XFileHelper::generateRoleModel();
    } else if ($type == "publish-x-admin") {
      return XFileHelper::publishAdminFolder();
    }

    return view('default.panel');
  }




  public function index()
  {
    $model = self::$model;
    $route = self::$route;
    if (isRecycleBinMode()) {
      try {
        $records = $model::onlyTrashed()->get();
      } catch (BadMethodCallException $e) {
        echo "وقتی می خواهید از سطل زباله استفاده کنید باید SoftDelete را به مدل " . $model::getModelName() . " اضافه کنید";
        exit;
      }

    } else {
      $records = $model::all();
    }
    return view('default.index', compact('model', 'records', 'route'));
  }


  public function create()
  {
    $route = self::$route;
    $model = self::$model;
    $isEditMode = false;
    return view('default.create', compact('route', 'model', 'isEditMode'));
  }

  public function store(AdminRequest $request)
  {
    $records = initFields();
    self::$model::create($records);
    return redirect("/admin/" . self::$route);
  }

  public function show($id)
  {
    $switch = getRequest("switch");
    $model = self::$model;

    $record = $this->getRecord($model, $id);
    if ($switch) {
      $record->update([
        $switch => !$record->$switch
      ]);
    }

    return redirect("/admin/" . self::$route);
  }

  private function getRecord($model, $id)
  {
    try {
      $record = $model::withTrashed()->findOrFail($id);
    } catch (\BadMethodCallException $e) {
      $record = $model::findOrFail($id);
    }
    return $record;
  }


  public function edit($id)
  {
    $model = self::$model;
    $route = self::$route;
    $object = $this->getRecord($model, $id);
    $isEditMode = true;
    return view('default.create', compact('route', 'model', 'object', 'isEditMode'));
  }

  public function update(AdminRequest $request, $id)
  {
    $model = self::$model;
    $record = $this->getRecord($model, $id);
    $records = initFields();
    $record->update($records);
    return redirect("/admin/" . self::$route);
  }

  public function destroy(AdminRequest $request, $id)
  {
    $type = getRequest("type");
    if ($type && $type == "switch") {
      return multipleSwitch(self::$model);
    }

    return multipleDelete(self::$model, self::$route, $id);
  }

}
