<div class="form-group {{$row->responsive}} {{$row->parentClass}} @if(!strpos(" ".$row->parentClass,"col-")) li-form @endif">

  <div class="image-field">
    <div class="tac mt-4">
      <span class="btn btn-info upload-button" id="selectImage{{$name}}">انتخاب تصویر</span>
    </div>
    <input type="file" id="file{{$name}}" name="{{$name}}" class="hidden" accept="image/*">
    <div class="tac mt-4">

      <?php
      $path = "";
      if ($isEditMode) {
        if (is_string($object->$name)) {
          $path = $object->$name;
        } else if (is_array($object->$name)) {
          $path = $object->$name[$row->imageSizes[0]];
        }
        $path=public_path("files/uploads/" . $object::getRoute() . "/" . $path);
      }

      ?>
      <img src="{{$path}}" alt="" id="image{{$name}}" style="width: 250px;border-radius: 4px;">
      <div id="text{{$name}}Container" class="image-name-container">
        <span class="key">نام فایل: </span> <span class="value" id="text{{$name}}"></span>
      </div>
    </div>
  </div>

  <div class="icheck-material-success p_parent {{$row->parentClass}} @if(!strpos(" ".$row->parentClass,"col-")) li-form @endif">
    <input
      @if(old($name,$row->getDefault())) checked @endif
    class="{{$row->classes}}"
      value="1"
    >
  </div>
</div>

<script>

  document.addEventListener("DOMContentLoaded", function () {
    $("#selectImage{{$name}}").click(function () {
      $("#file{{$name}}").click()
    })

    $("#file{{$name}}").on("change", function (event) {
      var fr = new FileReader()
      fr.readAsDataURL(event.target.files[0])
      fr.onload = function () {
        var image = document.getElementById('image{{$name}}')
        image.src = fr.result;
        document.getElementById("selectImage{{$name}}").innerText = "تغییر تصویر"
        document.getElementById("text{{$name}}").innerText = event.target.files[0].name
        document.getElementById("text{{$name}}Container").style.display = "block"
      }
    })
  })

  function renderImage(event) {
    console.log(event)
  }
</script>