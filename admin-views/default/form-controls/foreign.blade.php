<?php
$primaryKey = $row->primaryKey;
$renderField = $row->renderField;
?>
<div class="form-group {{$row->responsive}} {{$row->parentClass}} @if(!strpos(" ".$row->parentClass,"col-")) li-form @endif">
  <label for="{{$name}}">{{$row->label}}</label>
  <select name="{{$name}}" id="{{$name}}" class="form-control {{$row->classes}} @if($row->smartSelect) selectpicker @endif" @if($row->smartSelect) data-live-search="true" @endif @if($row->multiple) multiple @endif>
    @foreach($row->getForeignRows() as $m)
      <option
        @if(old($name,$row->getDefault())==$m->$primaryKey) selected @endif
      value="{{$m->$primaryKey}}">
        {{$m->$renderField}}
      </option>
    @endforeach
  </select>
</div>
