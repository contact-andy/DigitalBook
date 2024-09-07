@extends('layouts.app') @section('title', 'Message Templates')
@section('content')
<div class="container-fluid p-0">
    @if(session('success'))
        <div class="alert alert-success alert-outline alert-dismissible" role="alert">
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
            <div class="alert-icon">
                <i class="align-middle" data-lucide="bell"></i>
            </div>
            <div class="alert-message">
                <strong> {{ session("success") }}</strong>
            </div>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-outline alert-dismissible" role="alert">
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
            <div class="alert-icon">
                <i class="align-middle" data-lucide="bell"></i>
            </div>
            <div class="alert-message">
                <strong> {{ session("error") }}</strong>
            </div>
        </div>
    @elseif(session('info'))
        <div class="alert alert-info alert-outline alert-dismissible" role="alert">
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
            <div class="alert-icon">
                <i class="align-middle" data-lucide="bell"></i>
            </div>
            <div class="alert-message">
                <strong> {{ session("info") }}</strong>
            </div>
        </div>
    @endif 
    
    @if ($errors->any())
        <div class="alert alert-danger alert-outline alert-dismissible" role="alert">
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
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
            <h3>Message Templates</h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            <div class="d-grid mb-4">
                <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" style="padding: 5px" data-bs-target="#addTemplateModel">
                    <i class="align-middle" data-lucide="plus">&nbsp;</i> New
                </button>
                <!-- width:90px;height:30px; -->
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: -30px">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatables-fixed-header" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Campus</th>
                                <th>Category</th>
                                <th>Applicabel Grade-Level</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $template)
                            <tr>
                                <td>{{ $template->id}}</td>
                                <td style="width: 40%">
                                    {{ $template->content }}
                                    <br>
                                    <span class='badge text-bg-info'>{{ ucfirst($template->type) }} {{ $template->type=='single'?' student':' students' }}</span>
                                </td>
                                <td>{{ $template->name }}</td>
                                <td>{{ $template->title }}</td>
                                <td>
                                    {{-- {{ $template->gradeLevels}} --}}
                                    @php
                                        $gLevels = json_decode($template->gradeLevels, true);
                                        $gLevelArray = array();
                                        foreach($gLevels as $gLevel){
                                            foreach ($gradeLevels as $gradeLevel)
                                            if($gLevel==$gradeLevel->id){
                                                $gLevelArray[] =$gradeLevel->level;
                                                break;
                                            }
                                        }
                                        $jsonString = json_encode($gLevelArray);
                                        echo $jsonString;
                                    @endphp

                                </td>
                               <td>
                                    @if($template->status)
                                        <span class='badge text-bg-success'>Approved</span>
                                    @else
                                        <span class='badge text-bg-danger'>Not Approved</span>
                                    @endif
                                </td>
                                <td>
                                    
                                    <!-- View Template Modal -->
                                    <button type="button" title="View" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#viewTemplateModal{{ $template->id }}">
                                        <i class="align-middle" data-lucide="eye" style=" color: #3f80ea; width: 20px; height: 20px;"></i>
                                    </button>
                                    <div class="modal fade" id="viewTemplateModal{{ $template->id }}" tabindex="-1" aria-labelledby="viewTemplateModalLabel{{ $template->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewTemplateModalLabel{{ $template->id }}">
                                                        View Message Template
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group">
                                                        <label for="viewCampus{{ $template->id }}">Campus</label>
                                                        <input type="text" class="form-control" id="viewCampus{{ $template->id }}" value="{{ $template->name }}" readonly/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="viewTitle{{ $template->id }}">Message Category</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewType{{ $template->id }}"
                                                            value="{{ $template->title }}"
                                                            readonly
                                                        />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="viewDescription{{ $template->id }}">Message Content</label>
                                                        <textarea
                                                            style="
                                                                max-height: 150px;
                                                                min-height: 150px;
                                                            "
                                                            class="form-control"
                                                            id="viewContent{{ $template->id }}"
                                                            readonly
                                                            required
                                                            >{{ $template->content }}</textarea
                                                        >
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="viewTitle{{ $template->id }}">Type(Works for **** student(s))</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewType{{ $template->id }}"
                                                            value="{{ ucfirst($template->type) }}"
                                                            readonly
                                                        />
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="viewGradeLevels{{ $template->id }}">Applicable Grade-Level</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewGradeLevels{{ $template->id }}"
                                                            value="{{ $jsonString }}"
                                                            readonly
                                                        />
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="viewStatus{{ $template->id }}">Status</label>
                                                         @if($template->status)
                                                            <span class='badge text-bg-success'>Approved</span>
                                                        @else
                                                            <span class='badge text-bg-danger'>Not Approved</span>
                                                        @endif
                                                    </div>                                                   
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($template->status ==0 )
                                        
                                        <!-- Edit Template Modal -->
                                        <button type="button" title="Edit" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editTemplateModal{{ $template->id }}">
                                            <i class="align-middle" data-lucide="pencil" style="color: #e5a54b;width: 20px;height: 20px;"></i>
                                        </button>
                                        <div class="modal fade" id="editTemplateModal{{ $template->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="editTemplateForm{{ $template->id }}" action="{{ route('message-templates.update', $template->id) }}" method="POST" onsubmit="return validateEditForm('{{$template->id}}')">
                                                        @csrf @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editTemplateModalLabel{{ $template->id }}">
                                                                Edit Message Template
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @php
                                                                $selectedCampusId = $template->campusId;
                                                            @endphp
                                                            <div class="form-group">
                                                                <label for="campusId">Campus</label>
                                                                <select class="form-control" id="editCampusId" name="campusId">
                                                                    @foreach($campuses as $campus)
                                                                        @if($selectedCampusId==$campus->id)
                                                                            <option value="{{$campus->id}}">{{$campus->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editMessageCategoryId">Message Category</label>
                                                                <select class="form-control" id="editMessageCategoryId" name="messageCategoryId" required>
                                                                    @foreach ($categories as $category)
                                                                        @if($selectedCampusId==$category->campusId)
                                                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="content{{ $template->id }}">Content</label>
                                                                <textarea
                                                                    style="
                                                                        max-height: 150px;
                                                                        min-height: 150px;
                                                                    "
                                                                    class="form-control @error('content') is-invalid @enderror"
                                                                    id="content{{ $template->id }}"
                                                                    name="content"
                                                                    >{{ old('content', $template->content) }}</textarea
                                                                >
                                                                @error('content')
                                                                <div
                                                                    class="invalid-feedback"
                                                                >
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="type{{ $template->id }}">Type(Works for)</label>
                                                                <select class="form-control" id="type{{ $template->id }}" name="type">
                                                                    @if(strcmp($template->type,"single")==0)
                                                                        <option value="single" selected>Single</option>
                                                                        <option value="multiple">Multiple</option>
                                                                    @else
                                                                        <option value="single">Single</option>
                                                                        <option value="multiple" selected>Multiple</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="editGradeLevels">Applicable Grade-Levels</label>
                                                                <select multiple class="form-control" id="editGradeLevels" name="gradeLevels[]" required>
                                                                    @foreach ($gradeLevels as $gradeLevel)
                                                                        @if($selectedCampusId==$gradeLevel->campusId)
                                                                            @php
                                                                                $check = 0;
                                                                            @endphp
                                                                            @foreach ($gLevels as $gLevel)
                                                                                @if ($gLevel == $gradeLevel->id)
                                                                                    <option value="{{$gradeLevel->id}}" selected>{{ $gradeLevel->level }}</option>
                                                                                    {{$check=1}}
                                                                                    @break;
                                                                                @endif
                                                                            @endforeach
                                                                            @if ($check==0)
                                                                                <option value="{{$gradeLevel->id}}">{{ $gradeLevel->level }}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button
                                                                type="button"
                                                                class="btn btn-secondary"
                                                                data-bs-dismiss="modal"
                                                            >
                                                                Close
                                                            </button>
                                                            <button
                                                                type="submit"
                                                                class="btn btn-primary"
                                                            >
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{route('message-templates.destroy',$template)}}" method="POST" style="display: inline"onsubmit="return confirm('Are you sure you want to delete this template?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-icon" type="submit" title="Delete" style="padding: 0px">
                                                <i class="align-middle" data-lucide="trash" style="color: #d9534f;width: 20px;height: 20px;"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- New Table -->
            </div>

            <!-- Add Template Modal -->
            <div class="modal fade" id="addTemplateModel" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addTemplateForm" action="{{ route('message-templates.store') }}" method="POST" onsubmit="return validateForm()">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTemplateModalLabel">
                                    Add Message Template
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @php
                                    $selectedCampusId =0;
                                    foreach($campuses as $campus){
                                        $selectedCampusId =  $campus->id;
                                        break;
                                    }
                                @endphp
                                <div class="form-group">
                                    <label for="campusId">Campus</label>
                                    <select class="form-control" id="campusId" name="campusId" onchange="onCampusChange(this.value)">
                                        @foreach($campuses as $campus)
                                            <option value="{{$campus->id}}">{{$campus->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label for="messageCategoryId">Message Category</label>
                                    <select class="form-control" id="messageCategoryId" name="messageCategoryId" required>
                                        @foreach ($categories as $category)
                                            @if($selectedCampusId==$category->campusId)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="content">Message Content</label>
                                    <textarea
                                        style="
                                            max-height: 150px;
                                            min-height: 150px;
                                        "
                                        class="form-control @error('content') is-invalid @enderror"
                                        id="content"
                                        name="content"
                                        required
                                        >{{ old("content") }}</textarea
                                    >
                                    @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="type">Type (Works for)</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="single">Single</option>
                                        <option value="multiple">Multiple</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="gradeLevels">Applicable Grade-Levels</label>
                                    <select multiple class="form-control" id="gradeLevels" name="gradeLevels[]" required>
                                        @foreach ($gradeLevels as $gradeLevel)
                                            @if($selectedCampusId==$gradeLevel->campusId)
                                                <option value="{{$gradeLevel->id}}">{{ $gradeLevel->level }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Script to validate the form -->
            <script>
                function validateForm() {
                    var content = document.getElementById("content").value;
                    var isValid = true;

                    // Clear previous error messages
                    document
                        .getElementById("content")
                        .classList.remove("is-invalid");

                    // Check if title is empty
                    if (!content) {
                        isValid = false;
                        document
                            .getElementById("content")
                            .classList.add("is-invalid");
                    }

                    return isValid;
                }

                let allCampuses = @json($campuses);
                let allCategory = @json($categories);
                let allGradeLevel = @json($gradeLevels);
                console.log(allGradeLevel);
                function onCampusChange(campId){
                    console.log(campId)
                    // let campId = document.getElementById('campusId').value;                    
                    // console.log(campId);
                    const messageCategoryId = document.getElementById('messageCategoryId');
                    messageCategoryId.innerHTML = '';
                    const categoryOptions = allCategory.map(category => {
                        if(category.campusId == campId){
                            return `<option value="${category.id}">${category.title}</option>`;
                        }
                    }).join(''); 
                    // console.log(categoryOptions)
                    messageCategoryId.innerHTML = categoryOptions;
                    
                    const gradeLevels = document.getElementById('gradeLevels');
                    gradeLevels.innerHTML = '';
                    const gradeLevelOptions = allGradeLevel.map(gLevel => {
                        if(gLevel.campusId == campId){
                            return `<option value="${gLevel.id}">${gLevel.level}</option>`;
                        }
                    }).join(''); 
                    gradeLevels.innerHTML = gradeLevelOptions;
                    

                }
            </script>
        </div>
    </div>
</div>
@endsection
