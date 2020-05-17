<?php
if (!is_dir(public_path("admin"))) {
  echo "در حال نصب لطفا صبر کنید";
  header('Location: /admin/panel?type=publish-x-admin');
  exit;
}
?>

@extends('default.layouts.main')

@section('content')
  <table class="table table-bordered">
    <tr>
      <td>عنوان خطا</td>
    </tr>

    <?php
    $errorCounter = 0;
    ?>

    <?php

    $result1 = Schema::hasTable('roles');
    if ($result1 == false) {
    $errorCounter++;
    ?>
    <tr>
      <td>
        جدول های سطوح دسترسی ایجاد نشده است .. <a class="btn btn-primary" href="/admin/panel?type=roles">ایجاد</a>
      </td>
    </tr>
    <?php } ?>


    <?php
    $errorCounter = 0;
    ?>

    <?php
    $result1 = Schema::hasTable('roles');
    if ($result1 == false) {
    $errorCounter++;
    ?>
    <tr>
      <td>
        جدول های سطوح دسترسی ایجاد نشده است .. <a class="btn btn-primary" href="/admin/panel?type=roles">ایجاد</a>
      </td>
    </tr>
    <?php } ?>



    <?php
    $result2 = file_exists(getAppBasePath() . "\\app\\Models\\Role.php");
    $result3 = file_exists(getAppBasePath() . "\\app\\Models\\Permission.php");
    if (!$result2 || !$result3) {
    $errorCounter++;
    ?>
    <tr>
      <td>
        مدل های سطوح دسترسی ایجاد نشده است.. <a class="btn btn-primary" href="/admin/panel?type=create-roles-models">ایجاد</a>
      </td>
    </tr>
    <?php } ?>


    @if($errorCounter==0)
      <tr>
        <td>
          هیچ خطایی وجود ندارد
        </td>
      </tr>
    @endif
  </table>

@endsection