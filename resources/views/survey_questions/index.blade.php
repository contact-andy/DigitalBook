@extends('layouts.app') 
@section('title', 'Survey Questions')
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

    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3>Survey Questions</h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            <div class="d-grid mb-4">
                <button
                    type="button"
                    class="btn btn-lg btn-primary"
                    data-bs-toggle="modal"
                    style="padding: 5px"
                    data-bs-target="#addSurveyQuestionModel"
                >
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
                    <table id="datatables-fixed-header" lass="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>Survey Title</th>
                                <th>Question</th>
                                <th>Options</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surveyQuestions as $surveyQuestion)
                            <tr>
                                <td>{{ $surveyQuestion->title }}</td>
                                <td>{{ $surveyQuestion->question }}</td>
                                <td>{{ $surveyQuestion->options }}</td>
                                <td>
                                    {{ $surveyQuestion->status ? "Active" : "Inactive" }}
                                </td>
                                <td>
                                    <button type="button" title="View" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#viewSurveyQuestionModel{{ $surveyQuestion->id }}">
                                        <i class="align-middle"data-lucide="eye" style="color: #3f80ea;width: 20px;height: 20px;"></i>
                                    </button>

                                    <!-- View Survey Modal -->
                                    <div class="modal fade" id="viewSurveyQuestionModel{{ $surveyQuestion->id }}" tabindex="-1" aria-labelledby="viewSurveyQuestionModelLabel{{ $surveyQuestion->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewSurveyQuestionModelLabel{{ $surveyQuestion->id }}">
                                                        View Survey Question
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="viewTitle{{ $surveyQuestion->id }}">Survey Title</label>
                                                        <input type="text" class="form-control" id="viewTitle{{ $surveyQuestion->id }}" value="{{ $surveyQuestion->title }}" readonly/>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="viewQuestion{{ $surveyQuestion->id }}">Question</label>
                                                        <input type="text" class="form-control" id="viewQuestion{{ $surveyQuestion->id }}" value="{{ $surveyQuestion->question }}" readonly/>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="options{{ $surveyQuestion->id }}">Options</label>
                                                            @php
                                                                $options = json_decode($surveyQuestion->options, true);
                                                            @endphp
                                                            @foreach($options as $option)
                                                                <div class="input-group mb-2" id="optionView{{ $surveyQuestion->id }}">
                                                                    <input type="text" class="form-control" name="options[]" value="{{ $option }}" disabled>
                                                                </div>
                                                            @endforeach
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="viewStatus{{ $surveyQuestion->id }}">Type</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewStatus{{ $surveyQuestion->id }}"
                                                            value="{{ strcmp($surveyQuestion->status,'single-choice')==0 ? 'Single Choice' : 'Multiple Choice' }}"
                                                            readonly
                                                        />
                                                    </div>
                                                    <div class="form-group" style='margin-top:10px;margin-bottom:10px;'>
                                                        <label for="is_required">Is Required?</label>
                                                        <input type="checkbox" name="is_required" id="is_required" value="{{$surveyQuestion->is_required}}" disabled {{$surveyQuestion->is_required?'checked':''}}>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="viewType{{ $surveyQuestion->id }}">Status</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewType{{ $surveyQuestion->id }}"
                                                            value="{{ $surveyQuestion->type ? 'Active' : 'Inactive' }}"
                                                            readonly
                                                        />
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

                                    <button type="button" title="Edit" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editSurveyQuestionModel{{ $surveyQuestion->id }}">
                                        <i class="align-middle" data-lucide="pencil" style=" color: #e5a54b; width: 20px; height: 20px;"></i>
                                    </button>

                                    <!-- Edit Survey Modal -->

                                    <div class="modal fade" id="editSurveyQuestionModel{{ $surveyQuestion->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form
                                                    id="editSurveyForm{{ $surveyQuestion->id }}"
                                                    action="{{ route('survey-questions.update', $surveyQuestion->id) }}"
                                                    method="POST"
                                                    onsubmit="return validateEditForm('{{$surveyQuestion->id}}')"
                                                >
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSurveyQuestionModelLabel{{ $surveyQuestion->id }}">
                                                            Edit Survey Questions
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="survey_id{{ $surveyQuestion->id }}" >Survey Title</label>
                                                            <select class="form-control" id="survey_id{{ $surveyQuestion->id }}" name="survey_id" >
                                                                @foreach($surveyCategory as $category)
                                                                    @if($category->id==$surveyQuestion->survey_id)
                                                                        <option value="{{$category->id}}" selected>{{$category->title}}</option>
                                                                    @else
                                                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="question{{ $surveyQuestion->id }}">Question</label>
                                                            <input
                                                                type="text"
                                                                class="form-control @error('question') is-invalid @enderror"
                                                                id="title{{ $surveyQuestion->id }}"
                                                                name="question"
                                                                value="{{ old('question', $surveyQuestion->question) }}"
                                                                required
                                                            />
                                                            @error('question')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        
                                                        <div class="form-group">
                                                            <label for="options{{ $surveyQuestion->id }}">Options</label>
                                                            @php
                                                                $options = json_decode($surveyQuestion->options, true);
                                                                $counter =1 ;
                                                            @endphp
                                                            @foreach($options as $option)
                                                                <div class="input-group mb-2" id="option{{$counter}}{{ $surveyQuestion->id }}">
                                                                    <input type="text" class="form-control" name="options[]" value="{{ $option }}" required>
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-danger remove-option" type="button" onclick="editRemoveOption('option{{$counter}}', '{{ $surveyQuestion->id }}')">&times;</button>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $counter++;
                                                                @endphp
                                                            @endforeach
                                                            <div id="additional-options-edit{{ $surveyQuestion->id }}"></div>
                                                            <button type="button" class="btn btn-secondary mt-2" id="add-option-edit" onclick="editAddNewOption('{{ $surveyQuestion->id }}')">Add Another Option</button>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="type{{ $surveyQuestion->id }}">Type</label>
                                                            <select class="form-control" id="type{{ $surveyQuestion->id }}" name="type">
                                                                @if(strcmp($surveyQuestion->type,'single-choice')==0)
                                                                    <option value="single-choice" selected>Single Choice</option>
                                                                    <option value="multiple-choice">Multiple Choice</option>
                                                                @else
                                                                    <option value="single-choice">Single Choice</option>
                                                                    <option value="multiple-choice" selected>Multiple Choice</option>
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="form-group" style='margin-top:10px;margin-bottom:10px;'>
                                                            <label for="is_required">Is Required?</label>
                                                            <input type="checkbox" name="is_required" id="is_required" value="1" {{$surveyQuestion->is_required?'checked':''}}>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="status{{ $surveyQuestion->id }}">Status</label>
                                                            <select class="form-control" id="status{{ $surveyQuestion->id }}" name="status">
                                                                @if($surveyQuestion->status==1)
                                                                    <option value="1" selected>Active</option>
                                                                    <option value="0" > Inactive</option>
                                                                @else
                                                                    <option value="1">Active</option>
                                                                    <option value="0" selected>Inactive</option>
                                                                @endif
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

                                    <form
                                        action="{{
                                            route(
                                                'survey-questions.destroy',
                                                $surveyQuestion
                                            )
                                        }}"
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return confirm('Are you sure you want to delete this Survey?');"
                                    >
                                        @csrf @method('DELETE')

                                        <button
                                            class="btn btn-icon"
                                            type="submit"
                                            title="Delete"
                                            style="padding: 0px"
                                        >
                                            <i
                                                class="align-middle"
                                                data-lucide="trash"
                                                style="
                                                    color: #d9534f;
                                                    width: 20px;
                                                    height: 20px;
                                                "
                                            ></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- New Table -->
            </div>

            <!-- Add Survey Modal -->
            <div class="modal fade" id="addSurveyQuestionModel" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addSurveyForm" action="{{ route('survey-questions.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSurveyQuestionModelLabel">
                                    Add New Survey Questions
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="survey_id">Survey Title</label>
                                    <select
                                        class="form-control"
                                        id="survey_id"
                                        name="survey_id"
                                        required
                                    >
                                        @foreach ($surveyCategory as $category)
                                        <option value="{{$category->id}}">
                                            {{$category->title}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <input
                                        type="text"
                                        class="form-control @error('question') is-invalid @enderror"
                                        id="question"
                                        name="question"
                                        value="{{ old('question') }}"
                                        required
                                    />
                                    @error('question')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="options">Options</label>
                                    <div class="input-group mb-2" id="option1">
                                        <input type="text" class="form-control" name="options[]" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-option" onclick="removeOption('option1')">&times;</button>
                                        </div>
                                    </div>
                                    <div class="input-group mb-2" id="option2">
                                        <input type="text" class="form-control" name="options[]" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-option" onclick="removeOption('option2')">&times;</button>
                                        </div>
                                    </div>
                                    <div id="additional-options"></div>
                                    <button type="button" class="btn btn-secondary mt-2" id="add-option">Add Another Option</button>
                                </div>

                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="single-choice">Single Choice</option>
                                        <option value="multiple-choice">Multiple Choice</option>
                                    </select>
                                </div>

                                <div class="form-group" style='margin-top:10px;margin-bottom:10px;'>
                                    <label for="is_required">Is Required?</label>
                                    <input type="checkbox" name="is_required" id="is_required" value="1">
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select
                                        class="form-control"
                                        id="status"
                                        name="status"
                                    >
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
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
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
   let optionCount = 3;

    document.getElementById('add-option').addEventListener('click', function() {
        const optionId = 'option' + optionCount++;
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.id = optionId;
        div.innerHTML = `
            <input type="text" class="form-control" name="options[]" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-option" onclick="removeOption('${optionId}')">&times;</button>
            </div>`;
        document.getElementById('additional-options').appendChild(div);
    });

    function removeOption(optionId) {
        document.getElementById(optionId).remove();
    }
    let optionCounter =@json($counter);

    function editAddNewOption(questionId) {
        const optionId = 'option' + optionCounter++;
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.id = optionId;
        div.innerHTML = `
            <input type="text" class="form-control" name="options[]" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-option" onclick="removeOption('${optionId}','${questionId}')">&times;</button>
            </div>`;
            
        document.getElementById('additional-options-edit'+questionId).appendChild(div);
    }
    
    function editRemoveOption(optionId, questionId) {
        document.getElementById(optionId+''+questionId).remove();
    }
</script>
@endsection
