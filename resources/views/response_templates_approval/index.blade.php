@extends('layouts.app') @section('title', 'Response Templates Approval')
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
            <h3>Response Templates Approval</h3>
        </div>

    </div>

    <div class="row" style="margin-top: 0px">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatables-fixed-header" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>Response Message</th>
                                <th>Response For</th>
                                <th>Content OK?</th> 
                                <th>grammar OK?</th>
                                <th>Spelling OK?</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $template)
                            <tr>
                                @php
                                    $contentOk =$template->content_ok;
                                    $grammarOk =$template->grammar_ok;
                                    $spellingOk =$template->spelling_ok;
                                    $comment =$template->comment;
                                @endphp
                                {{-- <td>{{ $template->id}}</td> --}}
                                <td style="width: 40%">
                                    {{ $template->content }}
                                    <br>
                                    <div id="statusView{{ $template->id }}">
                                        @if($contentOk == 1 && $grammarOk == 1 && $spellingOk == 1)
                                            <span class='badge text-bg-success'>Approved</span>
                                        @else
                                            <span class='badge text-bg-danger'>Not Approved</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button class="btn " 
                                        type="button" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="bottom" 
                                        title="{{ $template->tempContent }}">
                                        Template-{{ $template->tempId }} 
                                    </button>
                                </td>
                                <td>
                                    <select class="form-control" id="contentOk{{$template->id}}" name="contentOk{{$template->id}}" onchange="updateOtherSelection({{$template->id}},'contentOk','')">
                                        @if ($contentOk == 1)
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="grammarOk{{$template->id}}" name="grammarOk{{$template->id}}" onchange="updateOtherSelection({{$template->id}},'grammarOk','')">
                                        @if ($grammarOk == 1)
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="spellingOk{{$template->id}}" name="spellingOk{{$template->id}}" onchange="updateOtherSelection({{$template->id}},'spellingOk','')">
                                       @if ($spellingOk == 1)
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                        @endif
                                    </select>
                                </td>
                                
                                <td>{{ $comment }}</td>
                                <td>
                                    
                                    <!-- Approve Message Template Modal -->

                                    <button type="button" title="View & Approve" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#viewTemplateModal{{ $template->id }}">
                                        <i class="align-middle" data-lucide="list-todo" style="color: #3f80ea;width: 20px;height: 20px;"></i>
                                    </button>
                                    <div class="modal fade" id="viewTemplateModal{{ $template->id }}" tabindex="-1" aria-labelledby="viewTemplateModalLabel{{ $template->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewTemplateModalLabel{{ $template->id }}">
                                                        View Response Template 
                                                        <div id="viewStatus{{ $template->id }}" style='display:inline;'>
                                                            @if($contentOk == 1 && $grammarOk == 1 && $spellingOk == 1)
                                                                <span class='badge text-bg-success'>Approved</span>
                                                            @else
                                                                <span class='badge text-bg-danger'>Not Approved</span>
                                                            @endif
                                                        </div> 
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="saveTemplateForm{{ $template->id }}" action="{{ route('response-templates-approval.approve', $template->id) }}"  method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" id="id{{ $template->id }}" name="id" value="{{ $template->id }}" required readonly/>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="viewCampus{{ $template->id }}">Campus</label>
                                                            <select class="form-control" id="campusId{{ $template->id }}" name="campusId">
                                                                @foreach($campuses as $campus)
                                                                    @if($template->campusId==$campus->id)
                                                                        <option value="{{$campus->id}}">{{$campus->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="viewTitle{{ $template->id }}">Message Template</label>
                                                                    <textarea style="max-height: 150px;min-height: 150px;"
                                                                        class="form-control"
                                                                        id="viewMessageTemplate{{ $template->id }}"
                                                                        value="{{ $template->tempContent }}"
                                                                        readonly
                                                                        >{{ $template->tempContent }}</textarea
                                                                    >
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="viewDescription{{ $template->id }}">Response Content</label >
                                                                    <textarea style="max-height: 150px;min-height: 150px;"
                                                                        class="form-control"
                                                                        id="viewContent{{ $template->id }}"
                                                                        readonly
                                                                        required
                                                                        >{{ $template->content }}</textarea
                                                                    >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <hr />
                                                        <div class="form-group">
                                                            <label for="comment{{ $template->id }}">Comment</label>
                                                            <textarea
                                                                style="
                                                                    max-height: 100px;
                                                                    min-height: 100px;
                                                                "
                                                                class="form-control @error('comment') is-invalid @enderror"
                                                                id="comment{{ $template->id }}"
                                                                name="comment"
                                                                >{{ old('comment', $template->comment) }}</textarea
                                                            >
                                                            @error('comment')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>   
                                                        
                                                        <div class="row">
                                                            <div class="col-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="contentOkView{{ $template->id }}">Content Ok?</label>
                                                                        <select class="form-control" id="contentOkView{{$template->id}}" name="content_ok" onchange="updateOtherSelection({{$template->id}},'contentOk','View')">
                                                                            @if ($contentOk == 1)
                                                                                <option value="1" selected>Yes</option>
                                                                                <option value="0">No</option>
                                                                            @else
                                                                                <option value="1">Yes</option>
                                                                                <option value="0" selected>No</option>
                                                                            @endif
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="grammarOkView{{ $template->id }}">grammar Ok?</label>
                                                                        <select class="form-control" id="grammarOkView{{$template->id}}" name="grammar_ok" onchange="updateOtherSelection({{$template->id}},'grammarOk','View')">
                                                                            @if ($grammarOk == 1)
                                                                                <option value="1" selected>Yes</option>
                                                                                <option value="0">No</option>
                                                                            @else
                                                                                <option value="1">Yes</option>
                                                                                <option value="0" selected>No</option>
                                                                            @endif
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="spellingOkView{{ $template->id }}">Spelling Ok?</label>
                                                                        <select class="form-control" id="spellingOkView{{$template->id}}" name="spelling_ok" onchange="updateOtherSelection({{$template->id}},'spellingOk','View')">
                                                                            @if ($spellingOk == 1)
                                                                                    <option value="1" selected>Yes</option>
                                                                                    <option value="0">No</option>
                                                                                @else
                                                                                    <option value="1">Yes</option>
                                                                                    <option value="0" selected>No</option>
                                                                                @endif
                                                                        </select>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            
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
                                    <button type="button" id="save{{ $template->id }}" title="Save" class="btn btn-sm" onclick="saveApproval({{ $template->id }}, 0)">
                                        <i class="align-middle" data-lucide="save" style="color:#4BBF73 ;width: 20px;height: 20px;"></i>
                                    </button>
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
                function saveApproval(templateId, status) {
                    // var categoryId = $(this).data('id');
                    // alert(categoryId)
                    let contentOkValue = document.getElementById("contentOk"+templateId).value;
                    let grammarOkValue = document.getElementById("grammarOk"+templateId).value;
                    let spellingOkValue = document.getElementById("spellingOk"+templateId).value;

                    console.log(contentOkValue)
                    console.log(grammarOkValue)
                    console.log(spellingOkValue)
                    
                    document.getElementById("statusView"+templateId).innerHTML = "<span class='badge text-bg-primary'>Pending . . .</span>";
                    document.getElementById("viewStatus"+templateId).innerHTML = "<span class='badge text-bg-primary'>Pending . . .</span>";
                    $.ajax({
                        url: '{{ route('response-approval.instantApprove') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: templateId,
                            contentOkValue,
                            grammarOkValue,
                            spellingOkValue,
                        },
                        success: function(response) {
                            if(response.success) {
                                // alert(response.message);
                                // You can add code here to update the UI, such as disabling the button, etc.
                                if(contentOkValue== 1 && grammarOkValue== 1 && spellingOkValue== 1){
                                    document.getElementById("statusView"+templateId).innerHTML = "<span class='badge text-bg-success'>Approved</span>";
                                    document.getElementById("viewStatus"+templateId).innerHTML = "<span class='badge text-bg-success'>Approved</span>";

                                }
                                else{
                                    document.getElementById("statusView"+templateId).innerHTML = "<span class='badge text-bg-danger'>Not Approved</span>";
                                    document.getElementById("viewStatus"+templateId).innerHTML = "<span class='badge text-bg-danger'>Not Approved</span>";

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
                
                function updateOtherSelection(templateId,changeName, view){
                    let index= document.getElementById(changeName+view+templateId).selectedIndex;
                    document.getElementById(changeName+templateId).selectedIndex = index;
                    document.getElementById(changeName+"View"+templateId).selectedIndex = index;
                    // console.log(changeName+view+templateId)
                    
                }
            </script>
        </div>
    </div>
</div>
@endsection
