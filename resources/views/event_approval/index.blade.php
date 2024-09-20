@extends('layouts.app') 
@section('title', 'Event Approval')
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
            <h3>Event Approval</h3>
        </div>
    </div>

    <div class="row" style="margin-top: 0px">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatables-fixed-header" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Campus</th>
                                <th>Status</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <label style='background:{{$category->color}};padding-right:20px'>&nbsp;</label>
                                    {{ $category->title }}
                                </td>
                                <td>{{ $category->name }}</td>
                                <td id="statusView{{ $category->id }}">
                                    @if($category->status)
                                        <span class='badge text-bg-success'>Approved</span>
                                    @else
                                        <span class='badge text-bg-danger'>Not Approved</span>
                                    @endif
                                    
                                    </div>
                                    
                                </td>
                                <td>{{ $category->comment }}</td>
                                <td>
                                    <button type="button" title="View & Approve" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#approveCategoryModal{{ $category->id }}">
                                        <i class="align-middle" data-lucide="list-todo" style="color: #3f80ea;width: 20px;height: 20px;"></i>
                                    </button>

                                    <!-- Approve Category Modal -->
                                    <div class="modal fade" id="approveCategoryModal{{ $category->id }}" tabindex="-1" role="dialog" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                    <form id="approveCategoryForm{{ $category->id }}" action="{{ route('event-approval.approve', $category->id) }}" method="POST">
                                                        @csrf @method('PUT')                                                    
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="approveCategoryModalLabel{{ $category->id }}">
                                                            Approve Event Category 
                                                            @if($category->status)
                                                                <span class='badge text-bg-success'>Approved</span>
                                                            @else
                                                                <span class='badge text-bg-danger'>Not Approved</span>
                                                            @endif
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id{{ $category->id }}" name="id" value="{{ $category->id }}" required readonly/>
                                                        <div class="form-group">
                                                            <label for="campus{{ $category->id }}">Campus</label>
                                                            <select class="form-control" id="campusId{{ $category->id }}" name="campusId">
                                                                @foreach($campuses as $campus)
                                                                    @if($category->campusId==$campus->id)
                                                                        <option value="{{$campus->id}}" selected>{{$campus->name}}</option>
                                                                    {{-- @else
                                                                        <option value="{{$campus->id}}">{{$campus->name}}</option> --}}
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title{{ $category->id }}" >Title</label>
                                                            <input
                                                                type="text"
                                                                class="form-control @error('title') is-invalid @enderror"
                                                                id="title{{ $category->id }}"
                                                                name="title"
                                                                value="{{ old('title', $category->title) }}"
                                                                required
                                                                readonly
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
                                                            <label for="description{{ $category->id }}">Description</label>
                                                            <textarea
                                                                style="
                                                                    max-height: 100px;
                                                                    min-height: 100px;
                                                                "
                                                                class="form-control @error('description') is-invalid @enderror"
                                                                id="description{{ $category->id }}"
                                                                name="description"
                                                                readonly
                                                                >{{ old('description', $category->description) }}</textarea
                                                            >
                                                            @error('description')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="color">Color</label>
                                                            <input 
                                                                type="color" 
                                                                class="form-control form-control-color" 
                                                                id="color" name="color" value="{{$category->color}}" title="Choose a color" readonly>
                                                        </div>
                                                        
                                                        <hr />
                                                        <div class="form-group">
                                                            <label for="comment{{ $category->id }}">Comment</label>
                                                            <textarea
                                                                style="
                                                                    max-height: 100px;
                                                                    min-height: 100px;
                                                                "
                                                                class="form-control @error('comment') is-invalid @enderror"
                                                                id="comment{{ $category->id }}"
                                                                name="comment"
                                                                >{{ old('comment', $category->comment) }}</textarea
                                                            >
                                                            @error('comment')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status{{ $category->id }}">Status</label>
                                                            <select class="form-control" id="status{{ $category->id }}" name="status">
                                                                @if($category->status)
                                                                    <option value="1" selected>Approve</option>
                                                                    <option value="0">Not Approved</option>
                                                                @else
                                                                    <option value="1">Approve</option>
                                                                    <option value="0" selected>Not Approved</option>
                                                                @endif
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
                                    @if($category->status)
                                        <button type="button" id="rejectButton{{ $category->id }}" title="Reject" class="btn btn-sm" onclick="approveRejectInstant({{ $category->id }}, 0)">
                                            <i class="align-middle" data-lucide="rotate-ccw" style="color: #D9534F;width: 20px;height: 20px;"></i>
                                        </button>
                                        <button type="button" hidden id="approveButton{{ $category->id }}" title="Approve" class="btn btn-sm" onclick="approveRejectInstant({{ $category->id }}, 1)">
                                            <i class="align-middle" data-lucide="circle-check-big" style="color: #4BBF73;width: 20px;height: 20px;"></i>
                                        </button>
                                    @else
                                        <button type="button" id="approveButton{{ $category->id }}"  title="Approve" class="btn btn-sm" onclick="approveRejectInstant({{ $category->id }}, 1)">
                                            <i class="align-middle" data-lucide="circle-check-big" style="color: #4BBF73;width: 20px;height: 20px;"></i>
                                        </button>
                                        <button type="button" hidden id="rejectButton{{ $category->id }}" title="Reject" class="btn btn-sm" onclick="approveRejectInstant({{ $category->id }}, 0)">
                                            <i class="align-middle" data-lucide="rotate-ccw" style="color: #D9534F;width: 20px;height: 20px;"></i>
                                        </button>
                                    @endif
                                    {{-- <!-- Approve Button -->
                                    <button class="btn btn-success approve-category" data-id="{{ $category->id }}">Approve</button>

                                    <!-- Reject Button -->
                                    <button class="btn btn-danger reject-category" data-id="{{ $category->id }}">Reject</button> --}}


                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- New Table -->
            </div>

            <!-- Script to validate the form -->
            <script>
                function approveRejectInstant(categoryId, status) {
                    // var categoryId = $(this).data('id');
                    // alert(categoryId)
                    document.getElementById("statusView"+categoryId).innerHTML = "<span class='badge text-bg-primary'>Pending . . .</span>";
                    $.ajax({
                        url: '{{ route('event-approval.instantApprove') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: categoryId,
                            status
                        },
                        success: function(response) {
                            if(response.success) {
                                // alert(response.message);
                                // You can add code here to update the UI, such as disabling the button, etc.
                                
                                if(status){
                                    document.getElementById("statusView"+categoryId).innerHTML = "<span class='badge text-bg-success'>Approved</span>";
                                    document.getElementById("rejectButton"+categoryId).hidden = "";
                                    document.getElementById("approveButton"+categoryId).hidden = "hidden";                                
                                }
                                else{
                                    document.getElementById("statusView"+categoryId).innerHTML = "<span class='badge text-bg-danger'>Not Approved</span>";
                                    document.getElementById("rejectButton"+categoryId).hidden = "hidden";
                                    document.getElementById("approveButton"+categoryId).hidden = "";
                                }
                                
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Something went wrong. Please try again.');
                        }
                    });
                }
            </script>
        </div>
    </div>
</div>
@endsection
