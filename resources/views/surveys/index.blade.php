@extends('layouts.app') 
@section('title', 'Survey Manager')
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
            <h3>Survey Manager</h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            <div class="d-grid mb-4">
                <button
                    type="button"
                    class="btn btn-lg btn-primary"
                    data-bs-toggle="modal"
                    style="padding: 5px"
                    data-bs-target="#addSurveyModel"
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
                                <th>Title</th>
                                <th>Campus</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surveys as $survey)
                            <tr>
                                <td>{{ $survey->title }}</td>
                                <td>{{ $survey->name }}</td>
                                <td>
                                    @if($survey->status)
                                        <span class='badge text-bg-success'>Approved</span>
                                    @else
                                        <span class='badge text-bg-danger'>Not Approved</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" title="View" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#viewSurveyModal{{ $survey->id }}">
                                        <i class="align-middle" data-lucide="eye" style="color: #3f80ea;width: 20px;height: 20px;"></i>
                                    </button>

                                    <!-- View Survey Modal -->
                                    <div class="modal fade" id="viewSurveyModal{{ $survey->id }}" tabindex="-1" aria-labelledby="viewSurveyModalLabel{{ $survey->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewSurveyModalLabel{{ $survey->id }}">
                                                        View Survey
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="viewTitle{{ $survey->id }}">Title</label>
                                                        <input type="text" class="form-control" id="viewTitle{{ $survey->id }}" value="{{ $survey->title }}" readonly/>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="viewDescription{{ $survey->id }}">Description</label>
                                                        <textarea
                                                            style="
                                                                max-height: 150px;
                                                                min-height: 150px;
                                                            "
                                                            class="form-control"
                                                            id="viewDescription{{ $survey->id }}"
                                                            readonly
                                                            >{{ $survey->description }}</textarea
                                                        >
                                                    </div>

                                                     <div class="form-group">
                                                        <label for="viewCampus{{ $survey->id }}">Campus</label>
                                                        <input type="text" class="form-control" id="viewCampus{{ $survey->id }}" value="{{ $survey->name }}" readonly/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="viewStatus{{ $survey->id }}">Status</label>
                                                         @if($survey->status)
                                                            <span class='badge text-bg-success'>Approved</span>
                                                        @else
                                                            <span class='badge text-bg-danger'>Not Approved</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($survey->status==0)
                                        <button type="button" title="Edit" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editSurveyModal{{ $survey->id }}">
                                            <i class="align-middle" data-lucide="pencil" style="color: #e5a54b;width: 20px;height: 20px;"></i>
                                        </button>

                                        <!-- Edit Survey Modal -->

                                        <div class="modal fade" id="editSurveyModal{{ $survey->id }}" tabindex="-1" role="dialog" >
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form id="editSurveyForm{{ $survey->id }}" action="{{ route('surveys.update', $survey->id) }}" method="POST" onsubmit="return validateEditForm('{{$survey->id}}')">
                                                        @csrf @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editSurveyModalLabel{{ $survey->id }}">
                                                                Edit Survey
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="title{{ $survey->id }}" >Title</label>
                                                                <input
                                                                    type="text"
                                                                    class="form-control @error('title') is-invalid @enderror"
                                                                    id="title{{ $survey->id }}"
                                                                    name="title"
                                                                    value="{{ old('title', $survey->title) }}"
                                                                    required
                                                                />
                                                                @error('title')
                                                                <div
                                                                    class="invalid-feedback"
                                                                >
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="description{{ $survey->id }}">Description</label>
                                                                <textarea
                                                                    style="
                                                                        max-height: 150px;
                                                                        min-height: 150px;
                                                                    "
                                                                    class="form-control @error('description') is-invalid @enderror"
                                                                    id="description{{ $survey->id }}"
                                                                    name="description"
                                                                    >{{ old('description', $survey->description) }}</textarea
                                                                >
                                                                @error('description')
                                                                <div
                                                                    class="invalid-feedback"
                                                                >
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="campus{{ $survey->id }}">Campus</label>
                                                                <select class="form-control" id="campusId{{ $survey->id }}" name="campusId">
                                                                    @foreach($campuses as $campus)
                                                                        @if($survey->campusId==$campus->id)
                                                                            <option value="{{$campus->id}}" selected>{{$campus->name}}</option>
                                                                        @else
                                                                            <option value="{{$campus->id}}">{{$campus->name}}</option>
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
                                                                Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route( 'surveys.destroy', $survey)}}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure you want to delete this survey?');">
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

            <!-- Add Survey Modal -->
            <div class="modal fade" id="addSurveyModel" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addSurveyForm" action="{{ route('surveys.store') }}" method="POST" onsubmit="return validateForm()">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSurveyModalLabel">
                                    Add Survey
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input
                                        type="text"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="title"
                                        name="title"
                                        value="{{ old('title') }}"
                                        required
                                    />
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea
                                        style="
                                            max-height: 150px;
                                            min-height: 150px;
                                        "
                                        class="form-control @error('description') is-invalid @enderror"
                                        id="description"
                                        name="description"
                                        >{{ old("description") }}</textarea
                                    >
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="campusId">Campus</label>
                                    <select class="form-control" id="campusId" name="campusId[]" multiple>
                                        @foreach($campuses as $campus)
                                            <option value="{{$campus->id}}">{{$campus->name}}</option>
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
                <button type="button" class="btn btn-danger remove-option" onclick="removeOption('${optionId}')">Remove</button>
            </div>`;
        document.getElementById('additional-options').appendChild(div);
    });

    function removeOption(optionId) {
        document.getElementById(optionId).remove();
    }
</script>
@endsection
