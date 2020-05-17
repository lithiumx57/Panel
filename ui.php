<?php

class LiForm
{
  public const X_PERMISSIONS = "permissions";
  public static $liForm;
  public const X_LINK_SYNC = "x-list-sync";
  public const X_MODEL_NUMBER = "number";
  public const X_MODEL_STRING = "string";
  public const X_MODEL_TEXT = "textarea";
  public const X_MODEL_BOOL = "checkbox";
  public const X_MODEL_TAG = "tags";
  public const X_MODEL_DATE = "date";
  public const X_FOREIGN_KEY = "foreign";
  public const X_MODEL_SELECT = "select";
  public const X_MODEL_IMAGE = "image";

  public $type;
  public $showInAdmin;
  public $label;
  public $show = true;
  public $classes = "";
  public $placeholder = null;
  public $parentClass = "";
  public $responsive = "col-xl-8 col-md-12";
  public $required = true;
  public $def;
  public $fillable = "";
  public $nullable = false;
  public $model = null;
  public $conditions = array();
  public $primaryKey;
  public $foreignKey;
  public $renderField;
  public $selectItems;
  public $switchable;
  public $checked = false;
  public $smartSelect = false;
  public $multiple = false;
  public $isSmartEditor = false;
  public $imageSizes = null;
  public $patchRequired = false;
  public $postRequired = false;

  public $filterMax = null;
  public $filterMin = null;
  public $filterEmail = false;
  public $filterDate = false;
  public $filterMimes = null;
  public $filterUnique = null;
  public $filterNumeric = null;
  public $filterImage = null;
  public $filterDigits = null;
  public $listSync = null;

  public function getForeignRows()
  {
    if ($this->model == null) {
      echo "مدل برای فیلد " . $this->label . "تعیین نشده است";
      exit;
    }
    return $this->model::where($this->conditions)->get();
  }

  public function getForeignRenderField()
  {
    if ($this->renderField == null) {
      echo "وارد کردن فیلد رندر برای " . $this->label . " الزامی است ";
      exit;
    }
    return $this->renderField;
  }

  public function __construct($type = null)
  {
    $this->type = $type;
  }

  public function getDefault()
  {
    if (isset($this->def))
      return $this->def;

    if ($this->type == self::X_MODEL_NUMBER) {
      return 0;
    }
    return "";
  }
}

function number(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_NUMBER);
}

function timestamp(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_DATE);
}

function image(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_IMAGE);
}


function select(string $name, $items, $value = null)
{
  $instance = init($name, $value, LiForm::X_MODEL_SELECT);
  $instance->selectItems = $items;
  return $instance;
}

function foreign(string $name, $model, $renderField, $foreignKey = null, $primaryKey = null, $conditions = null, $value = null)
{
  if ($model == null) {
    echo "مدل نباید خالی باشد";
  }

  if ($foreignKey == null) {
    $foreignKey = $name;
  }

  if ($primaryKey == null) {
    $primaryKey = "id";
  }

  $instance = init($name, $value, LiForm::X_FOREIGN_KEY);
  $instance->model = $model;
  $instance->conditions = $conditions;
  $instance->primaryKey = $primaryKey;
  $instance->foreignKey = $foreignKey;
  $instance->renderField = $renderField;
  return $instance;
}

function tagField(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_TAG);
}

function dateField(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_DATE);
}

function float(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_FLOAT);
}

function xString(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_STRING);
}

function xText(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_TEXT);
}

function xPermissions(string $name, $value = null)
{
  return init($name, $value, LiForm::X_PERMISSIONS);
}

function smartText()
{
  return ['isSmartEditor' => true];
}

function bool(string $name, $value = null)
{
  return init($name, $value, LiForm::X_MODEL_BOOL);
}

function init($name, $params, $type)
{
  if ($name == null) {
    echo "نام نمی تواند خالی باشد";
    exit;
  }

  $instance = new LiForm($type);
  $instance->fillable = $name;
  $instance->label = str_replace("_", " ", $name);
  if (!is_array($params)) {
    $instance->def = $params;
    return $instance;
  }

  $params = generateParameters($params, $name);
  foreach ($params as $key => $value) {
    try {
      $instance->$key = $value;
    } catch (Exception $e) {

    }
  }
  return $instance;
}

function generateParameters($params, $name)
{

  $result = [];
  foreach ($params as $param) {
    if (!is_array($param)) {
      echo "خطا در افزودن فیلد " . $name . " همه موارد باید به صورت تابع وارد بشوند نه رشته ";
      exit;
    }
    foreach ($param as $key => $value) {
      $result[$key] = $value;
    }
  }
  return $result;

}

function def($value)
{
  return ['def' => $value];
}

function required($value)
{
  return ['required' => $value];
}

function noRequired()
{
  return ['required' => false];
}

function showInAdmin()
{
  return ['showInAdmin' => true];
}

function label($value)
{
  return ['label' => $value];
}

function placeholder($value)
{
  return ['placeholder' => $value];
}

function postRequired()
{
  return ['postRequired' => true];
}

function patchRequired()
{
  return ['patchRequired' => true];
}

function classes($value)
{
  return ['classes' => $value];
}

function switchable($value)
{
  return ['switchable' => $value];
}

function checked()
{
  return ['checked' => true];
}

function group($array)
{
  $result = [];
  foreach ($array as $key => $value) {
    $value->parentClass = "col-md-" . 10 / count($array);
    $result[$key] = $value;
  }
  return ['group' => $result];
}

function show(bool $value)
{
  return ['show' => $value];
}

function hidden()
{
  return ['show' => false];
}

function col(...$value)
{
  $responsive = "";
  foreach ($value as $row) {
    $responsive .= 'col-' . $row;
  }
  return ['responsive' => $responsive];
}

function imageSizeArray(...$value)
{
  return ['imageSizes' => $value];
}


function xFilterMin($value)
{
  return ['filterMin' => $value];
}

function xFilterMax($value)
{
  return ['filterMax' => $value];
}

function xFilterEmail()
{
  return ['filterEmail' => true];
}

function xFilterDate()
{
  return ['filterDate' => true];
}

function xFilterMimes(...$value)
{
  return ['filterMimes' => $value];
}

function xFilterUnique($value)
{
  return ['filterUnique' => $value];
}

function xFilterNumeric()
{
  return ['filterNumeric' => true];
}

function xFilterImage()
{
  return ['filterImage' => true];
}

function xFilterDigits()
{
  return ['filterDigits' => true];
}

function nullable()
{
  return ['nullable' => true];
}

function smartSelect()
{
  return ['smartSelect' => true];
}

function multipleSelect()
{
  return ['multiple' => true];
}

function getDefault($row)
{
  return $row->getDefault();
}