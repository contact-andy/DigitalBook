@extends('layouts.app') 
@section('title', 'Survey Approval')
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
            <h3>Survey Approval</h3>
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
                            @foreach ($surveys as $survey)
                            <tr>
                                <td>{{ $survey->title }}</td>
                                <td>{{ $survey->name }}</td>
                                <td id="statusView{{ $survey->id }}">
                                    @if($survey->status)
                                        <span class='badge text-bg-success'>Approved</span>
                                    @else
                                        <span class='badge text-bg-danger'>Not Approved</span>
                                    @endif
                                    
                                    
                                </td>
                                <td>{{ $survey->comment }}</td>
                                <td>
                                    <button type="button" title="View & Approve" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#approveCategoryModal{{ $survey->id }}">
                                        <i class="align-middle" data-lucide="list-todo" style="color: #3f80ea;width: 20px;height: 20px;"></i>
                                    </button>

                                    <!-- Approve Category Modal -->
                                    <div class="modal fade" id="approveCategoryModal{{ $survey->id }}" tabindex="-1" role="dialog" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                    <form id="approveCategoryForm{{ $survey->id }}" action="{{ route('survey-approval.approve', $survey->id) }}" method="POST">
                                                        @csrf @method('PUT')                                                    
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="approveCategoryModalLabel{{ $survey->id }}">
                                                            Approve Message Category 
                                                            <div id="statusView2{{ $survey->id }}" style='display:inline;'>
                                                                @if($survey->status)
                                                                    <span class='badge text-bg-success'>Approved</span>
                                                                @else
                                                                    <span class='badge text-bg-danger'>Not Approved</span>
                                                                @endif
                                                            </div>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id{{ $survey->id }}" name="id" value="{{ $survey->id }}" required readonly/>
                                                        <div class="form-group">
                                                            <label for="campus{{ $survey->id }}">Campus</label>
                                                            <select class="form-control" id="campusId{{ $survey->id }}" name="campusId">
                                                                @foreach($campuses as $campus)
                                                                    @if($survey->campusId==$campus->id)
                                                                        <option value="{{$campus->id}}" selected>{{$campus->name}}</option>
                                                                    {{-- @else
                                                                        <option value="{{$campus->id}}">{{$campus->name}}</option> --}}
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title{{ $survey->id }}" >Title</label>
                                                            <input
                                                                type="text"
                                                                class="form-control @error('title') is-invalid @enderror"
                                                                id="title{{ $survey->id }}"
                                                                name="title"
                                                                value="{{ old('title', $survey->title) }}"
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
                                                            <label for="description{{ $survey->id }}">Description</label>
                                                            <textarea
                                                                style="
                                                                    max-height: 100px;
                                                                    min-height: 100px;
                                                                "
                                                                class="form-control @error('description') is-invalid @enderror"
                                                                id="description{{ $survey->id }}"
                                                                name="description"
                                                                readonly
                                                                >{{ old('description', $survey->description) }}</textarea
                                                            >
                                                            @error('description')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <hr />
                                                        <div class="form-group">
                                                            <label for="comment{{ $survey->id }}">Comment</label>
                                                            <textarea
                                                                style="
                                                                    max-height: 100px;
                                                                    min-height: 100px;
                                                                "
                                                                class="form-control @error('comment') is-invalid @enderror"
                                                                id="comment{{ $survey->id }}"
                                                                name="comment"
                                                                >{{ old('comment', $survey->comment) }}</textarea
                                                            >
                                                            @error('comment')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status{{ $survey->id }}">Status</label>
                                                            <select class="form-control" id="status{{ $survey->id }}" name="status">
                                                                @if($survey->status)
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
                                    @if($survey->status)
                                        <button type="button" id="rejectButton{{ $survey->id }}" title="Reject" class="btn btn-sm" onclick="approveRejectInstant({{ $survey->id }}, 0)">
                                            <i class="align-middle" data-lucide="rotate-ccw" style="color: #D9534F;width: 20px;height: 20px;"></i>
                                        </button>
                                        <button type="button" hidden id="approveButton{{ $survey->id }}" title="Approve" class="btn btn-sm" onclick="approveRejectInstant({{ $survey->id }}, 1)">
                                            <i class="align-middle" data-lucide="circle-check-big" style="color: #4BBF73;width: 20px;height: 20px;"></i>
                                        </button>
                                    @else
                                        <button type="button" id="approveButton{{ $survey->id }}"  title="Approve" class="btn btn-sm" onclick="approveRejectInstant({{ $survey->id }}, 1)">
                                            <i class="align-middle" data-lucide="circle-check-big" style="color: #4BBF73;width: 20px;height: 20px;"></i>
                                        </button>
                                        <button type="button" hidden id="rejectButton{{ $survey->id }}" title="Reject" class="btn btn-sm" onclick="approveRejectInstant({{ $survey->id }}, 0)">
                                            <i class="align-middle" data-lucide="rotate-ccw" style="color: #D9534F;width: 20px;height: 20px;"></i>
                                        </button>
                                    @endif
                                    {{-- <!-- Approve Button -->
                                    <button class="btn btn-success approve-survey" data-id="{{ $survey->id }}">Approve</button>

                                    <!-- Reject Button -->
                                    <button class="btn btn-danger reject-survey" data-id="{{ $survey->id }}">Reject</button> --}}


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
                function approveRejectInstant(surveyId, status) {
                    // var surveyId = $(this).data('id');
                    // alert(status)
                    document.getElementById("statusView"+surveyId).innerHTML = "<span class='badge text-bg-primary'>Pending . . .</span>";
                    document.getElementById("statusView2"+surveyId).innerHTML = "<span class='badge text-bg-primary'>Pending . . .</span>";
                    $.ajax({
                        url: '{{ route('survey-approval.instantApprove') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: surveyId,
                            status
                        },
                        success: function(response) {
                            if(response.success) {
                                // alert(response.message);
                                // You can add code here to update the UI, such as disabling the button, etc.
                                
                                if(status){
                                    document.getElementById("statusView"+surveyId).innerHTML = "<span class='badge text-bg-success'>Approved</span>";
                                    document.getElementById("statusView2"+surveyId).innerHTML = "<span class='badge text-bg-success'>Approved</span>";
                                    document.getElementById("rejectButton"+surveyId).hidden = "";
                                    document.getElementById("approveButton"+surveyId).hidden = "hidden";   
                                    console.log(document.getElementById("status"+surveyId).selectedIndex)
                                    let index = document.getElementById("status"+surveyId).selectedIndex;
                                    document.getElementById("status"+surveyId).selectedIndex = index?0:1;
                                    console.log(document.getElementById("status"+surveyId).selectedIndex)                             
                                }
                                else{
                                    document.getElementById("statusView"+surveyId).innerHTML = "<span class='badge text-bg-danger'>Not Approved</span>";
                                    document.getElementById("statusView2"+surveyId).innerHTML = "<span class='badge text-bg-danger'>Not Approved</span>";
                                    document.getElementById("rejectButton"+surveyId).hidden = "hidden";
                                    document.getElementById("approveButton"+surveyId).hidden = "";
                                    console.log(document.getElementById("status"+surveyId).selectedIndex)
                                    let index = document.getElementById("status"+surveyId).selectedIndex;
                                    document.getElementById("status"+surveyId).selectedIndex = index?0:1;
                                    console.log(document.getElementById("status"+surveyId).selectedIndex)
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
