<div class="form-group {{$row->responsive}} {{$row->parentClass}} @if(!strpos(" ".$row->parentClass,"col-")) li-form @endif">
  <label for="tag{{$name}}">{{$row->label}}</label>
  <br>
  <input id="tag{{$name}}"  type="text" class="form-control tag-input {{$row->classes}}" placeholder="{{$row->placeholder}}">
  <span id="addTag{{$name}}" class="btn btn-success tag-button">افزودن</span>
  <input type="hidden" name="{{$name}}" id="{{$name}}" value="{{old($name)}}">
</div>

<br><br>
<div class="form-group col-md-12 col-xl-8">
  <div id="t_container{{$name}}">
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var tagContainer = document.getElementById("t_container{{$name}}");
    var oldTags = '{{old($name)}}';

    if (oldTags === "") {
      document.getElementById("{{$name}}").value = ""
    }

    oldTags = oldTags.split("|");
    for (var i = 0; i < oldTags.length; i++) {
      if (oldTags[i].trim().length === 0) {
        continue;
      }
      addTag(oldTags[i]);
    }

    var addTagButton = document.getElementById("addTag{{$name}}")


    addTagButton.addEventListener("click", function () {

      var tagInput = document.getElementById("tag{{$name}}")
      var tagInputValue = tagInput.value


      var array = tagInputValue.split("|")
      for (var t in array) {
        var tag = array[t];
        addTag(tag)
      }
      tagInput.value = "";
    })


    function deleteTag(tag, text) {
      var tagsInput = document.getElementById("{{$name}}")
      tagsInput.value = tagsInput.value.replace("|" + text + "|", "")
      tag.parentNode.remove()
    }

    function addTag(title) {
      if(title.trim()==="") return
      var hiddenTagInput = document.getElementById("{{$name}}")
      var hiddenTagInputValue = hiddenTagInput.value
      hiddenTagInput.value = hiddenTagInputValue + "|" + title + "|"

      var newTag = document.createElement("span")
      newTag.classList.add("tagItem")
      var span = document.createElement("span")
      span.innerText = title
      newTag.appendChild(span)
      var icon = document.createElement("span")
      icon.classList.add("fa", "fa-close", 'removeItem')
      icon.addEventListener("click", function () {
        deleteTag(icon, title)
      })
      newTag.appendChild(icon)
      tagContainer.appendChild(newTag)
    }
  })


</script>