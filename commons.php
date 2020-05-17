<?php

use Illuminate\Support\Facades\App;

function initFields()
{
  $records = [];
  foreach (getRequestData() as $key => $value) {
    if ($value == "on") {
      $records[$key] = true;
      continue;
    }
    $records[$key] = $value;
  }
  return $records;
}

function multipleSwitch($model)
{
  $records = getRequest("records");
  $fillable = getRequest("fillable");
  try {
    $result = $model::withTrashed()->whereIn('id', $records)->get();
  } catch (BadMethodCallException $e) {
    $result = $model::whereIn('id', $records)->get();
  }

  foreach ($result as $row) {
    if ($row instanceof $model) {
      $row->update([
        $fillable => !$row->$fillable
      ]);
    }
  }
  showSuccessMessage();
  return back();
}

function multipleDelete($model, $route, $id, $parameters = null)
{
  $records = getRequest("records");
  if ($id > 0) {
    $records = [$id];
  }

  if ($parameters != null) {
    $recycleBinPath = getQueryLink($parameters, "/admin/" . $route, true);
    $targetIndexPath = getQueryLink($parameters, "/admin/" . $route);
  } else {
    $recycleBinPath = "/admin/" . $route . "?recycle-bin=true";
    $targetIndexPath = "/admin/" . $route;
  }

  $mode = getRequest("mode");
  if ($mode == "restore") {
    foreach ($records as $record) {
      $record = $model::withTrashed()->find($record);
      try {
        if ($record instanceof $model) {
          $record->restore();
        }
      } catch (Exception $e) {
      }
    }
    showSuccessMessage();
    return redirect($recycleBinPath);
  } else if ($mode == "deleteForEver") {
    foreach ($records as $record) {
      $record = $model::withTrashed()->find($record);
      if ($record instanceof $model) {
        try {
          $record->forceDelete();
        } catch (\Exception $e) {
        }
      }
    }
    showSuccessMessage();
    return redirect($recycleBinPath);

  } else if ($mode == "delete") {
    if (is_array($records)) {
      foreach ($records as $record) {
        $record = $model::find($record);

        if ($record instanceof $model) {
          try {
            $record->delete();
          } catch (\Exception $e) {
          }
        }
      }
    }
    alert("اطلاعات با سطل زباله منتقل شد");
    return redirect($targetIndexPath);
  }
}

function getQueryLink($routeData, $routePrefix, $isRecycleBin = false)
{
  $i = 0;
  if ($isRecycleBin) {
    $routePrefix .= "?recycle-bin=true";
    $i++;
  }

  foreach ($routeData as $key => $value) {
    if ($i == 0) {
      $routePrefix .= "?" . $key . "=" . $value;
    } else {
      $routePrefix .= "&" . $key . "=" . $value;
    }
    $i++;
  }
  return $routePrefix;

}

function showSuccessMessage()
{
  alert("عملیات با موفقیت انجام شد");
}

function showErrorMessage()
{
  alert("خطایی رخ داده است", "error");
}

function alert($message = null, $kind = "success")
{
  $messageKey = "flash_message";
  $kindKey = "flash_message_kind";
  setSession($messageKey, $message);
  setSession($kindKey, $kind);
}

function setSession($key, $value)
{
  request()->session()->put($key, $value);
}

function removeSession($key)
{
  request()->session()->remove($key);
}


function getOptions($model, $name, $sName, $route, $showOptions = true, $dropdown = null, $parameters = [], $hasRecycleBin = true)
{
  $count = "-";
  if ($hasRecycleBin) {
    try {
      $count = $model::onlyTrashed()->count();
    } catch (BadMethodCallException $e) {

    }

  }
  return [
    "route" => $route,
    "dropdown" => $dropdown,
    "showOptions" => $showOptions,
    "hasRecycleBin" => $hasRecycleBin,
    "routeData" => $parameters,
    "name" => $name,
    "count" => $count,
    "path" => [
      ['title' => $sName, 'url' => $route],
    ]];
}

function getPluralModelName($name)
{
  $lastChar = substr($name, -1);
  if ($lastChar == "y") {
    $name = substr($name, 0, strlen($name) - 1);
    $name .= "ies";
  } else if ($lastChar == "s") {
    $name .= "es";
  } else {
    $name .= "s";
  }
  return $name;
}

function getRecycleBinPath()
{
  return ["recycle-bin" => "true"];
}

function isCreateOrEditMode()
{
  return strpos(request()->getRequestUri(), "/create") || strpos(request()->getRequestUri(), "/edit");
}

function getRecycleBinField()
{
  return "<input type='hidden' name='recycle-bin' value='" . isRecycleBinMode() . "'>";
}

function getAppBasePath()
{
  return App::basePath();
}