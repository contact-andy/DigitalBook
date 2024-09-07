@extends('layouts.app') 
@section('title', 'Application Grant')
@section('content')
<div class="container-fluid p-0">
    @if(session('success'))
    <div class="alert alert-success alert-outline alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-icon">
            <i class="align-middle" data-lucide="bell"></i>
        </div>
        <div class="alert-message">
            <strong> {{ session("success") }}</strong>
        </div>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-outline alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-icon">
            <i class="align-middle" data-lucide="bell"></i>
        </div>
        <div class="alert-message">
            <strong> {{ session("error") }}</strong>
        </div>
    </div>
    @elseif(session('info'))
    <div class="alert alert-info alert-outline alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>
        <div class="alert-icon">
            <i class="align-middle" data-lucide="bell"></i>
        </div>
        <div class="alert-message">
            <strong> {{ session("info") }}</strong>
        </div>
    </div>
    @endif @if ($errors->any())
    <div class="alert alert-danger alert-outline alert-dismissible" role="alert" >
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>
        <div class="alert-icon">
            <i class="align-middle" data-lucide="bell"></i>
        </div>
        <div class="alert-message">
            <strong>
                @foreach ($errors->all() as $error)
                {{ $error }}
                @endforeach
            </strong>
        </div>
    </div>
    @endif
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3>Application Grant</h3>
        </div>

       
    </div>

    <div class="row" style="margin-top: 0px">
        <div class="col-12">
            <div class="card">
                @php
                    $selectedUser = 0;
                    if(session('selectedUser'))
                        $selectedUser = session("selectedUser");
                    $applicationPermissionData = DB::table('dcb_application_permissions')
                    ->select('appId','campusId')->where('userId','=',$selectedUser)->get();    
                    $userId = "";                
                    $userEmail = "";                
                @endphp    
                <div class="card-header">
                    <h5 class="card-title mb-0">Select User</h5>
                </div>
                <div class="card-body" style="margin-top:-30px;">
                    <form id="userSelectionForm" name="userSelectionForm" action="{{ route('after-user-selection') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <select class="form-select flex-grow-1" name="userId" id="userId" onChange="userSelectionForm.submit();" >
                                <option value={{0}}>Select...</option>
                                @foreach ($users as $user)
                                    @if($user->id == $selectedUser)
                                        <option selected value="{{$user->id}}">{{$user->userId}} - {{$user->email}}</option>
                                        @php
                                            $userId = $user->userId;                
                                            $userEmail = $user->email;
                                        @endphp     
                                    @else
                                        <option value="{{$user->id}}">{{$user->userId}} - {{$user->email}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="submit">Search!</button>
                        </div>
                         <div class="input-group mb-3">
                            @if($selectedUser!=0)
                                <div style='flex:1;flex-direction:row;justify-content:space-around'>    
                                    <span class='badge text-bg-primary' style="font-size: 12px;font-weight:300;padding:10px;">
                                        User Id: {{$userId}}
                                        <br>
                                        Email: {{$userEmail}}
                                    </span>
                                </div>
                                
                            @endif
                         </div>
                    </form>
                    
                </div>

                <form id="grantForm" name='grantForm' action="{{ route('application-grant.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="userId" name="userId" value="{{$selectedUser}}" required />
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:30%;">
                                    @if($selectedUser!=0)
                                        <button style='' class="btn btn-primary" type="submit">Save</button>                                        
                                    @endif
                                </th>
                                <th style='text-align:center;' colspan="{{sizeof($campuses)}}">
                                    Campuses
                                </th>
                            </tr>
                            <tr>
                                <th style="width:30%;">Application Name</th>
                                @foreach($campuses as $campuse)
                                    <th class="d-none d-md-table-cell" style='text-align:center;'>
                                        @if($selectedUser!=0)
                                            <input 
                                                class="form-check-input fs-4" 
                                                type="checkbox" value="1" 
                                                name="campus_{{$campuse->id}}" 
                                                id="campus_{{$campuse->id}}"
                                                onchange="checkedApplication('allApplication',{{$campuse->id}})"
                                            >
                                            <br>
                                        @endif
                                        {{$campuse->name}}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applicationList as $appList)
                                <tr>
                                    <td> 
                                        @if($selectedUser!=0)
                                            <input 
                                                class="form-check-input fs-4" 
                                                style='margin-right:10px' 
                                                type="checkbox" value="1" 
                                                name="app_{{$appList->id}}" 
                                                id="app_{{$appList->id}}"
                                                onchange="checkedApplication('allCampus',{{$appList->id}})"
                                            >
                                        @endif
                                        {{$appList->title}}
                                    </td>
                                    @foreach($campuses as $campuse)
                                        @php $counter1=0;@endphp
                                        <td style='text-align:center;'>
                                            @if($selectedUser!=0)
                                                @foreach($applicationPermissionData as $def)
                                                    @if($def->appId==$appList->id && $def->campusId==$campuse->id)
                                                        <input checked class="form-check-input fs-4" type="checkbox" value="1" name="app_{{$appList->id}}_campus_{{$campuse->id}}" id="app_{{$appList->id}}_campus_{{$campuse->id}}">
                                                        @php $counter1=1;@endphp
                                                        @break;
                                                    @endif
                                                @endforeach
                                                @if($counter1==0)
                                                    <input class="form-check-input fs-4" type="checkbox" value="1" name="app_{{$appList->id}}_campus_{{$campuse->id}}" id="app_{{$appList->id}}_campus_{{$campuse->id}}">
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Convert Laravel's PHP event collection to JSON
    let applicationList = @json($applicationList);
    let campuses = @json($campuses);
    function checkedApplication(type, id){
        if(type === 'allCampus'){
            var isChecked = document.getElementById("app_"+id).checked;
            campuses.map(function(campus) {
                let appCampusId = `app_${id}_campus_${campus.id}`;
                if(isChecked){
                    document.getElementById(appCampusId).checked =  true;
                    // alert("All campus CHECKED for the app id:"+ id);
                }
                else{
                    document.getElementById(appCampusId).checked =  false;
                    // alert("All campus UNCHECKED for the app id:"+ id);
                }
            })
        }
        else if(type === 'allApplication'){
            var isChecked = document.getElementById("campus_"+id).checked;
            applicationList.map(function(appList) {
                let appCampusId = `app_${appList.id}_campus_${id}`;
                if(isChecked){
                    document.getElementById(appCampusId).checked =  true;
                    // alert("All campus CHECKED for the app id:"+ id);
                }
                else{
                    document.getElementById(appCampusId).checked =  false;
                    // alert("All campus UNCHECKED for the app id:"+ id);
                }
            })
        }
    }

</script>
@endsection
