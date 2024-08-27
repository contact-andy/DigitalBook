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
                    data-bs-target="#addCategoryModel"
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $template)
                            <tr>
                                <td>{{ $template->content }}</td>
                                <td>
                                    {{ $template->status ? "Active" : "Inactive" }}
                                </td>
                                <td>
                                    @if ($template->trashed())
                                    <form
                                        action="{{ route('message-templates.restore', $template->id) }}"
                                        method="POST"
                                        style="display: inline"
                                    >
                                        @csrf @method('PATCH')
                                        <button
                                            type="submit"
                                            class="btn btn-success btn-sm"
                                        >
                                            Restore
                                        </button>
                                    </form>
                                    <form
                                        action="{{ route('message-templates.forceDelete', $template->id) }}"
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return confirm('Are you sure you want to delete this template permanently?');"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Delete Permanently
                                        </button>
                                    </form>
                                    @else

                                    <!-- <a
                                            title="View "
                                            href="{{
                                                route(
                                                    'message-templates.show',
                                                    $template
                                                )
                                            }}"
                                            >
                                            <button class="btn btn-icon">
                                                <i
                                                    class="align-middle"
                                                    data-lucide="eye"
                                                ></i>
                                            </button>
                                    </a> -->

                                    <button
                                        type="button"
                                        title="View"
                                        class="btn btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewCategoryModal{{ $template->id }}"
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

                                    <!-- View Category Modal -->
                                    <div
                                        class="modal fade"
                                        id="viewCategoryModal{{ $template->id }}"
                                        tabindex="-1"
                                        aria-labelledby="viewCategoryModalLabel{{ $template->id }}"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5
                                                        class="modal-title"
                                                        id="viewCategoryModalLabel{{ $template->id }}"
                                                    >
                                                        View Message Category
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
                                                            for="viewTitle{{ $template->id }}"
                                                            >Title</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewTitle{{ $template->id }}"
                                                            value="{{ $template->content }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="viewDescription{{ $template->id }}"
                                                            >Description</label
                                                        >
                                                        <textarea
                                                            style="
                                                                max-height: 150px;
                                                                min-height: 150px;
                                                            "
                                                            class="form-control"
                                                            id="viewDescription{{ $template->id }}"
                                                            readonly
                                                            >{{ $template->content }}</textarea
                                                        >
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
                                        data-bs-target="#editCategoryModal{{ $template->id }}"
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

                                    <!-- Edit Category Modal -->

                                    <div
                                        class="modal fade"
                                        id="editCategoryModal{{ $template->id }}"
                                        tabindex="-1"
                                        role="dialog"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form
                                                    id="editCategoryForm{{ $template->id }}"
                                                    action="{{ route('message-templates.update', $template->id) }}"
                                                    method="POST"
                                                    onsubmit="return validateEditForm('{{$template->id}}')"
                                                >
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5
                                                            class="modal-title"
                                                            id="editCategoryModalLabel{{ $template->id }}"
                                                        >
                                                            Edit Message
                                                            Category
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
                                                                for="title{{ $template->id }}"
                                                                >Title</label
                                                            >
                                                            <input
                                                                type="text"
                                                                class="form-control @error('title') is-invalid @enderror"
                                                                id="title{{ $template->id }}"
                                                                name="title"
                                                                value="{{ old('title', $template->content) }}"
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
                                                                for="description{{ $template->id }}"
                                                                >Description</label
                                                            >
                                                            <textarea
                                                                style="
                                                                    max-height: 150px;
                                                                    min-height: 150px;
                                                                "
                                                                class="form-control @error('description') is-invalid @enderror"
                                                                id="description{{ $template->id }}"
                                                                name="description"
                                                                >{{ old('description', $template->content) }}</textarea
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
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- New Table -->
            </div>

            <!-- Add Category Modal -->
            <div
                class="modal fade"
                id="addCategoryModel"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form
                            id="addCategoryForm"
                            action="{{ route('message-templates.store') }}"
                            method="POST"
                            onsubmit="return validateForm()"
                        >
                            @csrf
                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    id="addCategoryModalLabel"
                                >
                                    Add Message Category
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
@endsection
