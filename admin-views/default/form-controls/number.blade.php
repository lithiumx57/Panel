<div class="form-group {{$row->responsive}} {{$row->parentClass}} @if(!strpos(" ".$row->parentClass,"col-")) li-form @endif">
  <label for="{{$name}}">{{$row->label}}</label>
  <input
    aria-placeholder="{{$row->placeholder}}"
    aria-label="{{$row->label}}"
    type="number"
    id="{{$name}}"
    class="form-control {{$row->classes}}"
    name="{{$name}}"
    value="{{old($name,$row->getDefault())}}"
    placeholder="{{$row->placeholder}}"
  >
</div>
