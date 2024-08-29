@extends('layouts.app') 
@section('title', 'Academic Calendar')
@section('content')
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Academic Calendar</h1>
        <div class="row">
            <div class="col-sm-5 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-uppercase">Recent Events</h6>
                          @foreach ($recentEvents as $rEvent)
                          @php
                                $eventDateColl = explode('-',$rEvent->start_date);
                                $monthNum = $eventDateColl[1];
                                $dayNum = $eventDateColl[2];
                                $monthName = strtoupper(date("M", mktime(0, 0, 0, $monthNum, 10)));
                          @endphp
                            <div class="d-flex">
                                <div class="flex-grow-0" style='color:white;background:{{$rEvent->color}};text-align:center;vertical-align:center;padding:5px;margin-right:5px;height:45px;width:50px;'>
                                    <h6 class="m-0" style='color:white'>{{$monthName}}</h6>
                                    <p class=" text-sm" style='font-size:25px;margin-top:-10px;color:white;'>{{$dayNum}}</p>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="m-0">{{$rEvent->title}}</h6>
                                    <p class="text-muted text-sm">{{$rEvent->description}}</p>
                                </div>
                            </div>                        
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
                        <div class="modal-header">
                            <h5 class="modal-title" id="addResponseTemplateModalLabel">
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
                                    type="text"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date"
                                    name="end_date"
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
                                <label for="color">Color</label>
                                <input 
                                    type="color" 
                                    class="form-control form-control-color" 
                                    id="color" name="color" value="#CCCCCC" title="Choose a color">
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
    </div>
    


    <script>
        // Convert Laravel's PHP event collection to JSON
        let events = @json($calendars);
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
                    return {
                        id: event.id,
                        title: event.title,
                        start: event.start_date,
                        end: event.end_date,
                        // groupId: event.group_id,  // Assuming your event model has these fields
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
                    alert('Event: ' + info.event.id);
                    // Trigger your custom actions here, e.g., open a modal to edit or delete the event
                }
			});
			setTimeout(function() {
				calendar.render();
			}, 250)
		});
	</script>
@endsection
{{-- [{
    id:1,
    title: 'All Day Event',
    start: '2024-01-01',
    end: '2024-01-01',
    // color: '#FF0000', // Event color
},
{
    title: 'Long Event',
    start: '2024-01-07',
    end: '2024-01-10'
},
{
    groupId: '999',
    title: 'Repeating Event',
    start: '2024-01-09T16:00:00'
},
{
    groupId: '999',
    title: 'Repeating Event',
    start: '2024-01-16T16:00:00'
},
{
    title: 'Conference',
    start: '2024-01-11',
    end: '2024-01-13'
},
{
    title: 'Meeting',
    start: '2024-01-12T10:30:00',
    end: '2024-01-12T12:30:00'
},
{
    title: 'Lunch',
    start: '2024-01-12T12:00:00'
},
{
    title: 'Meeting',
    start: '2024-01-12T14:30:00'
},
{
    title: 'Birthday Party',
    start: '2024-01-13T07:00:00'
},
{
    title: 'Click for Google',
    url: 'http://google.com/',
    start: '2024-01-28'
}
] --}}