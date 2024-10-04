@extends('layouts.app') 
@section('title', 'Publish Messages')
@section('content')
    <div class="container-fluid p-0">
        
        @php
            $selectedCampus = 0;
            $selectedCampusName = "EMPTY";
            if(session('selectedCampus')){
                $selectedCampus = session("selectedCampus");         
                foreach($campuses as $campus){
                    if($campus->id == $selectedCampus){
                        $selectedCampusName = $campus->name;
                        break;
                    }
                }
            }
            else{
                foreach($campuses as $campus){
                    $selectedCampusName = $campus->name;
                    $selectedCampus = $campus->id;
                    break;
                }
            }

            $selectedGradeLevel = 0;
            $selectedGradeLevelName = "EMPTY";
            if(session('selectedGradeLevel')){
                $selectedGradeLevel = session("selectedGradeLevel");         
                foreach($gradeLevels as $gradeLevel){
                    if($gradeLevel->id == $selectedGradeLevel){
                        $selectedGradeLevelName = $gradeLevel->level;
                        break;
                    }
                }
            }
            else{
                foreach($gradeLevels as $gradeLevel){
                    if($gradeLevel->campusId == $selectedCampus){
                        $selectedGradeLevelName = $gradeLevel->level;
                        $selectedGradeLevel = $gradeLevel->id;
                        break;
                    }
                }
            }

            $selectedSection = 0;
            $selectedSectionName = "EMPTY";
            if(session('selectedSection')){
                $selectedSection = session("selectedSection");         
                foreach($sections as $section){
                    if($section->id == $selectedSection){
                        $selectedSectionName = $section->title;
                        break;
                    }
                }
            }
            else{
                foreach($sections as $section){
                    if($section->campusId == $selectedCampus){
                        $selectedSectionName = $section->title;
                        $selectedSection = $section->id;
                        break;
                    }
                }
            }

            $selectedTemplate = 0;
            $selectedTemplateContent = "EMPTY";
            if(session('selectedTemplate')){
                $selectedTemplate = session("selectedTemplate");         
                foreach($messageTemplates as $temp){
                    if($temp->id == $selectedTemplate){
                        $selectedTemplateContent = $temp->content;
                        break;
                    }
                }
            }
            else{
                foreach($messageTemplates as $temp){
                    if($temp->campusId == $selectedCampus){
                        $selectedTemplateContent = $temp->content;
                        $selectedTemplate = $temp->id;
                        break;
                    }
                }
            }

            

            // $messagetTemplateIdCollection="";
            // $selectedMessagetTemplateId = 0;
            // foreach ($messageTemplates as $temp){
            //     if($selectedMessagetTemplateId==0){
            //         $selectedMessagetTemplateId = $temp->id;
            //     }
            //     $messagetTemplateIdCollection.= $temp->id.',';
            // }

            $data = DB::table('students')
            ->join('student_currents', 'students.id', '=', 'student_currents.studentId')
            ->where('section'.$academicYear, '=' , $selectedSection)
            ->where('gradeLevel'.$academicYear, '=' , $selectedGradeLevel)
            ->where('campusId'.$academicYear, '=' , $selectedCampus)
            ->OrderBy('firstName','ASC')
            ->OrderBy('middleName','ASC')
            ->OrderBy('lastName','ASC')
            ->get(['students.id','students.studentId','students.firstName',
            'students.middleName','students.lastName','students.sex','students.dob',
            'students.SMSMobile1','students.photo', 
            'student_currents.gradeLevel'.$academicYear.' as gradeLevel', 
            'student_currents.section'.$academicYear.' as section', 
            'student_currents.campusId'.$academicYear.' as campusId', 
            'student_currents.status'.$academicYear.' as status']);

            
        @endphp 
        <h1 class="h3 mb-3">
            <span class='badge text-bg-primary' style="font-size: 12px;font-weight:300;padding:10px;">
                {{$selectedCampusName}}
            </span>  
            Publish Messages
        </h1>
        <div class="row">
            <div class="col-sm-5 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <form id="campusSelectionForm" name="campusSelectionForm" action="{{ route('after-publish-messages-campus-selection') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="campusId">Campus</label>
                                <select class="form-control" id="campusId" name="campusId" onChange="campusSelectionForm.submit();">
                                    @foreach($campuses as $campus)
                                        @if($campus->id == $selectedCampus)
                                            <option value="{{$campus->id}}" selected>{{$campus->name}}</option>
                                        @else
                                            <option value="{{$campus->id}}">{{$campus->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        {{-- <hr/>         --}}
                        
                        <form id="gradeLevelSelectionForm" name="gradeLevelSelectionForm" action="{{ route('after-publish-messages-gradelevel-selection') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="campusId" name="campusId" value="{{$selectedCampus}}" required />
                                <label for="gradeLevels">Grade-Levels</label>
                               {{-- multiple  --}}
                               <select  class="form-control" id="gradeLevelId" name="gradeLevelId" onChange="gradeLevelSelectionForm.submit();">
                                    @foreach ($gradeLevels as $gradeLevel)
                                        @if($selectedCampus==$gradeLevel->campusId)
                                            @if($selectedGradeLevel==$gradeLevel->id)
                                                <option value="{{$gradeLevel->id}}" selected>{{ $gradeLevel->level }}</option>
                                            @else
                                                <option value="{{$gradeLevel->id}}">{{ $gradeLevel->level }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        {{-- <hr/>         --}}
                        <form id="sectionSelectionForm" name="sectionSelectionForm" action="{{ route('after-publish-messages-section-selection') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="campusId" name="campusId" value="{{$selectedCampus}}" required />
                                <input type="hidden" id="gradeLevelId" name="gradeLevelId" value="{{$selectedGradeLevel}}" required />
                                <label for="gradeLevels">Sections</label>
                               {{-- multiple  --}}
                               <select  class="form-control" id="sectionId" name="sectionId" onChange="sectionSelectionForm.submit();">
                                    @foreach ($sections as $section)
                                        @if($selectedCampus==$section->campusId)
                                            @if($selectedSection==$section->id)
                                                <option value="{{$section->id}}" selected>{{ $section->title }}</option>
                                            @else
                                                <option value="{{$section->id}}">{{ $section->title }}</option>
                                            @endif    
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <hr/>  
                        <form id="templateSelectionForm" name="templateSelectionForm" action="{{ route('after-publish-messages-template-selection') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="campusId" name="campusId" value="{{$selectedCampus}}" required />
                                <input type="hidden" id="gradeLevelId" name="gradeLevelId" value="{{$selectedGradeLevel}}" required />
                                <input type="hidden" id="sectionId" name="sectionId" value="{{$selectedSection}}" required />
                                <label for="gradeLevels">Message Template</label>
                               {{-- multiple  --}}
                               <select class="form-control" id="messageTemplateId" name="messageTemplateId" onChange="templateSelectionForm.submit();">
                                    @foreach ($messageTemplates as $temp)
                                        @if($selectedCampus==$temp->campusId)
                                            @if($selectedTemplate==$temp->id)
                                                <option value="{{$temp->id}}" selected>Template-{{ $temp->id }}</option>
                                            @else
                                                <option value="{{$temp->id}}">Template-{{ $temp->id }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                               
                            </div>
                        </form>    
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-7 col-xl-8">
                <div class="card">
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
                    <div class="card-body">
                        Publish Message Summary
                        <hr/>
                        <div class="row">
                            <div class="col-sm-4 col-xl-4">
                                <h6 class="m-0">
                                    Campus:
                                    <label class="text-muted text-sm">{{$selectedCampusName}}</label>
                                </h6>
                                <h6 class="m-0">
                                    Grade-level:
                                    <label class="text-muted text-sm">{{$selectedGradeLevelName}}</label>
                                </h6>
                                <h6 class="m-0">
                                    Section:
                                    <label class="text-muted text-sm">{{$selectedSectionName}}</label>
                                </h6>
                                <label for="selectedStudents">Selected Students : <b id="totalSelectedStudent" style="font-size:15px;">(0/{{sizeof($data)}})</b></label >
                                <form id="sendMessage" name="sendMessage" action="{{ route('publish-messages.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="campusId" name="campusId" value="{{$selectedCampus}}" required />
                                    <input type="hidden" id="gradeLevelId" name="gradeLevelId" value="{{$selectedGradeLevel}}" required />
                                    <input type="hidden" id="sectionId" name="sectionId" value="{{$selectedSection}}" required />
                                    <input type="hidden" id="templateId" name="templateId" value="{{$selectedTemplate}}" required />
                                    <input type="hidden" id="studentIdCollection" name="studentIdCollection" value="" required />
                                    <button type="submit" class="btn btn-lg btn-primary" disabled style="padding: 5px" id="submitButton">
                                        <i class="align-middle" data-lucide="send">&nbsp;</i> Send
                                    </button>
                                </form>
                            </div>
                            <div class="col-sm-8 col-xl-8">
                                <h6 class="m-0">Template-{{$selectedTemplate}}</h6>
                                <p class="text-muted text-sm">{{$selectedTemplateContent}}</p>
                            </div>
                        </div>

                        
                        <hr/>
                        <div class="form-group">                            
                            <table id="datatables-products" class="table w-100">
								<thead>
									<tr>
										<th class="align-middle">
											<div class="form-check fs-4">
												<input class="form-check-input" type="checkbox" id="selectAllStudent" onclick="selectAllStudent()">
											</div>
										</th>
										<th class="align-middle">Student Name</th>
										<th class="align-middle">Student ID</th>
										<th class="align-middle text-end">Actions</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($data as $student)                               
                                        <tr>
                                            <td>
                                                <div class="form-check fs-4">
                                                    <input class="form-check-input" type="checkbox" id='student{{$student->id}}' onclick="selectedCounter({{$student->id}})">
                                                    {{-- <label class="form-check-label"></label> --}}
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mb-0">
                                                    <strong>{{$student->firstName}} {{$student->middleName}} {{$student->lastName}}</strong><br />
                                                    {{-- <span class="text-muted">{{$selectedGradeLevelName}}{{$selectedSectionName}}</span> --}}
                                                </p>
                                            </td>
                                            <td>{{$student->studentId}}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-light">View</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>

    </div>
    


    <script>
        // Convert Laravel's PHP data collection to JSON
        let studentData = @json($data);
        let studentIdCollection = [];
        studentData.map((student)=>{
            studentIdCollection.push(student.id);
        })
        
        function selectedCounter(thisStudId){
            let counter = 0;
            let selectedStudents ="";
            for(const studId of studentIdCollection){
                if(document.getElementById('student'+studId).checked){
                    selectedStudents += studId+",";
                    counter++;
                }
            }
            if(counter==0){
                document.getElementById('submitButton').disabled= true;
            }
            else{
                document.getElementById('submitButton').disabled= false;
            }
            document.getElementById('totalSelectedStudent').innerHTML =`(${counter}/${studentIdCollection.length})`
            document.getElementById('studentIdCollection').value = selectedStudents;
        }
        function selectAllStudent(){
            let selectedStudents ="";
            let status =  document.getElementById('selectAllStudent').checked;
            console.log(status)
            if(status){
                for(const studId of studentIdCollection){
                    document.getElementById('student'+studId).checked = true;
                    selectedStudents += studId+",";
                }
                document.getElementById('totalSelectedStudent').innerHTML =`(${studentIdCollection.length}/${studentIdCollection.length})`
                document.getElementById('studentIdCollection').value = selectedStudents;
                document.getElementById('submitButton').disabled= false;
            }
            else{
                for(const studId of studentIdCollection){
                    document.getElementById('student'+studId).checked = false;
                }
                document.getElementById('totalSelectedStudent').innerHTML =`(${0}/${studentIdCollection.length})`
                document.getElementById('studentIdCollection').value = "";
                document.getElementById('submitButton').disabled= true;
            }
            // console.log(studentIdCollection)
        }

        // function displayMessageContent(messageTemplate,viewName,selectId)
        // {
        //     let collection= messageTemplate.split(',');
        //     for(let i=0;i<collection.length-1;i++)
        //     {
        //         document.getElementById(viewName+collection[i]).style.display='none';
        //     }
        //     let id =  document.getElementById(selectId).value;
        //     let view = document.getElementById(viewName+id);
        //     view.style.display='block';
        //     // alert(viewName);
        // }
	</script>
@endsection