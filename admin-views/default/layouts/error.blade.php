@if($errors->any())
  <div class="col-md-8 col-xs-12">
    <ul class="alert alert-danger admin-error">
      @foreach($errors->all() as $row)
        <li>{{$row}}</li>
      @endforeach
    </ul>
  </div>
@endif