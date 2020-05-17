<?php


namespace App\Panel;


use CreateRolesTable;
use Illuminate\Support\Facades\Schema;

class DbHelper
{
  public static function generateRolesTable()
  {
    $result = Schema::hasTable('roles');
    if ($result) return redirect()->route('panel');
    require_once __DIR__ . "/x-table.php";
    (new CreateRolesTable())->up();
    return  redirect()->route('panel');
  }
}