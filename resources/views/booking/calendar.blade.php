@extends('dashboard')

@section('content')
    {{$message = null}}
    <style>
        body .fc {
            overflow: auto;
            touch-action: manipulation;
        }

        /* Modal Header */
        .modal-header {
            padding: 2px 16px;
            background-color: #343A40;
            color: white;
        }

        .modal-header h2 {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        /* Modal Body */
        .modal-body {
            padding: 2px 16px;
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }
            to {
                top: 0;
                opacity: 1
            }
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 20; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            border: 1px solid #888;
            height: 300px;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: black;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
                    <div class="panel-heading heading"><h1>Creating a reservation</h1></div>
                    <div class="panel-body body">
                        <p>You can create a reservation by dragging in the calendar.</p>
                        <p style="margin-top: -20px;">You can edit it by dragging the reservation. And deleting it by
                            clicking on it.</p>
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
            displayEventTitle: false,
            axisFormat: 'HH:mm',
            timeFormat: 'HH:mm',
            height: 618,
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
            eventRender: function (event, element,) {
                element.find('.fc-title').empty();
                element.find('.fc-title').append("{{$assets}}");
                element.find('.fc-title').append("<br/>" + event.description);
            },
            select: function (start, end) {
                var title = '{{$href}}';
                var name = '{{$user->name}}';
                var description = prompt();
                console.log(name);
                if (title && name && description) {
                    console.log(title + name);
                    var start_time = moment(start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var end_time = moment(end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    console.log("{{$assets}}");
                    var type = '{{$href}}';
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{url('book/{href}/store')}}",
                        type: "POST",
                        data: {
                            title: title,
                            name: name,
                            description: description,
                            type: type,
                            start_time: start_time,
                            end_time: end_time
                        },
                        dataType: "json",
                    });
                    alert("Reservation created.");
                    location.reload(false);
                }
            },
            eventResize: function (event) {
                @if (Gate::allows('admin') || $name->name == $user->name)
                console.log(event._id);
                var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                console.log("start-time", start_time);
                console.log("end-time", end_time);
                console.log("{{$assets}}");
                var url = '{{ url("book/" . $href ."/edit") }}';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url + '/' + event._id,
                    data: {id: event._id, start_time: start_time, end_time: end_time},
                    type: "PATCH",
                });
                alert("Reservation deleted.");
                location.reload(false);
                @else
                    location.reload(false);
                @endif
            },

            eventDrop: function (event) {
                @if (Gate::allows('admin') || $name->name == $user->name)
                console.log(event._id);
                var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                console.log("start-time", start_time);
                console.log("end-time", end_time);
                var url = '{{ url("book/{href}/edit/") }}';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url + '/' + event._id,
                    data: {id: event._id, start_time: start_time, end_time: end_time},
                    type: "PATCH",
                });
                alert("Reservation deleted.");
                location.reload(false);
                @else
                location.reload(false);
                @endif
            },

            eventClick: function (event) {
                var modal = document.getElementById('myModal');

                var deleteBook = document.getElementsByClassName("deleteSpan")[0];

                var span = document.getElementsByClassName("close")[0];

                modal.style.display = "block";

                span.onclick = function () {
                    modal.style.display = "none";
                };

                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                };

                var beginDate = moment(event.start, 'YYYY-MM-DD').format('YYYY-MM-DD');
                var endDate = moment(event.end, 'YYYY-MM-DD').format('YYYY-MM-DD');
                var start_time = moment(event.start, 'HH:mm:ss').format('HH:mm:ss');
                var end_time = moment(event.end, 'HH:mm:ss').format('HH:mm:ss');
                document.getElementById("bookItem").innerText = "Booked: {{$assets}}";
                document.getElementById("bookName").innerText = "Booked by: " + event.name;
                document.getElementById("bookDescription").innerText = "Description: " + event.description;
                if (beginDate == endDate) {
                    document.getElementById("bookDate").innerText = ("Date: " + beginDate);
                }
                else {
                    document.getElementById("bookDate").innerText = ("Begins on date: " + beginDate + ", and ends on: " + endDate);
                }
                document.getElementById("bookStart").innerText = "Booked from: " + start_time;
                document.getElementById("bookEnd").innerText = "Booked until: " + end_time;

                deleteBook.onclick = function () {
                    console.log("{{$assets}}");
                    console.log(event._id);
                    var url = '{{ url("book/" . $href ."/delete") }}';
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url + '/' + event._id,
                        data: 'id=' + event._id,
                        type: "DELETE",
                    });
                    alert("Reservation deleted.");
                    location.reload(false);
                };
            }
        });
    </script>
    <!-- Modal content -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    @if (Gate::allows('admin') || $name->name == $user->name)
                        Edit reservation: {{$assets}}
                    @else
                        Reservation: {{$assets}}
                    @endif
                </h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div id="bookItem"></div>
                <div id="bookName"></div>
                <div id="bookDescription"></div>
                <br>
                <div id="bookDate"></div>
                <div id="bookStart"></div>
                <div id="bookEnd"></div>
            </div>
            @if (Gate::allows('admin') || $name->name == $user->name)
                <div class="modal-footer">
                    <span class='deleteSpan btn btn-danger' style="width: 25%; margin: 0 auto;"><i class="fa fa-trash"></i> Delete</span>
                </div>
            @endif
        </div>
    </div>
    <div class="alert alert-success alert-dismissible refreshwarning">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Note:</strong>
        <div id="message">If the descriptions do not fit the Asset, the Asset has been updated resently.</div>
    </div>
@endsection