<div class="form-group {{$row->responsive}} @if($row->parentClass =="") db @else dib @endif">
  <label for="{{$name}}">{{$row->label}}</label>
  <input
    aria-placeholder="{{$row->placeholder}}"
    aria-label="{{$row->label}}"
    type="text"
    id="{{$name}}"
    class="form-control {{$row->classes}}"
    name="{{$name}}"
    @if($isEditMode)
    value="{{old($name,$object->$name)}}"
    @else
    value="{{old($name,$row->getDefault())}}"
    @endif
    placeholder="{{$row->placeholder}}"
  >
</div>
