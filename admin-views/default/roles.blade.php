@extends('default.layouts.main')
@section('content')
  <?php
  $permissions = \App\Models\Permission::getPermissions();
  ?>

  @include('default.layouts.error')
  <div class="navBox">
    <a href="/admin/roles/index" class="btn btn-danger btn-sm">سطوح دسترسی</a>
  </div>
  <form action="/admin/roles" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-md-8 col-xs-12">
      <label for="name">عنوان</label>
      <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
    </div>

    <div class="form-group col-md-8 col-xs-12">
      <label for="description">توضیحات</label>
      <textarea type="text" class="form-control" id="description" name="description">{{old('description')}}</textarea>
    </div>

    <div class="form-group col-md-8 col-xs-12">

      <div style="margin: 5px 0 20px;" class="col-md-12 col-xs-12 col-sm-12">
        <div style="margin-top: 8px;margin-bottom: 8px">دسترسی ها</div>
        <?php $i = 0; $currentPermission = -1; $lastPermission = 0;?>

        @foreach($permissions as $permission)

          @if($permission->parent != 0) @continue @endif

          <div class="permissionBox">

            @if($permission->parent==0)

              <div class="icheck-material-success p_parent">
                <input @if(old('permissions')) @foreach(old('permissions') as $old) @if($old==$permission->id) checked @endif  @endforeach @endif onchange="permissionChange(this)" type="checkbox" id="success_{{$permission->id}}" name="permissions[]" value="{{$permission->id}}" class="permission">
                <label style="color: yellow" class="f15" for="success_{{$permission->id}}">{{$permission->label}}</label>
              </div>

              @foreach($permissions as $row)
                @if($row->parent != $permission->id) @continue @endif
                <div style="padding-right: 30px" class="p_child">
                  <div class="icheck-material-warning">
                    <input @if(old('permissions')) @foreach(old('permissions') as $old) @if($old==$permission->id) checked @endif  @endforeach @endif  onchange="permissionChange(this)" type="checkbox" id="success_{{$row->id}}" name="permissions[]" value="{{$row->id}}" class="permission">
                    <label style="font-weight: bold" class="f12" for="success_{{$row->id}}">{{$row->label}}</label>
                  </div>
                </div>
              @endforeach
            @endif


          </div>

        @endforeach
        <div class="clearfix"></div>


      </div>
    </div>
    <br>


    <div class="form-group col-md-8 col-xs-12">
      <input type="submit" class="btn btn-primary" value="ثبت">
    </div>
  </form>



@endsection

@section('script')

  <script>
    var permissions = JSON.parse('{!! $permissions !!}');

    var permissionTags = document.getElementsByClassName("permission");

    function permissionChange(tag) {
      var checked = tag.checked;
      var id = parseInt(tag.id.replace("success_", ""));
      var permission = getPermission(id);

      if (hasParent(permission)) {
        checkParent(permission, checked)
      } else if (hasChild(permission)) {
        checkChildren(permission, checked)
      }
    }


    function checkChildren(permission, checked) {

      for (var i = 0; i < permissions.length; i++) {
        if (permissions[i].parent === permission.id) {

          var p = getPermission(permissions[i].id);
          var tag = document.getElementById("success_" + p.id);

          if (checked) {
            tag.checked = "checked";
          } else {
            $(tag).prop('checked', false);
          }

        }
      }
    }


    function hasLevelChecked(permission) {
      var p = getPermission(permission.parent)
      var children = getChildren(p.id);

      for (var i = 0; i < children.length; i++) {
        var tag = document.getElementById("success_" + children[i].id);
        if (tag.checked) {
          return true;
        }
      }
      return false;

    }


    function getChildren(permissionId) {
      var c = [];
      for (var i = 0; i < permissions.length; i++) {
        if (permissions[i].parent === permissionId) {
          c.push(permissions[i])
        }
      }
      return c;
    }


    function hasChild(permission) {
      for (var i = 0; i < permissions.length; i++) {
        if (permissions[i].parent === permission.id) {
          return true;
        }
      }
      return false;
    }


    function checkParent(permission) {
      var parent = getPermission(permission.parent);

      var tag = document.getElementById("success_" + parent.id);
      if (hasLevelChecked(permission)) {
        tag.checked = "checked";
      } else {
        $(tag).prop('checked', false);
      }


    }


    function hasParent(permission) {
      return permission.parent !== 0
    }


    function getPermission(id) {
      for (var i = 0; i < permissions.length; i++) {
        var permission = permissions[i];
        if (permission.id === id) {
          return permission;
        }
      }
      return null;
    }


  </script>


@endsection
