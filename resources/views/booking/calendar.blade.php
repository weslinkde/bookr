@extends('dashboard')

@section('content')
    <style>
        body .fc {
            overflow: auto;
            touch-action: manipulation;
        }
    </style>
    <script src='{{asset('js/moment.js')}}'></script>
    <script src='{{asset('js/jquery.js')}}'></script>
    <script src='{{asset('js/jqueryui.js')}}'></script>
    <script src='{{asset('js/calendar.js')}}'></script>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Creating a reservation</h1></div>
                    <div class="panel-body">
                        <p>You can create a reservation by dragging in the calendar.</p>
                        <p style="margin-top: -20px;">You can edit it by dragging the reservation. And deleting it by clicking on it.</p>
                        <div id='calendar' class="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function refresh() {
          location.reload(true);
        }
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek'
            },
            views: {
                month: {
                    titleFormat: 'DD, MMM, YYYY',
                    titleRangeSeparator: ""
                },
                week: {
                    titleFormat: 'DD, MMM',
                    titleRangeSeparator: " - "
                },
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            defaultView: 'agendaWeek',
            nowIndicator: true,
            weekends: false,
            axisFormat: 'HH:mm',
            defaultTimedEventDuration: '01:00',
            allDaySlot: false,
            scrollTime: '08:00',
            businessHours: {
                start: '8:00',
                end: '20:00',
            },
            selectOverlap: false,
            eventOverlap: function (stillEvent, movingEvent) {
                return false;
            },
            editable: true,
            selectable: true,
            selectHelper: true,
            eventColor: 'rgb(215,215,215)',
            eventBorderColor: 'rgb(195,195,195)',
            events: {!! $bookings !!},
            select: function (start, end) {
                var title = prompt("Enter title");
                var name = '{{$user->name}}';
                console.log(name);
                if (title && name) {
                    console.log(title + name);
                    var start_time = moment(start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var end_time = moment(end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{route("storeBeamer")}}",
                        type: "POST",
                        data: {title: title, name: name, start_time: start_time, end_time: end_time},
                        dataType: "json",
                        success: function () {
                            location.reload(true);
                            console.log("Added Succesfully");
                        },
                    });
                }
            },
            eventResize: function(event) {
                console.log(event._id);
                var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                console.log("start-time",start_time);
                console.log("end-time",end_time);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'calendar/edit/' + event._id,
                    data: {id: event._id, start_time: start_time, end_time: end_time},
                    type: "PATCH",
                    success: function() {
                        location.reload(true);
                        console.log("Reservation Updated");
                    }
                })
            },

                eventDrop: function(event) {
                console.log(event._id);
                var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                console.log("start-time",start_time);
                console.log("end-time",end_time);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'calendar/edit/' + event._id,
                    data: {id: event._id, start_time: start_time, end_time: end_time},
                    type: "PATCH",
                    success: function() {
                        location.reload(true);
                        console.log("Reservation Updated");
                    }
                })
            },
            eventClick: function(event) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'calendar/delete/' + event._id,
                    data: 'id=' + event._id,
                    type: "DELETE",
                    success: function() {
                        location.reload(true);
                        console.log("Deleted Succesfully");
                    }
                })
            }
        });

    </script>
    <button type="button" style="margin-top: 20px; margin-left: 30px; background-color: deepskyblue; color: white;" class="btn btn-default btn-sm" onClick="refresh()">
        <span class="glyphicon glyphicon-refresh">Refresh</span>
    </button>

    <div class="alert alert-success alert-dismissible ">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Note:</strong> Be aware that if your reservation doesn't show on the page, that you need to refresh the page.
    </div>
@endsection