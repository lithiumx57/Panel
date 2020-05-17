<?php
$actions = $model::initializedOptions();
$isRecycleEnabled = false;

foreach ($actions as $action) {
  if ($action->type == Action::RECYCLE_BIN) {
    $isRecycleEnabled = true;
  }
}
?>

<div class="navBox">
  <h1 style="direction: rtl">
    <a href="/admin/"><span class="fa fa-home"></span>&nbsp;<span><span>داشبورد</span></span></a>
    @isset($path)
      @foreach($path as $p)
        <span class="fa fa-angle-left"></span>
        @if($p['url']=="")
          <?php $link = ""; ?>
        @else
          <?php $link = "/admin/" . $p['url'] ?>
        @endif
        <a href="{{$link}}"><span><span>{{$p['title']}}</span></span></a>
      @endforeach
      @isset($create)
        <span class="fa fa-angle-left"></span>
        <a href="{{$link}}"><span>{{xText(TEXT_CREATE)}} {{$name}} {{xText(TEXT_NEW)}}</span></a>
      @endisset
      @isset($edit)
        <span class="fa fa-angle-left"></span>
        <a href="{{$link}}"><span>{{xText(TEXT_EDIT)}} {{$name}}</span></a>
      @endisset

      @if(isRecycleBinMode() && !isCreateOrEditMode())
        @if ($isRecycleEnabled)
          <span class="fa fa-angle-left"></span>
          <a href=""><span><span>سطل زباله</span></span></a>
        @endif

      @endif
    @endisset


  </h1>
  @if(isset($showOptions) && $showOptions)
    <div class="dropdown options">
      <button type="button" style="direction: rtl" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true">
        گزینه ها
      </button>
      <div class="dropdown-menu">
        @if(isCreateOrEditMode())
          <?php
          if (isset($routeData)) {
            $indexRoute = url(getQueryLink($routeData, "/admin/" . $route));
          } else {
            $indexRoute = url("/admin/" . $route);
          }
          ?>
          <a data-toggle="tooltip" data-placement="right" title="مشاهده همه {{$name}} ها" href="{{$indexRoute}}">
            <i class="fa fa-list"></i>
            <span>{{$name}} ها</span>
          </a>
        @else
          <?php
          if (isset($routeData)) {
            $createRoute = url(getQueryLink($routeData, "/admin/" . $route . "/create"));
          } else {
            $createRoute = url("/admin/" . $route . "/create");
          }
          ?>

          <a data-toggle="tooltip" data-placement="right" title="ثبت یک {{$name}} جدید" href="{{isset($routeCreate)?$routeCreate:$createRoute}}">
            <i class="fa fa-pencil"></i>
            <span> ساخت {{$name}} جدید</span>
          </a>
        @endif

        @if(isRecycleBinMode())
          @if(!isCreateOrEditMode())
            <?php
            if (isset($routeData)) {
              $indexLink = url(getQueryLink($routeData, "/admin/" . $route));
            } else {
              $indexLink = url("/admin/" . $route);
            }
            ?>
            <a data-toggle="tooltip" data-placement="right" title="مشاهده همه {{$name}} ها" href="{{$indexLink}}">
              <i class="fa fa-list"></i>
              <span>{{$name}} ها</span>
            </a>
          @endif
          @if ($isRecycleEnabled)
            <a data-toggle="tooltip" data-placement="right" title="همه {{$name}} های انتخاب شده برای همیشه حذف می شوند" class="form-item disabled multipleDelete" onclick="multipleDelete('/admin/'+'{{$route}}'+'/-1?recycle-bin=true&mode=deleteForEver','{{$name}}','deleteForEver')">
              <i class="fa fa-remove"></i>
              <span>حذف برای همیشه</span>
            </a>

            <a data-toggle="tooltip" data-placement="right" title="همه ی {{$name}} های انتخاب شده بازیابی می شوند" class="form-item disabled multipleDelete" onclick="multipleDelete('/admin/'+'{{$route}}'+'/-1?recycle-bin=true&mode=restore','{{$name}}','restore')">
              <i class="fa fa-refresh"></i>
              <span>بازیافت {{$name}} ها</span>
            </a>
          @endif

            @foreach ($actions as $action)
              @if($action->type==Action::SWITCH)
                <a data-toggle="tooltip" data-placement="right" title="{{$action->title . " همه ".$name." انتخاب شده "}}" class="form-item disabled multipleDelete" onclick="multipleChange('{{$route}}','{{$name}}','{{$action->fillable}}')">
                  <i class="fa fa-recycle"></i>
                  <span>{{$action->title}}</span>
                </a>
              @endif
            @endforeach

        @else
          <?php
          if (isset($routeData)) {
            $recycleBinRoute = url(getQueryLink($routeData, "/admin/" . $route, true));
          } else {
            $recycleBinRoute = url(getQueryLink([], "/admin/" . $route, true));
          }
          ?>


          @if ($isRecycleEnabled)
            @if(!(isset($hasRecycleBin) && $hasRecycleBin==false))
              <a data-toggle="tooltip" data-placement="right" title="باز کردن سطل زباله برای {{$name}} ها" href="{{$recycleBinRoute}}">
                <i class="fa fa-trash"></i>
                <span> سطل زباله ( {{$count}} )</span>
              </a>
            @elseif((isset($hasRecycleBin) && $hasRecycleBin==true))
              <a data-toggle="tooltip" data-placement="right" title="باز کردن سطل زباله برای {{$name}} ها" href="{{$recycleBinRoute}}">
                <i class="fa fa-trash"></i>
                <span> سطل زباله ( {{$count}} )</span>
              </a>
            @endif
          @endif

          @if(!isCreateOrEditMode())

            <?php
            $message = "";
            if ($isRecycleEnabled) {
              $message = "همه " . $name . " های انتخاب شده به سطل زباله منتقل می شوند";
              $mode = "delete";
            } else {
              $mode = "deleteForEver";
              $message = "همه " . $name . " های انتخاب شده برای همیشه حذف می شوند";
            }
            ?>
            @if(!isCreateOrEditMode())
              <a data-toggle="tooltip" data-placement="right" title="{{$name}}" class="form-item disabled multipleDelete" onclick="multipleDelete('/admin/'+'{{$route}}'+'/-1?recycle-bin=true&mode=delete','{{$name}}','{{$mode}}')">
                <i class="fa fa-remove"></i>
                <span>حذف {{$name}} ها</span>
              </a>
            @endif

            @foreach ($actions as $action)
              @if($action->type==Action::SWITCH)
                <a data-toggle="tooltip" data-placement="right" title="{{$action->title . " همه ".$name." انتخاب شده "}}" class="form-item disabled multipleDelete" onclick="multipleChange('{{$route}}','{{$name}}','{{$action->fillable}}')">
                  <i class="fa fa-recycle"></i>
                  <span>{{$action->title}}</span>
                </a>
              @endif
            @endforeach


          @endif
        @endif
      </div>
    </div>


  @endif

  @isset($dropdown)
    @if($dropdown!=null)
      {!! $dropdown !!}
    @endif
  @endisset

  <div class="clearfix"></div>
</div>