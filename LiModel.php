<?php


namespace App\Panel;


abstract class LiModel extends XModel
{

  public static function isDynamicPanelMode()
  {
    return true;
  }

  protected function fields(): array
  {
    return [];
  }

  protected function actions(): array
  {
    return [];
  }

  public function __toString()
  {
    return $this->title == null ? "" : $this->title;
  }

  public function scopeGetRoute()
  {
    if ($this->route == null) {
      return getPluralModelName(strtolower($this->getCalledName()));
    }
    return $this->route;
  }

  private function getCalledName()
  {
    $className = get_class($this);
    return explode("\\", $className)[2];
  }

  public function scopeGetTitle()
  {
    if ($this->title == null) {
      $className = get_class($this);
      $result = explode("\\", $className)[2];
      return strtolower($result);
    }
    return $this->title;
  }

  public function scopeGetModelName()
  {
    return $this->getCalledName();
  }

  public function scopeGetPluralTitle()
  {
    if ($this->pluralTitle != null) {
      return $this->pluralTitle;
    }

    if ($this->title != null) {
      return $this->title . " ها ";
    }

    $className = get_class($this);
    $result = explode("\\", $className)[2];
    if ($this->title != null && $this->pluralTitle == null) {
      return $this->title . " ها ";
    }
    return getPluralModelName($result);
  }

}
