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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surveys as $survey)
                            <tr>
                                <td>{{ $survey->title }}</td>
                                <td>
                                    {{ $survey->status ? "Active" : "Inactive" }}
                                </td>
                                <td>
                                    <button type="button" title="View" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#viewSurveyModel{{ $survey->id }}">
                                        <i class="align-middle"data-lucide="eye" style="color: #3f80ea;width: 20px;height: 20px;"></i>
                                    </button>

                                    <!-- View Survey Modal -->
                                    <div
                                        class="modal fade"
                                        id="viewSurveyModel{{ $survey->id }}"
                                        tabindex="-1"
                                        aria-labelledby="viewSurveyModelLabel{{ $survey->id }}"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5
                                                        class="modal-title"
                                                        id="viewSurveyModelLabel{{ $survey->id }}"
                                                    >
                                                        View Survey
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
                                                        <label
                                                            for="viewTitle{{ $survey->id }}"
                                                            >Title</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewTitle{{ $survey->id }}"
                                                            value="{{ $survey->title }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="viewDescription{{ $survey->id }}"
                                                            >Description</label
                                                        >
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
                                                        <label
                                                            for="viewStatus{{ $survey->id }}"
                                                            >Status</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewStatus{{ $survey->id }}"
                                                            value="{{ $survey->status ? 'Active' : 'Inactive' }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <!-- <div class="form-group">
                                                        <label
                                                            for="viewCreatedBy{{ $survey->id }}"
                                                            >Created By</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewCreatedBy{{ $survey->id }}"
                                                            value="{{ $survey->created_by }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="viewUpdatedBy{{ $survey->id }}"
                                                            >Updated By</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewUpdatedBy{{ $survey->id }}"
                                                            value="{{ $survey->updated_by }}"
                                                            readonly
                                                        />
                                                    </div> -->
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

                                    <button
                                        type="button"
                                        title="Edit"
                                        class="btn btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editSurveyModel{{ $survey->id }}"
                                    >
                                        <i
                                            class="align-middle"
                                            data-lucide="pencil"
                                            style="
                                                color: #e5a54b;
                                                width: 20px;
                                                height: 20px;
                                            "
                                        ></i>
                                    </button>

                                    <!-- Edit Survey Modal -->

                                    <div
                                        class="modal fade"
                                        id="editSurveyModel{{ $survey->id }}"
                                        tabindex="-1"
                                        role="dialog"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form
                                                    id="editSurveyForm{{ $survey->id }}"
                                                    action="{{ route('surveys.update', $survey->id) }}"
                                                    method="POST"
                                                    onsubmit="return validateEditForm('{{$survey->id}}')"
                                                >
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5
                                                            class="modal-title"
                                                            id="editSurveyModelLabel{{ $survey->id }}"
                                                        >
                                                            Edit Message
                                                            Survey
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
                                                            <label
                                                                for="title{{ $survey->id }}"
                                                                >Title</label
                                                            >
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
                                                            <label
                                                                for="description{{ $survey->id }}"
                                                                >Description</label
                                                            >
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
                                                            <label
                                                                for="status{{ $survey->id }}"
                                                                >Status</label
                                                            >
                                                            <select
                                                                class="form-control"
                                                                id="status{{ $survey->id }}"
                                                                name="status"
                                                            >
                                                                @if($survey->status==1)
                                                                <option
                                                                    value="1"
                                                                    selected
                                                                >
                                                                    Active
                                                                </option>
                                                                <option
                                                                    value="0"
                                                                >
                                                                    Inactive
                                                                </option>
                                                                @else
                                                                <option
                                                                    value="1"
                                                                >
                                                                    Active
                                                                </option>
                                                                <option
                                                                    value="0"
                                                                    selected
                                                                >
                                                                    Inactive
                                                                </option>
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
                                                'surveys.destroy',
                                                $survey
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
            <div class="modal fade" id="addSurveyModel" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addSurveyForm" action="{{ route('surveys.store') }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addSurveyModelLabel">
                                    Add New Survey
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
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
                                    <label for="options">Options</label>
                                    <div class="input-group mb-2" id="option1">
                                        <input type="text" class="form-control" name="options[]" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-option" onclick="removeOption('option1')">Remove</button>
                                        </div>
                                    </div>
                                    <div class="input-group mb-2" id="option2">
                                        <input type="text" class="form-control" name="options[]" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-option" onclick="removeOption('option2')">Remove</button>
                                        </div>
                                    </div>
                                    <div id="additional-options"></div>
                                    <button type="button" class="btn btn-secondary mt-2" id="add-option">Add Another Option</button>
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

            <!-- Script to validate the form -->
            <script>
                function validateForm() {
                    var title = document.getElementById("title").value;
                    var isValid = true;

                    // Clear previous error messages
                    document
                        .getElementById("title")
                        .classList.remove("is-invalid");

                    // Check if title is empty
                    if (!title) {
                        isValid = false;
                        document
                            .getElementById("title")
                            .classList.add("is-invalid");
                    }

                    return isValid;
                }
            </script>
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
