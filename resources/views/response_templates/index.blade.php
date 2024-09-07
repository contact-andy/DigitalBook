@extends('layouts.app') @section('title', 'Response Templates')
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
            <h3>Response Templates</h3>
        </div>

        <div class="col-auto ms-auto text-end mt-n1">
            <div class="d-grid mb-4">
                <button
                    type="button"
                    class="btn btn-lg btn-primary"
                    data-bs-toggle="modal"
                    style="padding: 5px"
                    data-bs-target="#addResponseTemplateModel"
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
                @php
                    $messagetTemplateIdCollection="";
                    foreach ($messageTemplates as $temp){
                        $messagetTemplateIdCollection.= $temp->id.',';
                    }
                @endphp
                <div class="card-body">
                    <table id="datatables-fixed-header" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>Response Message</th>
                                <th>Response For</th>
                                <th>Campus</th>
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
                                <td>
                                    <button class="btn " 
                                        type="button" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="bottom" 
                                        title="{{ $template->tempContent }}">
                                        Template-{{ $template->tempId }} 
                                    </button>
                                </td>
                                <td>{{ $template->name }}</td>
                                <td>
                                    @if($template->status)
                                        <span class='badge text-bg-success'>Approved</span>
                                    @else
                                        <span class='badge text-bg-danger'>Not Approved</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" title="View" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#viewResponseTemplateModal{{ $template->id }}">
                                        <i class="align-middle" data-lucide="eye" style="color: #3f80ea;width: 20px;height: 20px;"></i>
                                    </button>

                                    <!-- View Template Modal -->
                                    <div class="modal fade" id="viewResponseTemplateModal{{ $template->id }}" tabindex="-1" aria-labelledby="viewResponseTemplateModalLabel{{ $template->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewResponseTemplateModalLabel{{ $template->id }}">
                                                        View Response Template
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group">
                                                        <label for="viewCampus{{ $template->id }}">Campus</label>
                                                        <input type="text" class="form-control" id="viewCampus{{ $template->id }}" value="{{ $template->name }}" readonly/>
                                                    </div>
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
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($template->status ==0 )
                                        <button type="button" title="Edit" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editResponseTemplateModal{{ $template->id }}">
                                            <i class="align-middle" data-lucide="pencil" style="color: #e5a54b;width: 20px;height: 20px;"></i>
                                        </button>

                                        <!-- Edit Template Modal -->

                                        <div class="modal fade" id="editResponseTemplateModal{{ $template->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form
                                                        id="editTemplateForm{{ $template->id }}"
                                                        action="{{ route('response-templates.update', $template->id) }}"
                                                        method="POST"
                                                        onsubmit="return validateEditForm('{{$template->id}}')"
                                                    >
                                                        @csrf @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editResponseTemplateModalLabel{{ $template->id }}">
                                                                Edit Response Template
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="editCampus{{ $template->id }}">Campus</label>
                                                                <select class="form-control" id="editCampusId{{ $template->id }}" name="campusId">
                                                                    @foreach($campuses as $campus)
                                                                        @if($template->campusId==$campus->id)
                                                                            <option value="{{$campus->id}}" selected>{{$campus->name}}</option>
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
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="status{{ $template->id }}">Message Template</label>
                                                                {{-- <select
                                                                    class="form-control"
                                                                    id="messageTemplateId{{ $template->id }}"
                                                                    name="messageTemplateId"
                                                                >
                                                                    @foreach($messageTemplates as $temp)
                                                                    @if($temp->id==$template->tempId)
                                                                    <option value="{{$temp->id}}" selected>{{$temp->content}}</option>
                                                                    @else
                                                                    <option value="{{$temp->id}}">{{$temp->content}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select> --}}
                                                                <select
                                                                    class="form-control"
                                                                    id="messageTemplateEditId"
                                                                    name="messageTemplateId"
                                                                    required
                                                                    onChange="displayMessageContent('{{$messagetTemplateIdCollection}}','messageTemplateEditView','messageTemplateEditId')"
                                                                >
                                                                    @foreach ($messageTemplates as $temp)
                                                                        @if($temp->id==$template->tempId)
                                                                            <option value="{{$temp->id}}" selected>Template-{{ $temp->id }} </option>
                                                                        @else
                                                                            <option value="{{$temp->id}}">Template-{{ $temp->id }} </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                @foreach ($messageTemplates as $temp)
                                                                    @if($temp->id==$template->tempId)
                                                                        <lable 
                                                                        id='messageTemplateEditView{{$temp->id}}' 
                                                                        style='display:block;margin-top:5px;border:1px dashed darkblue;padding:10px;'>
                                                                        <h5>Template-{{$temp->id}}</h5>{{$temp->content}}
                                                                    </lable>
                                                                    @else
                                                                        <lable 
                                                                        id='messageTemplateEditView{{$temp->id}}' 
                                                                        style='display:none;margin-top:5px;border:1px dashed darkblue;padding:10px;'>
                                                                        <h5>Template-{{$temp->id}}</h5>{{$temp->content}}
                                                                        </lable>
                                                                    @endif
                                                                    {{-- <lable 
                                                                        id='messageTemplateView{{$temp->id}}' 
                                                                        style='display:none;margin-top:5px;border:1px dashed darkblue;padding:10px;'>
                                                                        <h5>Template-{{$temp->id}}</h5>{{$temp->content}}
                                                                    </lable> --}}
                                                                @endforeach
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

                                        <form action="{{route('response-templates.destroy',$template)}}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure you want to delete this template?');">
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
            <div class="modal fade" id="addResponseTemplateModel" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="addResponseTemplateForm" action="{{ route('response-templates.store') }}" method="POST" onsubmit="return validateForm()">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="addResponseTemplateModalLabel">
                                    Add Response Template
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="campusId">Campus</label>
                                    <select class="form-control" id="campusId" name="campusId">
                                        @foreach($campuses as $campus)
                                            <option value="{{$campus->id}}">{{$campus->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="messageTemplateId">Message Template</label >
                                    <select
                                        multiple
                                        class="form-control"
                                        id="messageTemplateId"
                                        name="messageTemplateId[]"
                                        required
                                        onChange="displayMessageContent('{{$messagetTemplateIdCollection}}','messageTemplateView','messageTemplateId')"
                                    >
                                        @foreach ($messageTemplates as $temp)
                                        <option value="{{$temp->id}}">
                                            {{-- <button class="btn " 
                                                type="button" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="bottom" 
                                                title="{{ $temp->content }}">
                                                Template-{{ $temp->id }} 
                                            </button> --}}
                                            Template-{{ $temp->id }} 
                                            {{-- {{$temp->content}}  --}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @foreach ($messageTemplates as $temp)
                                        <lable 
                                            id='messageTemplateView{{$temp->id}}' 
                                            style='display:none;margin-top:5px;border:1px dashed darkblue;padding:10px;'>
                                            <h5>Template-{{$temp->id}}</h5>{{$temp->content}}
                                        </lable>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <label for="content">Response Message Content</label>
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
                function displayMessageContent(messageTemplate,viewName,selectId)
                {
                    let collection= messageTemplate.split(',');
                    for(let i=0;i<collection.length-1;i++)
                    {
                        document.getElementById(viewName+collection[i]).style.display='none';
                    }
                    let id =  document.getElementById(selectId).value;
                    let view = document.getElementById(viewName+id);
                    view.style.display='block';
                    // alert(viewName);
                }
            </script>
        </div>
    </div>
</div>
@endsection
