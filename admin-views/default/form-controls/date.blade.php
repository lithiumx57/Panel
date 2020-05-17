<?php
$unique = rand(0, 999999)
?>
<div class="form-group {{$row->responsive }}" style="margin-right: 5px">
  <div class="icheck-material-success p_parent {{$row->parentClass}} @if(!strpos(" ".$row->parentClass,"col-")) li-form @endif">
    <input
      @if(old($name,$row->getDefault())) checked @endif
    type="checkbox"
      id="{{$name.$unique}}"
      name="{{$name}}"
      class="{{$row->classes}}"
      value="1"

      @if($isEditMode)
      @if($object->$name)
      checked
      @endif
      @elseif($row->checked)
      checked
      @endif

    >
    <label class="f15" for="{{$name.$unique}}">{{$row->label}}</label>
  </div>
</div>