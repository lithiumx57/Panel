<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{

  public function up()
  {
    Schema::create('roles', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string("name");
      $table->text("description")->nullable();
      $table->softDeletes();
      $table->timestamps();
    });


    Schema::create('permissions', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string("name");
      $table->string("label");
      $table->bigInteger("parent")->unsigned()->default(0)->nullable();
    });


    Schema::create('permission_role', function (Blueprint $table) {
      $table->bigInteger('role_id')->unsigned();
      $table->foreign('role_id')->references('id')->on('roles')->onDelete("cascade");
      $table->bigInteger('permission_id')->unsigned();
      $table->foreign('permission_id')->references('id')->on('permissions')->onDelete("cascade");
      $table->primary(['permission_id', 'role_id']);
    });


    Schema::create('role_user', function (Blueprint $table) {
      $table->bigInteger('user_id')->unsigned();
      $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");

      $table->bigInteger('role_id')->unsigned();
      $table->foreign('role_id')->references('id')->on('roles')->onDelete("cascade");

      $table->primary(['role_id', 'user_id']);
    });

  }

  public function down()
  {
    Schema::dropIfExists('permission_role');
    Schema::dropIfExists('role_user');
    Schema::dropIfExists('roles');
    Schema::dropIfExists('permissions');
  }
}
