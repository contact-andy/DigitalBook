@php
    $appList = DB::table('dcb_application_lists')->where('status','=',1)->orderBy('id','asc')->get();
    $appCategory = DB::table('dcb_application_categories')->where('status','=',1)->get();

    $appCount=0;
    $userId=Auth::user()->id;
    $appListData = DB::table('dcb_application_permissions')->select('appId')->where('userId', $userId)
    ->orderBy('appId','asc')->distinct('appId')->get();
    $appListDataIdColl=array();
    // echo $appListData;
    foreach($appListData as $app)
    {
        $appListDataIdColl[]= $app->appId;
    }
    // echo $appListDataIdColl;
    $appListCatData = DB::table('dcb_application_permissions')->select('appCatId')
    ->join('dcb_application_lists','dcb_application_lists.id','=','dcb_application_permissions.appId')
    ->where('userId', $userId)
    ->orderBy('appId','asc')->distinct('appCatId')->get();
    $appCatDataIdColl=array();
    // echo $appListData;
    foreach($appListCatData as $app)
    {
        $appCatDataIdColl[]= $app->appCatId;
    }
                    
@endphp
<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/">
            <i data-lucide="book-open-text" style="font-size: 50px"></i>
            <span class="align-middle me-3">{{ config("app.name") }}</span>
        </a>

        <ul class="sidebar-nav">
            {{--
            <li class="sidebar-header">Navigation</li>
            --}}
            <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }} {{ Request::is('/') ? 'active' : '' }}" >
                <a href="{{ route('dashboard') }}" class="sidebar-link">
                    <i class="align-middle" data-lucide="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                    {{-- <span class="badge badge-sidebar-primary">5</span> --}}
                </a>
            </li>
            
            @foreach ($appCategory as $appCat)
                @php 
                    $checkAppCatStatus=0;
                @endphp
                @foreach($appCatDataIdColl as $arr)
                    @if($arr==$appCat->id)
                        @php 
                            $checkAppCatStatus=1;
                            // break;
                        @endphp
                    @endif
                @endforeach

                @if($checkAppCatStatus==0)
                    @continue
                @endif
                <li class="sidebar-item 
                    @foreach ($appList as $app)
                        @if($app->appCatId==$appCat->id)
                            {{ Request::is($app->url) ? 'active' : '' }} 
                        @endif
                    @endforeach
                ">
                    <a data-bs-target="#menu{{$appCat->id}}" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-lucide="{{$appCat->icon}}"></i>
                        <span class="align-middle">{{$appCat->title}}</span>
                    </a>

                    <ul
                        id="menu{{$appCat->id}}"
                        class="sidebar-dropdown list-unstyled collapse 
                            @foreach ($appList as $app)
                                @if($app->appCatId==$appCat->id)
                                    {{ Request::is($app->url) ? 'show' : '' }} 
                                @endif
                            @endforeach                            
                        "
                        data-bs-parent="#sidebar"
                    >
                        @foreach ($appList as $app)
                            @php 
                                $checkAppStatus=0;
                            @endphp
                            @if($app->appCatId==$appCat->id)
                                @foreach($appListDataIdColl as $arr)
                                    @if($arr==$app->id)
                                        @php   
                                            $checkAppStatus=1;
                                        @endphp
                                    @endif
                                @endforeach

                                @if($checkAppStatus==0)
                                    @continue
                                @endif
                                 <li class="sidebar-item {{ Request::is($app->url) ? 'active' : '' }}">
                                    <a class="sidebar-link" href="{{ route($app->url.'.index') }}">
                                        {{$app->title}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</nav>
