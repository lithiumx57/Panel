<!DOCTYPE html>
<html lang="en" id="html">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf">
  <title>پنل مدیریت</title>
{{--  <script src="{{asset('files/frontend/public/js/jquery-3.4.1.min.js')}}"></script>--}}
  <link rel="stylesheet" href="{{asset('admin/css/app.css')}}">
  <script src="{{asset('admin/js/sweetalert.min.js')}}"></script>
  <link rel="stylesheet" href="{{asset('admin/css/admin-style.css')}}">
  @yield('style')
</head>

<body class="bg-theme bg-theme2">
<div id="wrapper">
  @include('default.layouts.header')
  <div class="clearfix"></div>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div id="main">
        @yield('content')
      </div>
    </div>
  </div>
  <a href="javaScript:void(0);" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
  @include('default.layouts.footer')

</div>
<script src="{{asset('admin/js/app.js')}}"></script>
<script src="{{asset('admin/js/admin.js')}}"></script>

<script>
  {{--var flashAlert = JSON.parse('{!! getFlashAlert() !!}');--}}
  // if (flashAlert["title"] != null) {
  //   Swal.fire({
  //     title: flashAlert["title"],
  //     type: flashAlert["kind"],
  //     confirmButtonColor: '#3085d6',
  //     confirmButtonText: 'بسیار خب',
  //   }).then((result) => {
  //   });
  // }
  //
  // $(function () {
  //   $(".knob").knob();
  // });
</script>
<script src="{{asset('files/frontend/public/js/pusher.min.js')}}"></script>
{{--@include('admin.layouts.notifications')--}}
@yield('script')
</body>
</html>