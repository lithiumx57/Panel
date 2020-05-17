<?php


namespace App\Panel;


use Illuminate\Database\Eloquent\Model;

abstract class XModel extends Model
{
  protected abstract function fields(): array;
  abstract static function isDynamicPanelMode();
  protected abstract function actions(): array;

  protected $title = null;
  protected $route = null;
  protected $pluralTitle = null;

  private static $i = 0;

  public function __construct(array $attributes = [])
  {
    $this->scopeInitializedFields();
    parent::__construct($attributes);
  }


  public function scopeInitializedFields()
  {
    $fields = $this->fields();
    $records = [];
    foreach ($fields as $key => $value) {
      if ($value instanceof \LiForm) {
        $records[self::$i] = $value;
        self::$i++;
      } else {
        $records = array_merge($records, $this->initGroup($value));
      }
    }
    $this->initFillable($records);

    return $records;
  }

  private function initFillable($records)
  {
    $result = [];
    foreach ($records as $record) {
      $result[] = $record->fillable;
    }
    $this->fillable = $result;
  }

  protected function initGroup($array)
  {
    $result = [];
    foreach ($array as $key2 => $value2) {
      foreach ($value2 as $key3 => $value3) {
        if ($value3 instanceof \LiForm) {
          $result[self::$i] = $value3;
          self::$i++;
        }
      }
    }
    return $result;
  }


  public function scopeInitializedOptions()
  {
    $actions = $this->actions();
    $this->preRender($actions);
    return $actions;
  }


  public function preRender($actions)
  {
  }
}