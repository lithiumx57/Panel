@extends('default.layouts.main')
@section('content')
  @include('default.layouts.error')
  @include('default.layouts.options',getOptions($model,$model::getTitle(),$model::getPluralTitle(),$route))
  <form action="{{url("admin/".$route)}}@if($isEditMode)/{{$object->id}}@endif" method="post" enctype="multipart/form-data">
    @csrf
    @if($isEditMode) @method("PATCH") @endif
    <input type="hidden" name="filters" value="{{json_encode($model::initializedFields())}}">
    @foreach($model::initializedFields() as $key=> $row)
      @if($row->show)
        @include('default.form-controls.'.$row->type,['row'=>$row,"name"=>$row->fillable])
        <div class="clearfix"></div>
      @endif
    @endforeach
    <div class="form-group col-md-8">
      @if ($isEditMode)
        <button class="btn btn-primary">به روز رسانی</button>
      @else
        <button class="btn btn-primary">ثبت</button>
      @endif
    </div>
  </form>
@endsection

@section('script')
  <?php
  $isAddedCkEditor = false;
  $isAddedBootstrapSelect = false;
  ?>
  @foreach($model::initializedFields() as $row)
    @if($row->isSmartEditor)

      @if(!$isAddedCkEditor)
        <script src="{{asset('admin/js/ckeditor/ckeditor.js')}}"></script>
        <?php
        $isAddedCkEditor = true;
        ?>
      @endif

    @elseif($row->smartSelect)
      @if(!$isAddedBootstrapSelect)
        <link rel="stylesheet" href="{{asset('admin/css/bootstrap-select.min.css')}}">
        <script src="{{asset('admin/js/bootstrap-select.min.js')}}"></script>
        <?php
        $isAddedCkEditor = true;
        ?>
      @endif
    @endif


  @endforeach


@endsection