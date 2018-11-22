@extends('dashboard')

@section('content')
    {{$message = null}}
    <style>
        body .fc {
            overflow: auto;
            touch-action: manipulation;
        }

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 20; /* Sit on top */
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: hidden;
        }

        /* Modal Header */
        .modal-header {
            padding: 10px 16px 0 16px;
            background-color: #f5f5f5;
            color: black;
        }

        .modal-header h2 {
            font-size: 18px;
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
            width: 600px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            margin: 200px auto 0 auto;
            background-color: #fefefe;
            border: 1px solid #888;
            animation: modalopen;
            animation-duration: 0.4s;
            overflow: hidden;
        }

        .modalTable table tr td {
            padding: 5px;
            border: none !important;
        }

        .modalTable .right input {
            width: 100%;
            border-radius: 5px;
            border: 1px solid lightgray;
            background-color: white;
            padding-left: 10px;

            -webkit-transition: border 200ms ease-out;
            -moz-transition: border 200ms ease-out;
            -o-transition: border 200ms ease-out;
            transition: border 200ms ease-out;
        }

        .modalTable .right input:hover {
            border: 1px solid darkgray;
        }

        .left {
            width: 40%;
        }

        .right {
            width: 60%;
        }

        @keyframes modalopen {
            0% {
                top: 80px;
                opacity: 0;
                width: 400px
            }
            70% {
                top: 0;
                width: 600px;
            }
            100% {
                opacity: 1;
            }
        }

        textarea {
            resize: vertical;
            width: 100%;
            height: 100px;
            border-radius: 5px;
            border: 1px solid lightgray;
            background-color: white;

            -webkit-transition: border 200ms ease-out;
            -moz-transition: border 200ms ease-out;
            -o-transition: border 200ms ease-out;
            transition: border 200ms ease-out;
        }

        textarea:hover {
            border: 1px solid darkgray;
        }
    </style>
    <script src='{{asset('js/moment.js')}}'></script>
    <script src='{{asset('js/jquery.js')}}'></script>
    <script src='{{asset('js/jqueryui.js')}}'></script>
    <script src='{{asset('js/calendar.js')}}'></script>
    <link href="{{asset('css/bootstrapdatetime.css')}}" type="text/css" rel="stylesheet">
    <script src="{{asset('js/clockpicker.js')}}"></script>
    <link href="{{asset('css/datepicker.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/datepicker.js')}}"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body body">
                        <div id='calendar' class="calendar">
                            <!-- Modal content -->
                            <div id="myModal" class="modal">
                                <div class="modal-content" id="modal-content">
                                    <div class="modal-header">
                                        <h2><b>Information</b></h2>
                                        <p style="font-size: 12px; margin-bottom: 0;" id="bookName"></p>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modalTable">
                                            <table>
                                                <tr>
                                                    <td class="left">Title</td>
                                                    <td class="right"><input type="text" id="bookTitle" name="bookTitle" style="width: 100%;"></td>
                                                </tr>
                                                <tr>
                                                    <td class="left">Date</td>
                                                    <td id="date" class="right">
                                                        <input type='text' data-toggle='datepicker' id='bDate' name='beginDate' style='width: 42.5%;'>
                                                        <p id="till" style='width: 12.5%; margin: 0;  display: inline-block; text-align: center;'>Until</p>
                                                        <input type='text' data-toggle='datepicker' id='eDate' style='width: 42.5%;' name='endDate'>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left">Time</td>
                                                    <td id="time" class="right">
                                                        <input type='text' id='beginTime' name='beginTime' style='width: 42.5%;'>
                                                        <p style='width: 12.5%; margin: 0;  display: inline-block; text-align: center;'>Until</p>
                                                        <input type='text' id='endTime' name='endTime' style='width: 42.5%;'>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left">Recurring event</td>
                                                    <td class="right">
                                                        <select>
                                                            <option selected="selected">No</option>
                                                            <option>Daily</option>
                                                            <option>Weekly</option>
                                                            <option>Monthly</option>
                                                            <option>Yearly</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left">Description</td>
                                                    <td id="description" class="right"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div id="modalfooter" class="col-md-12 d-flex raw-margin-bottom-12">
                                            <span class='closeModal btn btn-danger mr-2'><i class="fas fa-window-close"></i> Close</span>
                                            <span id="deleteBook" class='deleteSpan btn btn-danger pull-right mr-auto'><i class="fa fa-trash"></i></span>
                                            <span id="editBook" class='editSpan btn btn-primary pull-right'><i class="fas fa-edit"></i> Save</span>
                                            <span id="createBook" class='btn btn-primary pull-right'><i class="fas fa-pencil-alt"></i> Create</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('[data-toggle="datepicker"]').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#beginTime').clockpicker({
            autoclose: true
        });
        $('#endTime').clockpicker({
            autoclose: true
        });
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
            height: 700,
            defaultTimedEventDuration: '01:00',
            allDaySlot: false,
            scrollTime: '07:00',
            businessHours: {
                start: '8:00',
                end: '20:00',
            },
            selectOverlap: false,
            eventOverlap: function (stillEvent, movingEvent) {
                return false;
            },
            selectable: true,
            selectHelper: true,
            eventColor: 'rgb(215,215,215)',
            eventBorderColor: 'rgb(195,195,195)',
            editable: true,
            events: {!! $bookings !!},
            eventRender: function (event, element) {
                element.find('.fc-title').empty();
                element.find('.fc-title').append(event.creator_nicename);
                if (event.description == null) {
                    event.description = "";
                }
                element.find('.fc-title').append("<br/>" + event.description);
            },
            select: function (start, end, jsEvent, view, event) {
                var create = document.getElementById("createBook");
                create.style.display = "block";
                document.getElementById("editBook").style.display = "none";
                document.getElementById("deleteBook").style.display = "none";
                var beginDate = moment(start, 'YYYY-MM-DD').format('YYYY-MM-DD');
                var endDate = moment(end, 'YYYY-MM-DD').format('YYYY-MM-DD');
                var beginTime = moment(start, 'HH:mm').format('HH:mm');
                var endTime = moment(end, 'HH:mm').format('HH:mm');

                var start_time = beginDate + " " + beginTime;
                var end_time = endDate + " " + endTime;

                var modal = document.getElementById('myModal');
                var span = document.getElementsByClassName("closeModal")[0];
                span.classList.add("mr-auto");
                modal.style.display = "block";
                span.onclick = function () {
                    modal.style.display = "none";
                };
                document.getElementById("bDate").value = beginDate;
                document.getElementById("eDate").value = endDate;
                document.getElementById("beginTime").value = beginTime;
                document.getElementById("endTime").value = endTime;

                var titleText = document.getElementById("bookTitle");
                titleText.value = '{{$assets}}';

                document.getElementById("description").innerHTML = "<textarea class='textarea' id='descriptionText' name='message' rows='10' cols= '30'></textarea>";

                create.onclick = function(){
                    var title = titleText.value;
                    modal.style.display = "none";
                    var descriptionText = document.getElementById("descriptionText");
                    var description = $(descriptionText).val();

                    var eventData = {
                        title: title,
                        description: description,
                        start: start_time,
                        end: end_time
                    };

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{url('book/' . $assetId . '/store')}}", //placeholder URL for test
                        type: "POST",
                        data: eventData,
                        success: function (eventData) {
                            calendar.fullCalendar('renderEvent', JSON.parse(eventData));
                            calendar.fullCalendar('rerenderEvents');
                        }
                    });
                }
            },
            eventResize: function (event) {
                if (event.user_id == '{{$user->id}}') {
                    var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var url = '{{ url("book/" . $assetId ."/edit") }}';
                    var eventData = {
                        id: event._id,
                        title: event.title,
                        start_time: start_time,
                        end_time: end_time,
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url + '/' + event._id,
                        data: eventData,
                        type: "PATCH",
                        success: function (eventData) {
                            calendar.fullCalendar('rerenderEvents');
                        }
                    });
                }

                else if ('{{Gate::allows('admin')}}') {
                    var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var url = '{{ url("book/" . $assetId ."/edit") }}';
                    var eventData = {
                        id: event._id,
                        title: event.title,
                        start_time: start_time,
                        end_time: end_time,
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url + '/' + event._id,
                        data: eventData,
                        type: "PATCH",
                        success: function (eventData) {
                            calendar.fullCalendar('rerenderEvents');
                        }
                    });
                }
                else {
                    location.reload(false);
                }
            },
            eventDrop: function (event) {
                if (event.user_id == '{{$user->id}}') {
                    var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var url = '{{ url("book/" . $assetId ."/edit") }}';
                    var eventData = {
                        id: event._id,
                        title: event.title,
                        start_time: start_time,
                        end_time: end_time,
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url + '/' + event._id,
                        data: eventData,
                        type: "PATCH",
                        success: function (eventData) {
                            calendar.fullCalendar('rerenderEvents');
                        }
                    });
                    calendar.fullCalendar('rerenderEvents');
                }
                else if ('{{Gate::allows('admin')}}') {
                    var start_time = moment(event.start, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var end_time = moment(event.end, 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                    var url = '{{ url("book/" . $assetId ."/edit") }}';
                    var eventData = {
                        id: event._id,
                        title: event.title,
                        start_time: start_time,
                        end_time: end_time,
                    };
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url + '/' + event._id,
                        data: eventData,
                        type: "PATCH",
                        success: function (eventData) {
                            calendar.fullCalendar('rerenderEvents');
                        }
                    });
                    calendar.fullCalendar('rerenderEvents');
                }
                else {
                    location.reload(false);
                }
            },
            eventClick: function (event) {
                var beginDate = moment(event.start, 'YYYY-MM-DD').format('YYYY-MM-DD');
                var endDate = moment(event.end, 'YYYY-MM-DD').format('YYYY-MM-DD');
                var beginTime = moment(event.start, 'HH:mm').format('HH:mm');
                var endTime = moment(event.end, 'HH:mm').format('HH:mm');
                var savebutton = document.getElementById("editBook");
                var createbutton = document.getElementById("createBook");
                var deletebutton = document.getElementById("deleteBook");

                var titleText = document.getElementById("bookTitle");
                titleText.value = event.title;

                deletebutton.style.display = "block";
                savebutton.style.display = "block";
                createbutton.style.display = "none";

                document.getElementById("bookTitle").disabled = false;
                document.getElementById("bDate").disabled = false;
                document.getElementById("eDate").disabled = false;
                document.getElementById("beginTime").disabled = false;
                document.getElementById("endTime").disabled = false;

                /* Permission Checker */
                if (event.user_id == '{{$user->id}}') {
                    document.getElementById("description").innerHTML = "<textarea class='textarea' id='descriptionText' name='message' rows='10' cols= '30'></textarea>";

                    document.getElementById("bDate").value = beginDate;
                    document.getElementById("eDate").value = endDate;
                    document.getElementById("beginTime").value = beginTime;
                    document.getElementById("endTime").value = endTime;
                    savebutton.style.display = "block";
                    deletebutton.style.display = "block";
                }
                else if ('{{Gate::allows('admin')}}') {
                    document.getElementById("description").innerHTML = "<textarea class='textarea' id='descriptionText' name='message' rows='10' cols= '30'></textarea>";

                    document.getElementById("bDate").value = beginDate;
                    document.getElementById("eDate").value = endDate;
                    document.getElementById("beginTime").value = beginTime;
                    document.getElementById("endTime").value = endTime;
                    savebutton.style.display = "block";
                    deletebutton.style.display = "block";
                }
                else {
                    savebutton.style.display = "none";
                    deletebutton.style.display = "none";
                    document.getElementById("deleteBook").style.display = "none";

                    if(beginDate === endDate) {
                        document.getElementById("eDate").style.display = "none";
                        document.getElementById("till").style.display = "none";
                    }

                    document.getElementById("bookTitle").disabled = true;
                    document.getElementById("bDate").disabled = true;
                    document.getElementById("eDate").disabled = true;
                    document.getElementById("beginTime").disabled = true;
                    document.getElementById("endTime").disabled = true;

                    document.getElementById("bDate").value = beginDate;
                    document.getElementById("eDate").value = endDate;
                    document.getElementById("beginTime").value = beginTime;
                    document.getElementById("endTime").value = endTime;
                    document.getElementById("description").innerHTML = "<p id='descriptionText'></p>";
                }

                var modal = document.getElementById('myModal');

                var descr = document.getElementById('descriptionText');
                descr.value = event.description;

                var span = document.getElementsByClassName("closeModal")[0];
                span.classList.remove("mr-auto");

                var bTime = document.getElementById("beginTime");
                var eTime = document.getElementById("endTime");
                var bDate = document.getElementById("bDate");
                var eDate = document.getElementById("eDate");
                if (eDate == null) {
                    eDate = bDate;
                }

                modal.style.display = "block";

                span.onclick = function () {
                    modal.style.display = "none";
                };

                document.getElementById("bookName").innerText = "Booked by: " + event.creator_nicename;
                var descriptionText = descr;


                if($(".footerbuttons")) {
                    savebutton.onclick = function () {
                        var bTimeForm = $(bTime).val();
                        var eTimeForm = $(eTime).val();
                        var bDateForm = $(bDate).val();
                        var eDateForm = $(eDate).val();

                        var start_time = bDateForm + " " + bTimeForm;
                        var end_time = eDateForm + " " + eTimeForm;

                        var url = '{{ url("book/" . $assetId ."/edit") }}';
                        descr.innerText = event.description;

                        var title = titleText.value;
                        var description = $(descriptionText).val();

                        var eventData = {
                            id: event._id,
                            title: title,
                            description: description,
                            start_time: start_time,
                            end_time: end_time,
                        };
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url + '/' + event._id,
                            data: eventData,
                            type: "PATCH",
                            success: function (eventData) {

                                calendar.fullCalendar('rerenderEvents');
                                modal.style.display = "none";
                            },
                        });
                        calendar.fullCalendar('rerenderEvents');
                    };
                }

                deletebutton.onclick = function () {
                    var r = confirm("Are you sure you want to delete this Booking?");
                    if (r == true) {
                        modal.style.display = "none";
                        var url = '{{ url("book/" . $assetId ."/delete") }}';
                        var eventData = {
                            id: event._id,
                            title: event.title,
                        };
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url + '/' + event._id,
                            data: eventData,
                            type: "DELETE",
                        });
                        calendar.fullCalendar('removeEvents', [event._id]);
                        calendar.fullCalendar('rerenderEvents');
                    }
                };
            },
        });
    </script>
@endsection