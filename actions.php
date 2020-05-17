<?php

class Action
{
  public const RECYCLE_BIN = 1;
  public const SWITCH = 2;
  public $title;
  public $fillable;
  public $type;

  public function __construct($title, $type, $fillable = null)
  {
    $this->title = $title;
    $this->fillable = $fillable;
    $this->type = $type;
  }


}

function recycleBinAction()
{
  return new Action(null, Action::RECYCLE_BIN);
}

function switchAction($title, $fillable)
{
  return new Action($title, Action::SWITCH, $fillable);
}