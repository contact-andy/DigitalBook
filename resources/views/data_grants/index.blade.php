@extends('layouts.app') 
@section('title', 'Data Grant')
@section('content')
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Data Grant</h1>
        <div class="row">
            <div class="col-sm-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                         @php
                            $selectedUser = 0;
                            if(session('selectedUser'))
                                $selectedUser = session("selectedUser");
                            $applicationPermissionData = DB::table('dcb_application_permissions')
                            ->select('appId','campusId')->where('userId','=',$selectedUser)->get();  
                            $dataGrants = DB::table('data_grants')
                            ->select('appId','campusId','gradeLevelId','sectionId')
                            ->where('userId','=',$selectedUser)
                            ->get();  
                              
                            $userId = "";                
                            $userEmail = "";                
                        @endphp    
                        <div class="card-header">
                            <h5 class="card-title mb-0">User</h5>
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
                                    {{-- <button class="btn btn-primary" type="submit">Search!</button> --}}
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="campusId">Campus</label>
                                    <select class="form-control" id="campusId" name="campusId" onchange="onCampusChange(this.value)">
                                @foreach($campuses as $campus)
                                    <option value="{{$campus->id}}">{{$campus->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>

                        <div class="form-group">
                            <label for="appId">Application</label>
                            <select class="form-control" id="appId" name="appId" onchange="onApplicationChange(this.value)">
                                @foreach($appLists as $appList)
                                    <option value="{{$appList->id}}">{{$appList->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        {{-- <div class="form-group">
                            <label for="gradeLevelId">Grade-Level</label>
                            <select class="form-control" id="gradeLevelId" name="gradeLevelId">
                                @foreach($gradeLevels as $gradeLevel)
                                    <option value="{{$gradeLevel->id}}">{{$gradeLevel->level}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="sectionId">Section</label>
                            <select class="form-control" id="sectionId" name="sectionId">
                            </select>
                        </div> --}}
                            
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
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
                        @endif 
                        @if ($errors->any())
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

                        <div class="input-group mb-3">
                            @if($selectedUser!=0)
                                <div class="modal-body">
                                    <div class="form-group" style='flex:1;flex-direction:row;justify-content:space-around;margin-bottom:8px' > 
                                        <div class="flex-grow-1 ms-8">
                                            <strong>User</strong>
                                            <div class="text-muted">
                                               {{$userId}} | {{$userEmail}}
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-8">
                                            <strong>Campus</strong>
                                            <div class="text-muted" id='campusIdLabel'>
                                                Selected Campus
                                            </div>
                                        </div>
                                        
                                        <div class="flex-grow-1 ms-8">
                                            <strong>Application</strong>
                                            <div class="text-muted" id='appIdLabel'>
                                                Selected Application
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <form id="addTemplateForm" action="{{ route('data-grants.store') }}" method="POST" onsubmit="return validateForm()">
                                        @csrf
                                        <input type="hidden" id="dataGrantUserId" name="dataGrantUserId" value='{{$selectedUser}}' required/>
                                        <input type="hidden" id="dataGrantCampusId" name="dataGrantCampusId" required/>
                                        <input type="hidden" id="dataGrantAppId" name="dataGrantAppId" required/>
                                        <div class="form-group">
                                            <label for="gradeLevelId">Grade-Level/Section</label>
                                            <select class="form-control" id="gradeLevelIdSectionId" name="gradeLevelIdSectionId[]" multiple>
                                                {{-- @foreach($gradeLevels as $gradeLevel)
                                                    <option value="{{$gradeLevel->id}}">{{$gradeLevel->level}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <br>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="modal-body">
                                    <div class="form-group" style='flex:1;flex-direction:row;justify-content:space-around;margin-bottom:8px'> 
                                        <div class="flex-grow-1 ms-8">
                                            <strong>User</strong>
                                            <div class="text-muted">
                                               Not Selected
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-8">
                                            <strong>Campus</strong>
                                            <div class="text-muted" id='campusIdLabel'>
                                                -
                                            </div>
                                        </div>
                                        
                                        <div class="flex-grow-1 ms-8">
                                            <strong>Application</strong>
                                            <div class="text-muted" id='appIdLabel'>
                                                -
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <form id="addTemplateForm" action="{{ route('data-grants.store') }}" method="POST" onsubmit="return validateForm()">
                                        @csrf
                                        <input type="hidden" id="dataGrantUserId" name="dataGrantUserId" value='{{$selectedUser}}' required/>
                                        <input type="hidden" id="dataGrantCampusId" name="dataGrantCampusId" required/>
                                        <input type="hidden" id="dataGrantAppId" name="dataGrantAppId" required/>
                                        <div class="form-group">
                                            <label for="gradeLevelId">Grade-Level/Section</label>
                                            <select class="form-control" id="gradeLevelIdSectionId" disabled name="gradeLevelIdSectionId[]" multiple>
                                                {{-- @foreach($gradeLevels as $gradeLevel)
                                                    <option value="{{$gradeLevel->id}}">{{$gradeLevel->level}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <br>
                                        <div class="modal-footer">
                                            <button type="submit" disabled class="btn btn-primary">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    


    <script>
         // Convert Laravel's PHP event collection to JSON
        let allDataGrants = @json($dataGrants);
        let allCampuses = @json($campuses);
        let allAppLists = @json($appLists);
        let allGradeLevels = @json($gradeLevels);
        let allSections = @json($sections);
        
        let selectedCampusId = allCampuses.length?allCampuses[0].id:0;
        let selectedCampusaName = allCampuses.length?allCampuses[0].name:"Not Selected";
        let selectedAppId = allAppLists[0].id;
        let selectedAppTitle = allAppLists[0].title;
        
        console.log(selectedCampusaName)
        console.log(selectedAppTitle)
        document.getElementById('dataGrantCampusId').value = selectedCampusId;
        document.getElementById('dataGrantAppId').value = selectedAppId;

        document.getElementById('campusIdLabel').innerHTML  = selectedCampusaName
        document.getElementById('appIdLabel').innerHTML = selectedAppTitle
        //Load Grade-levels and sections
        
        onCampusChange(selectedCampusId);
        
        
        console.log(allDataGrants)
        function onCampusChange(campId)
        {
            for(let k=0;k<allCampuses.length;k++){
                if(allCampuses[k].id == campId){
                    selectedCampusaName = allCampuses[k].name;
                    break;
                }
            }
            document.getElementById('campusIdLabel').innerHTML  = selectedCampusaName
            document.getElementById('dataGrantCampusId').value = campId;
            let  selectedAppId = document.getElementById('appId').value;
            const gradeLevelIdSectionId = document.getElementById('gradeLevelIdSectionId');
            gradeLevelIdSectionId.innerHTML = '';

            console.log(selectedAppId)
            const options = allGradeLevels.map(gLevel => {
                if(gLevel.campusId == campId){
                    let allSectionCollection = "";
                    for(let i=0;i<allSections.length;i++){
                        if(allSections[i].campusId == campId){
                            let checkPermission =0;
                            for(let j=0;j<allDataGrants.length;j++){
                                // console.log(allDataGrants[j].campusId +" and "+campId)
                                // console.log(allDataGrants[j].appId+" and "+selectedAppId)
                                // console.log(allDataGrants[j].gradeLevelId+" and "+gLevel.id )
                                // console.log(allDataGrants[j].sectionId+" and "+allSections[i].id)
                                if(allDataGrants[j].campusId == campId && 
                                allDataGrants[j].appId == selectedAppId && 
                                allDataGrants[j].gradeLevelId == gLevel.id 
                                && allDataGrants[j].sectionId == allSections[i].id)
                                {
                                    checkPermission =1 ;
                                    break;
                                }
                            }
                            if(checkPermission == 1)
                                allSectionCollection +=  `<option selected value="${gLevel.id}-${allSections[i].id}">${gLevel.level}${allSections[i].title}</option>`;
                            else
                                allSectionCollection +=  `<option value="${gLevel.id}-${allSections[i].id}">${gLevel.level}${allSections[i].title}</option>`;
                        }
                    }
                    return allSectionCollection;
                }
            }).join(''); 
            // console.log(options)
            gradeLevelIdSectionId.innerHTML = options;
        }

        function onApplicationChange(selectedAppId)
        {
            for(let k=0;k<allAppLists.length;k++){
                if(allAppLists[k].id == selectedAppId){
                    selectedAppTitle = allAppLists[k].title;
                    break;
                }
            }
            document.getElementById('appIdLabel').innerHTML  = selectedAppTitle
            document.getElementById('dataGrantAppId').value = selectedAppId;
            let  campId = document.getElementById('campusId').value;
            const gradeLevelIdSectionId = document.getElementById('gradeLevelIdSectionId');
            gradeLevelIdSectionId.innerHTML = '';
            const options = allGradeLevels.map(gLevel => {
                if(gLevel.campusId == campId){
                    let allSectionCollection = "";
                    for(let i=0;i<allSections.length;i++){
                        if(allSections[i].campusId == campId){
                            let checkPermission =0;
                            for(let j=0;j<allDataGrants.length;j++){
                                // console.log(allDataGrants[j].campusId +" and "+campId)
                                // console.log(allDataGrants[j].appId+" and "+selectedAppId)
                                // console.log(allDataGrants[j].gradeLevelId+" and "+gLevel.id )
                                // console.log(allDataGrants[j].sectionId+" and "+allSections[i].id)
                                if(allDataGrants[j].campusId == campId && 
                                allDataGrants[j].appId == selectedAppId && 
                                allDataGrants[j].gradeLevelId == gLevel.id 
                                && allDataGrants[j].sectionId == allSections[i].id)
                                {
                                    checkPermission =1 ;
                                    break;
                                }
                            }
                            if(checkPermission == 1)
                                allSectionCollection +=  `<option selected value="${gLevel.id}-${allSections[i].id}">${gLevel.level}${allSections[i].title}</option>`;
                            else
                                allSectionCollection +=  `<option value="${gLevel.id}-${allSections[i].id}">${gLevel.level}${allSections[i].title}</option>`;
                        }
                    }
                    return allSectionCollection;
                }
            }).join(''); 
            // console.log(options)
            gradeLevelIdSectionId.innerHTML = options;
        }
            // const gradeLevelId = document.getElementById('gradeLevelId');
            // gradeLevelId.innerHTML = '';
            // const gradeLevelOptions = allGradeLevels.map(gLevel => {
            //     if(gLevel.campusId == campId){
            //         return `<option value="${gLevel.id}">${gLevel.level}</option>`;
            //     }
            // }).join(''); 
            // gradeLevelId.innerHTML = gradeLevelOptions;
            
            // const sectionId = document.getElementById('sectionId');
            // sectionId.innerHTML = '';
            // const sectionOptions = allSections.map(section => {
            //     if(section.campusId == campId){
            //         return `<option value="${section.id}">${section.title}</option>`;
            //     }
            // }).join(''); 
            // sectionId.innerHTML = sectionOptions;
        
	</script>
@endsection