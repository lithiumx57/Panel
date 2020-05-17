<?php


namespace App\Panel;


class Model
{
  private $title;
  private $createRoute;
  private $indexRoute;
  private $classPath;
  private $resourceRoute;

  private $storePath;
  private $updatePath;
  private $deletePath;
  private $showPath;
  private $pluralTitle;

  public function getPluralTitle()
  {
    return $this->pluralTitle;
  }


  public function setPluralTitle($pluralTitle): void
  {
    $this->pluralTitle = $pluralTitle;
  }


  public function getShowPath()
  {
    return $this->showPath;
  }

  public function setShowPath($showPath): void
  {
    $this->showPath = $showPath;
  }


  public function getStorePath()
  {
    return $this->storePath;
  }

  public function setStorePath($storePath): void
  {
    $this->storePath = $storePath;
  }

  public function getUpdatePath()
  {
    return $this->updatePath;
  }

  public function setUpdatePath($updatePath): void
  {
    $this->updatePath = $updatePath;
  }

  public function getDeletePath()
  {
    return $this->deletePath;
  }

  public function setDeletePath($deletePath): void
  {
    $this->deletePath = $deletePath;
  }


  public function getResourceRoute()
  {
    return $this->resourceRoute;
  }

  public function setResourceRoute($resourceRoute): void
  {
    $this->resourceRoute = $resourceRoute;
  }


  public function getClassPath()
  {
    return $this->classPath;
  }

  public function setClassPath($classPath): void
  {
    $this->classPath = $classPath;
  }


  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title): void
  {
    $this->title = $title;
  }

  public function getCreateRoute()
  {
    return $this->createRoute;
  }

  public function setCreateRoute($createRoute): void
  {
    $this->createRoute = $createRoute;
  }


  public function getIndexRoute()
  {
    return $this->indexRoute;
  }

  public function setIndexRoute($indexRoute): void
  {
    $this->indexRoute = $indexRoute;
  }


}