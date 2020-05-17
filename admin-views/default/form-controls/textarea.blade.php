<div class="form-group {{$row->responsive}} {{$row->parentClass}} @if(!strpos(" ".$row->parentClass,"col-")) li-form @endif">
  <label for="{{$name}}">{{$row->label}}</label>
  <textarea
    aria-placeholder="{{$row->placeholder}}"
    aria-label="{{$row->label}}"
    type="number"
    id="{{$name}}"
    class="form-control {{$row->classes}}"
    name="{{$name}}"
    placeholder="{{$row->placeholder}}"
  >
    {{old($name,$row->getDefault())}}
  </textarea>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    setupEditor({{$name}})
  })
</script>