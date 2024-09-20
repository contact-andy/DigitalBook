@extends('layouts.app') 
@section('title', 'Academic Calendar')
@section('content')
    <div class="container-fluid p-0">
        
        @php
            $selectedCampus = 0;
            $selectedCampusName = "EMPTy";
            if(session('selectedCampus')){
                $selectedCampus = session("selectedCampus");         
                foreach($campuses as $campus){
                    if($campus->id == $selectedCampus){
                        $selectedCampusName = $campus->name;
                        break;
                    }
                }
            }
            else{
                foreach($campuses as $campus){
                    $selectedCampusName = $campus->name;
                    $selectedCampus = $campus->id;
                    break;
                }
            }
        @endphp 
        <h1 class="h3 mb-3">
            <span class='badge text-bg-primary' style="font-size: 12px;font-weight:300;padding:10px;">
                {{$selectedCampusName}}
            </span>  
            Academic Calendar
        </h1>
        <div class="row">
            <div class="col-sm-5 col-xl-4">
                <div class="card">
                    <div class="card-body">
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

                        <form id="campusSelectionForm" name="campusSelectionForm" action="{{ route('after-campus-selection') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="campusId">Campus</label>
                                <select class="form-control" id="campusId" name="campusId" onChange="campusSelectionForm.submit();">
                                    @foreach($campuses as $campus)
                                        @if($campus->id == $selectedCampus)
                                            <option value="{{$campus->id}}" selected>{{$campus->name}}</option>
                                        @else
                                            <option value="{{$campus->id}}">{{$campus->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        
                        <hr/>           
                        <h6 class="text-uppercase">Recent Events</h6>
                          @foreach ($recentEvents as $rEvent)
                            @if($rEvent->campusId == $selectedCampus)
                                @php
                                        $eventDateColl = explode('-',$rEvent->start_date);
                                        $monthNum = $eventDateColl[1];
                                        $dayNum = $eventDateColl[2];
                                        $monthName = strtoupper(date("M", mktime(0, 0, 0, $monthNum, 10)));
                                        $description = $rEvent->description;
                                        if(strlen($description)>50)
                                        $description = substr($rEvent->description,0,50)."...";
                                @endphp
                                <div class="d-flex" data-bs-toggle="modal" data-bs-target="#viewCalendarModal{{ $rEvent->id }}" >
                                    <div class="flex-grow-0" style='color:white;background:{{$rEvent->color}};text-align:center;vertical-align:center;padding:5px;margin-right:5px;height:45px;width:50px;'>
                                        <h6 class="m-0" style='color:white'>{{$monthName}}</h6>
                                        <p class=" text-sm" style='font-size:25px;margin-top:-10px;color:white;'>{{$dayNum}}</p>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="m-0">{{$rEvent->title}}</h6>
                                        <p class="text-muted text-sm">{{$description}}</p>
                                    </div>
                                </div>     
                                
                                {{-- View Calendar Event --}}
                                <div class="modal fade" id="viewCalendarModal{{ $rEvent->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="d-flex">
                                                <div class="flex-grow-0" id='dateView' style='color:white;background:{{$rEvent->color}};
                                                text-align:center;vertical-align:center;padding:5px;margin-right:5px;height:300px;width:200px;display:flex;flex-direction:column;
                                                justify-content:center'>
                                                    <h6 class="m-0" style='color:#ffffff;font-size:70px;margin-top:50px;' id='monthNameView'>{{$monthName}}</h6>
                                                    <p class=" text-sm" style='font-size:125px;margin-top:-20px;color:white;' id='dayNumView'>{{$dayNum}}</p>
                                                </div>
                                                <div class="flex-grow-1"  style='margin:10px'>
                                                    <h3 class="m-0" id='titleView'>{{$rEvent->title}}</h3>
                                                    <div  style='margin:0px'>
                                                        <p class="text-muted text-sm" style='font-size:14px;margin:0px;'>
                                                            Start-Date:
                                                            <b class="m-0" id='startDateView'>{{$rEvent->start_date}}</b>
                                                        | 
                                                            End-Date:
                                                            <b class="m-0" id='endDateView'>{{$rEvent->end_date}}</b>
                                                        </p>
                                                    </div>
                                                    <p class="text-muted text-sm" style='font-size:14px;' id='descriptionView'>{{$rEvent->description}}</p>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-7 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div id="fullcalendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Event Modal -->
        <div class="modal fade" id="addNewEvent" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form
                        id="addNewEventForm"
                        action="{{ route('academic-calendars.store') }}"
                        method="POST"
                        onsubmit="return validateForm()"
                    >
                        @csrf
                        <input type="hidden" id="campusId" name="campusId" value="{{$selectedCampus}}" required />
                        <div class="modal-header">
                            <h5 class="modal-title" id="addResponseTemplateModalLabel">
                                <span class='badge text-bg-primary' style="font-size: 12px;font-weight:300;padding:10px;">
                                    {{$selectedCampusName}}
                                </span>  
                                Add New Calendar Event
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
                                <label for="eventCategoryId">Event Category</label>
                                <select class="form-control" id="eventCategoryId" name="eventCategoryId" required>
                                    @foreach ($categories as $category)
                                        @if($category->campusId == $selectedCampus)
                                            <option value="{{$category->id}}">
                                                {{$category->title}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
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
                                <label for="start_date">Start Date</label>
                                <input
                                    type="text"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date"
                                    name="start_date"
                                    value="{{ old('start_date') }}"
                                    required
                                    readonly
                                />
                                @error('start_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input
                                    type="date"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date"
                                    name="end_date"
                                    min="{{ old('end_date') }}"
                                    value="{{ old('end_date') }}"
                                    required
                                />
                                @error('end_date')
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

        {{-- Edit Calendar Event --}}
        <div class="modal fade" id="editCalendarModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="d-flex">
                        <div class="flex-grow-0" id='editEventView' style='color:white;background:#fff;
                        text-align:center;vertical-align:center;padding:5px;margin-right:5px;height:155px;width:200px;'>
                            <h6 class="m-0" style='color:#ffffff;font-size:50px;' id='editMonthNameView'>-</h6>
                            <p class=" text-sm" style='font-size:85px;margin-top:-20px;color:white;' id='editDayNumView'>-</p>
                        </div>
                        <div class="flex-grow-1"  style='margin:5px'>
                            <h3 class="m-0" id='editTitleView'>-</h3>
                            <div  style='margin:0px'>
                                <p class="text-muted text-sm" style='font-size:14px;margin:0px;'>
                                    Start-Date:
                                    <b class="m-0" id='editStartDateView'>-</b>
                                | 
                                    End-Date:
                                    <b class="m-0" id='editEndDateView'>-</b>
                                </p>
                            </div>
                            <p class="text-muted text-sm" style='font-size:14px;' id='editDescriptionView'>-</p>
                            <form action="{{route('academic-calendars.destroy',1)}}" method="POST" style="display: inline"
                                onsubmit="return confirm('Are you sure you want to delete this event?');"
                            >
                                @csrf @method('DELETE')
                                <input type="hidden" id="deleteId" name="deleteId" required />
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
                        </div>
                    </div> 
                    <form id="editCalendarForm" method="POST"  action="{{ route('academic-calendars.update', 1) }}">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCalendarModalLabel"> Edit Calendar Event </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="editEventCategoryId">Event Category</label>
                                <select class="form-control" id="editEventCategoryId" name="editEventCategoryId">
                                    @foreach($categories as $category)
                                        @if($category->campusId == $selectedCampus)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editTitle">Title</label>
                                <input type="hidden" id="editId" name="editId" required />
                                <input
                                    type="text"
                                    class="form-control @error('editTitle') is-invalid @enderror"
                                    id="editTitle"
                                    name="editTitle"
                                    value="{{ old('editTitle', '$category->title') }}"
                                    required
                                />
                                @error('editTitle')
                                <div
                                    class="invalid-feedback"
                                >
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="editDescription">Description</label>
                                <textarea style="max-height: 150px;min-height: 150px;"
                                    class="form-control @error('editDescription') is-invalid @enderror"
                                    id="editDescription"
                                    name="editDescription"
                                    >{{ old('description', '$category->editDescription') }}</textarea>
                                @error('editDescription')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="editStart_date">Start Date</label>
                                <input
                                    type="text"
                                    class="form-control @error('editStart_date') is-invalid @enderror"
                                    id="editStart_date"
                                    name="editStart_date"
                                    value="{{ old('editStart_date') }}"
                                    required
                                    readonly
                                />
                                @error('editStart_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="editEnd_date">End Date</label>
                                <input
                                    type="date"
                                    class="form-control @error('editEnd_date') is-invalid @enderror"
                                    id="editEnd_date"
                                    name="editEnd_date"
                                    min="{{ old('editEnd_date') }}"
                                    value="{{ old('editEnd_date') }}"
                                    required
                                />
                                @error('editEnd_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                           
                            <div class="form-group">
                                <label for="editStatus">Status</label>
                                <select class="form-control" id="editStatus" name="editStatus">
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
    </div>
    


    <script>
        // Convert Laravel's PHP event collection to JSON
        let events = @json($calendars);
        let selectedCampusId = parseInt(@json($selectedCampus));
        let filteredEvents = events.filter((event) => {
            console.log(event.campusId + " and " + selectedCampusId)
            console.log(event.campusId  === selectedCampusId)
            console.log(typeof(event.campusId))
            console.log(typeof(selectedCampusId))
            return event.campusId  === selectedCampusId;
        });
        events = filteredEvents
        // console.log(selectedCampusId)
        console.log(filteredEvents)
        console.log(events)
        let today = new Date();
        let dd = today.getDate()>9?today.getDate():'0'+today.getDate();
        let mm = (today.getMonth() + 1)>9?today.getMonth() + 1:'0'+(today.getMonth() + 1);
        let yyyy = today.getFullYear();
        let toDaysDate = yyyy+'-'+mm+'-'+dd;
        // alert(toDaysDate);
		document.addEventListener("DOMContentLoaded", function() {
			var calendarEl = document.getElementById('fullcalendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
				themeSystem: 'bootstrap',
				initialView: 'dayGridMonth',
				initialDate: toDaysDate,
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
                editable: true,
				events: events.map(function(event) {
                    let endDate = new Date(event.end_date);
                    endDate.setDate(endDate.getDate() + 1); // Add 1 day
                    return {
                        id: event.id,
                        title: event.title,
                        description: event.description,
                        start: event.start_date,
                        end: endDate.toISOString().split('T')[0],
                        // end: event.end_date,
                        catId: event.catId,  // Assuming your event model has these fields
                        status: event.status,  // Assuming your event model has these fields
                        color: event.color,        // If your events have a color field
                        // Add any other event properties here
                    };
                }),
                dateClick: function(info) {
                    // alert('Date: ' + info.dateStr);
                    document.getElementById('start_date').value=info.dateStr ;
                    document.getElementById('end_date').value=info.dateStr ;
                    var modalElement = document.getElementById('addNewEvent');
                    var modal = new bootstrap.Modal(modalElement);
                    // Show the modal
                    modal.show();
                },
                eventClick: function(info) {
                    console.log(info.event);
                    // alert('Event: ' + info.event.backgroundColor);
                    var modalElement = document.getElementById('editCalendarModal');
                    var modal = new bootstrap.Modal(modalElement);
                    
                    // document.getElementById('editEventView').style.backgroundColor ="red";//info.event.backgroundColor;
                    let id = info.event.id
                    let title = info.event.title
                    let description = info.event.extendedProps.description
                    let eventCatId = info.event.extendedProps.catId
                    let status = info.event.extendedProps.status
                    // console.log(status)
                    let startDate = info.event.startStr;
                    let maxLength = 150;
                    
                    let endActualDate = new Date(info.event.end);
                    endActualDate.setDate(endActualDate.getDate() - 1); // Sub 1 day
                    
                    let endDate = info.event.end ? endActualDate.toISOString().split('T')[0] : startDate;
                    let monthShortName = new Date(startDate).toLocaleString('en-us',{month:'short'});
                    let color = info.event.backgroundColor;
                    document.getElementById("editEventView").style.backgroundColor = info.event.backgroundColor;
                    document.getElementById('editTitleView').innerText =title;
                    document.getElementById('editDescriptionView').innerText =description;
                    document.getElementById('editStartDateView').innerText =startDate;
                    document.getElementById('editEndDateView').innerText =endDate;
                    document.getElementById('editMonthNameView').innerText =monthShortName;
                    document.getElementById('editDayNumView').innerText =startDate.split("-")[2];
                    
                    

                    document.getElementById('editTitle').value =title ;
                    document.getElementById('editDescription').innerText =description ;
                    document.getElementById('editStart_date').value =startDate ;
                    document.getElementById('editEnd_date').value =endDate ;
                    document.getElementById('editEventCategoryId').value =eventCatId;
                    document.getElementById('editStatus').value =status;
                    document.getElementById('editId').value =id ;
                    document.getElementById('deleteId').value =id ;

                    // Show the modal
                    modal.show();
                    // Trigger your custom actions here, e.g., open a modal to edit or delete the event
                }
			});
			setTimeout(function() {
				calendar.render();
			}, 250)
		});
	</script>
@endsection