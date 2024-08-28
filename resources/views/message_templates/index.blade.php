@extends('layouts.app') @section('title', 'Message Templates')
@section('content')
<div class="container-fluid p-0">
    @if(session('success'))
    <div
        class="alert alert-success alert-outline alert-dismissible"
        role="alert"
    >
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
    <div
        class="alert alert-danger alert-outline alert-dismissible"
        role="alert"
    >
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
    @endif @if ($errors->any())
    <div
        class="alert alert-danger alert-outline alert-dismissible"
        role="alert"
    >
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
                <button
                    type="button"
                    class="btn btn-lg btn-primary"
                    data-bs-toggle="modal"
                    style="padding: 5px"
                    data-bs-target="#addTemplateModel"
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
                <!-- <div class="card-header">
                    <h5 class="card-title">DataTables with Fixed Header</h5>
                    <h6 class="card-subtitle text-muted">
                        The Fixed Header DataTables extension ensures the table
                        headers don't leave the user's viewport when scrolling
                        down. See official documentation
                        <a
                            href="https://datatables.net/extensions/fixedheader/"
                            target="_blank"
                            rel="noopener noreferrer nofollow"
                            >here</a
                        >.
                    </h6>
                </div> -->
                <div class="card-body">
                    <table
                        id="datatables-fixed-header"
                        class="table table-striped w-100"
                    >
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $template)
                            <tr>
                                <td style="width: 40%">
                                    {{ $template->content }}
                                </td>
                                <td>{{ ucfirst($template->type) }}</td>
                                <td>{{ $template->title }}</td>
                                <td>
                                    {{ $template->status ? "Active" : "Inactive" }}
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        title="View"
                                        class="btn btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewTemplateModal{{ $template->id }}"
                                    >
                                        <i
                                            class="align-middle"
                                            data-lucide="eye"
                                            style="
                                                color: #3f80ea;
                                                width: 20px;
                                                height: 20px;
                                            "
                                        ></i>
                                    </button>

                                    <!-- View Template Modal -->
                                    <div
                                        class="modal fade"
                                        id="viewTemplateModal{{ $template->id }}"
                                        tabindex="-1"
                                        aria-labelledby="viewTemplateModalLabel{{ $template->id }}"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5
                                                        class="modal-title"
                                                        id="viewTemplateModalLabel{{ $template->id }}"
                                                    >
                                                        View Message Template
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
                                                            for="viewDescription{{ $template->id }}"
                                                            >Message
                                                            Content</label
                                                        >
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
                                                        <label
                                                            for="viewTitle{{ $template->id }}"
                                                            >Type</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewType{{ $template->id }}"
                                                            value="{{ $template->type }}"
                                                            readonly
                                                        />
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            for="viewTitle{{ $template->id }}"
                                                            >Message
                                                            Category</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewType{{ $template->id }}"
                                                            value="{{ $template->title }}"
                                                            readonly
                                                        />
                                                    </div>
                                                    <div class="form-group">
                                                        <label
                                                            for="viewStatus{{ $template->id }}"
                                                            >Status</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewStatus{{ $template->id }}"
                                                            value="{{ $template->status ? 'Active' : 'Inactive' }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <!-- <div class="form-group">
                                                        <label
                                                            for="viewCreatedBy{{ $template->id }}"
                                                            >Created By</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewCreatedBy{{ $template->id }}"
                                                            value="{{ $template->created_by }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="viewUpdatedBy{{ $template->id }}"
                                                            >Updated By</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewUpdatedBy{{ $template->id }}"
                                                            value="{{ $template->updated_by }}"
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
                                        data-bs-target="#editTemplateModal{{ $template->id }}"
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

                                    <!-- Edit Template Modal -->

                                    <div
                                        class="modal fade"
                                        id="editTemplateModal{{ $template->id }}"
                                        tabindex="-1"
                                        role="dialog"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form
                                                    id="editTemplateForm{{ $template->id }}"
                                                    action="{{ route('message-templates.update', $template->id) }}"
                                                    method="POST"
                                                    onsubmit="return validateEditForm('{{$template->id}}')"
                                                >
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5
                                                            class="modal-title"
                                                            id="editTemplateModalLabel{{ $template->id }}"
                                                        >
                                                            Edit Message
                                                            Template
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
                                                                for="content{{ $template->id }}"
                                                                >Content</label
                                                            >
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
                                                            <label
                                                                for="type{{ $template->id }}"
                                                                >Type</label
                                                            >
                                                            <select
                                                                class="form-control"
                                                                id="type{{ $template->id }}"
                                                                name="type"
                                                            >
                                                                @if(strcmp($template->type,"message")==0)
                                                                <option
                                                                    value="message"
                                                                    selected
                                                                >
                                                                    Message
                                                                </option>
                                                                <option
                                                                    value="sms"
                                                                >
                                                                    SMS
                                                                </option>
                                                                <option
                                                                    value="email"
                                                                >
                                                                    Email
                                                                </option>
                                                                @elseif(strcmp($template->type,"sms")==0)
                                                                <option
                                                                    value="message"
                                                                >
                                                                    Message
                                                                </option>
                                                                <option
                                                                    value="sms"
                                                                    selected
                                                                >
                                                                    SMS
                                                                </option>
                                                                <option
                                                                    value="email"
                                                                >
                                                                    Email
                                                                </option>
                                                                @else
                                                                <option
                                                                    value="message"
                                                                >
                                                                    Message
                                                                </option>
                                                                <option
                                                                    value="sms"
                                                                >
                                                                    SMS
                                                                </option>
                                                                <option
                                                                    value="email"
                                                                    selected
                                                                >
                                                                    Email
                                                                </option>

                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="status{{ $template->id }}"
                                                                >Message
                                                                Category</label
                                                            >
                                                            <select
                                                                class="form-control"
                                                                id="messageCategoryId{{ $template->id }}"
                                                                name="messageCategoryId"
                                                            >
                                                                @foreach($categories as $category)
                                                                @if($category->id==$template->catId)
                                                                <option value="{{$category->id}}" selected>{{$category->title}}</option>
                                                                @else
                                                                   <option value="{{$category->id}}">{{$category->title}}</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="status{{ $template->id }}"
                                                                >Status</label
                                                            >
                                                            <select
                                                                class="form-control"
                                                                id="status{{ $template->id }}"
                                                                name="status"
                                                            >
                                                                @if($template->status==1)
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
                                                'message-templates.destroy',
                                                $template
                                            )
                                        }}"
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return confirm('Are you sure you want to delete this template?');"
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

            <!-- Add Template Modal -->
            <div
                class="modal fade"
                id="addTemplateModel"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form
                            id="addTemplateForm"
                            action="{{ route('message-templates.store') }}"
                            method="POST"
                            onsubmit="return validateForm()"
                        >
                            @csrf
                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    id="addTemplateModalLabel"
                                >
                                    Add Message Template
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
                                    <label for="type">Type</label>
                                    <select
                                        class="form-control"
                                        id="type"
                                        name="type"
                                    >
                                        <option value="message">Message</option>
                                        <option value="sms">SMS</option>
                                        <option value="email">Email</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="messageCategoryId"
                                        >Message Category</label
                                    >
                                    <select
                                        class="form-control"
                                        id="messageCategoryId"
                                        name="messageCategoryId"
                                        required
                                    >
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}">
                                            {{$category->title}}
                                        </option>
                                        @endforeach
                                    </select>
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
            </script>
        </div>
    </div>
</div>
@endsection
