@extends('dashboard')

@section('content')
    <style>
        body .fc {
            overflow: auto;
            touch-action: manipulation;
        }

        /* Modal Header */
        .modal-header {
            padding: 2px 16px;
            background-color: #5cb85c;
            color: white;
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
                @if (Gate::allows('admin'))
                    <!--<a class="nav-link nav-item" href="">Edit this Asset</a>-->
                    @endif
                    <div class="panel-heading heading"><h1>Creating a reservation</h1></div>
                    <div class="panel-body body">
                        <p>You can create a reservation by dragging in the calendar.</p>
                        <p style="margin-top: -20px;">You can edit it by dragging the reservation. And deleting it by
                            clicking on it.</p>
                        <div class="refresh">
                            <button type="button"
                                    style="margin-bottom: 15px; margin-left: 30px; background-color: deepskyblue; color: white;"
                                    class="btn btn-default btn-sm" onClick="refresh()">
                                <span class="glyphicon glyphicon-refresh">Refresh</span>
                            </button>
                        </div>
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
            eventRender: function (event, element) {
                element.find('.fc-title').append("<br/>" + event.description);
            },
            select: function (start, end) {
                var title = '{{$asset}}';
                var name = '{{$user->name}}';
                var description = prompt();
                console.log(name);
                if (title && name && description) {
                    console.log(title + name);
                    var start_time = moment(start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var end_time = moment(end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    console.log("{{$asset}}");
                    var type = '{{$asset}}';
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
                        success: function () {
                            location.reload(false);
                            console.log("Added Succesfully");
                        },
                    });
                }
            },
            eventResize: function (event) {
                console.log(event._id);
                var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                console.log("start-time", start_time);
                console.log("end-time", end_time);
                console.log("{{$asset}}");
                var url = '{{ url("book/" . $asset ."/edit") }}';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url + '/' + event._id,
                    data: {id: event._id, start_time: start_time, end_time: end_time},
                    type: "PATCH",
                    success: function () {
                        location.reload(false);
                        console.log("Reservation Updated");
                    }
                })
            },

            eventDrop: function (event) {
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
                    success: function () {
                        location.reload(false);
                        console.log("Reservation Updated");
                    }
                })
            },
            eventClick: function (event) {
                // Get the modal
                var modal = document.getElementById('myModal');

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on the button, open the modal
                modal.style.display = "block";

                var beginDate = moment(event.start, 'YYYY-MM-DD').format('YYYY-MM-DD');
                var endDate = moment(event.end, 'YYYY-MM-DD').format('YYYY-MM-DD');
                var start_time = moment(event.start, 'HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                var end_time = moment(event.end, 'HH:mm:ss').format('HH:mm:ss');

                document.getElementById("bookItem").innerText = "Booked: " + event.title;
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


                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    modal.style.display = "none";
                };

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                };
            }
        });
    </script>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{$asset}} reservation.</h2>
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
        </div>

    </div>
    <div class="alert alert-success alert-dismissible refreshwarning">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Note:</strong> Be aware that if your reservation doesn't show on the page, that you need to refresh the
        page.
    </div>
@endsection

<!-- <script type="text/javascript">
                function deleteBook(event) {
                    var id = '{{$bookings->id}}';
                    console.log("{{$asset}}");
                    console.log(event._id);
                    var url = '{{ url("book/" . $asset ."/delete") }}';
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url + '/' + event._id,
                        data: 'id=' + event._id,
                        type: "DELETE",
                        success: function () {
                            location.reload(false);
                            console.log("Deleted Succesfully");
                        }
                    })
                }
            </script> -->