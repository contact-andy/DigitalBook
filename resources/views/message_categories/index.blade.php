@extends('layouts.app') @section('title', 'Message Categories')
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
            <h3>Message Categories</h3>
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
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->title }}</td>
                                <td>
                                    {{ $category->status ? "Active" : "Inactive" }}
                                </td>
                                <td>
                                    @if ($category->trashed())
                                    <form
                                        action="{{ route('message-categories.restore', $category->id) }}"
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
                                        action="{{ route('message-categories.forceDelete', $category->id) }}"
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return confirm('Are you sure you want to delete this category permanently?');"
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
                                                    'message-categories.show',
                                                    $category
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
                                        data-bs-target="#viewCategoryModal{{ $category->id }}"
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
                                        id="viewCategoryModal{{ $category->id }}"
                                        tabindex="-1"
                                        aria-labelledby="viewCategoryModalLabel{{ $category->id }}"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5
                                                        class="modal-title"
                                                        id="viewCategoryModalLabel{{ $category->id }}"
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
                                                            for="viewTitle{{ $category->id }}"
                                                            >Title</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewTitle{{ $category->id }}"
                                                            value="{{ $category->title }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="viewDescription{{ $category->id }}"
                                                            >Description</label
                                                        >
                                                        <textarea
                                                            style="
                                                                max-height: 150px;
                                                                min-height: 150px;
                                                            "
                                                            class="form-control"
                                                            id="viewDescription{{ $category->id }}"
                                                            readonly
                                                            >{{ $category->description }}</textarea
                                                        >
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="viewStatus{{ $category->id }}"
                                                            >Status</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewStatus{{ $category->id }}"
                                                            value="{{ $category->status ? 'Active' : 'Inactive' }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <!-- <div class="form-group">
                                                        <label
                                                            for="viewCreatedBy{{ $category->id }}"
                                                            >Created By</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewCreatedBy{{ $category->id }}"
                                                            value="{{ $category->created_by }}"
                                                            readonly
                                                        />
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="viewUpdatedBy{{ $category->id }}"
                                                            >Updated By</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="viewUpdatedBy{{ $category->id }}"
                                                            value="{{ $category->updated_by }}"
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
                                        data-bs-target="#editCategoryModal{{ $category->id }}"
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
                                        id="editCategoryModal{{ $category->id }}"
                                        tabindex="-1"
                                        role="dialog"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form
                                                    id="editCategoryForm{{ $category->id }}"
                                                    action="{{ route('message-categories.update', $category->id) }}"
                                                    method="POST"
                                                    onsubmit="return validateEditForm('{{$category->id}}')"
                                                >
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5
                                                            class="modal-title"
                                                            id="editCategoryModalLabel{{ $category->id }}"
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
                                                                for="title{{ $category->id }}"
                                                                >Title</label
                                                            >
                                                            <input
                                                                type="text"
                                                                class="form-control @error('title') is-invalid @enderror"
                                                                id="title{{ $category->id }}"
                                                                name="title"
                                                                value="{{ old('title', $category->title) }}"
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
                                                                for="description{{ $category->id }}"
                                                                >Description</label
                                                            >
                                                            <textarea
                                                                style="
                                                                    max-height: 150px;
                                                                    min-height: 150px;
                                                                "
                                                                class="form-control @error('description') is-invalid @enderror"
                                                                id="description{{ $category->id }}"
                                                                name="description"
                                                                >{{ old('description', $category->description) }}</textarea
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
                                                                for="status{{ $category->id }}"
                                                                >Status</label
                                                            >
                                                            <select
                                                                class="form-control"
                                                                id="status{{ $category->id }}"
                                                                name="status"
                                                            >
                                                                @if($category->status==1)
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
                                                'message-categories.destroy',
                                                $category
                                            )
                                        }}"
                                        method="POST"
                                        style="display: inline"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');"
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
                            action="{{ route('message-categories.store') }}"
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
