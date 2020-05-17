@extends('default.layouts.main')
@section('content')
  @include('default.layouts.options',getOptions($model,$model::getTitle(),$model::getPluralTitle(),$route))
  <form action="" id="recycle-form" method="post">
    @csrf
    @method('DELETE')
    <div class="table-responsive">
      <table id="default-datatable" class="table table-bordered table-hover">
        <thead>
        <tr>
          <th style="width: 20px !important;">انتخاب</th>
          @foreach($model::initializedFields() as $field)
            @if($field->showInAdmin)
              <th>{{$field->label}}</th>
            @endif
          @endforeach
          <td>عملیات</td>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $record)
          <tr>
            <td style="width: 20px">
              <div style="padding-right: 30px" class="p_child">
                <div class="icheck-material-success">
                  <input type="checkbox" id="success_{{$record->id}}" name="records[]" value="{{$record->id}}" class="select-checkbox">
                  <label style="font-weight: bold" class="f12" for="success_{{$record->id}}"></label>
                </div>
              </div>
            @foreach($model::initializedFields() as $field)
              @if($field->showInAdmin)
                @if($field->switchable)
                  <td>
                    <?php $fillable = $field->fillable; ?>
                    @if($record->$fillable)
                      <a href="/admin/{{$route}}/{{$record->id}}?switch={{$field->fillable}}" class="btn btn-success">{{$field->switchable[0]}}</a>
                    @else
                      <a href="/admin/{{$route}}/{{$record->id}}?switch={{$field->fillable}}" class="btn btn-danger">{{$field->switchable[1]}}</a>
                    @endif
                  </td>
                @else
                  <?php
                  $fillable = $field->fillable;
                  ?>
                  <td>{{$record->$fillable}}</td>
                @endif
              @endif
            @endforeach
            <td class="tac actions" data-delete="true" data-edit="true" data-name="{{$model::getTitle()}}" data-route="{{$route}}" data-id="{{$record->id}}"></td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </form>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      //Default data table
      $('#default-datatable').DataTable();


      var table = $('#example').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
      });

      table.buttons().container()
        .appendTo('#example_wrapper .col-md-8:eq(0)');
    });

  </script>
@endsection