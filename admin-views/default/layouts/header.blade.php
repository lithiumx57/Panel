<div class="loader-wrapper">
  <div class="lds-ring">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>
</div>

<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
  <div class="brand-logo">
    {{--    <img src="{{asset('admin/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">--}}
    <h5 class="logo-text">پنل مدیریت</h5>
  </div>
  <script>
    function logout() {
      $("#logout-form-admin").submit();
    }
  </script>

  <ul class="sidebar-menu do-nicescrol">
    @foreach (\App\Panel\AdminDynamicModels::getModels() as $model)
      <li>
        <a href="javaScript:void(1);" class="waves-effect">
          <i class="zmdi zmdi-card-travel"></i>
          <span>{{$model->getPluralTitle()}} </span>
          <i class="fa fa-angle-left pr"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{$model->getIndexRoute()}}"><i class="zmdi zmdi-long-arrow-right"></i>همه {{$model->getPluralTitle()}}</a></li>
          <li><a href="{{$model->getCreateRoute()}}"><i class="zmdi zmdi-long-arrow-right"></i>ایجاد {{$model->getTitle()}}</a></li>
        </ul>
      </li>
    @endforeach
    @include('nav')
  </ul>
</div>
<header class="topbar-nav">
  <nav class="navbar navbar-expand fixed-top">
    <ul class="navbar-nav mr-auto align-items-center" style="float: left">
      <li class="nav-item">
        <a class="nav-link toggle-menu" href="">
          <i class="icon-menu menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>
</header>