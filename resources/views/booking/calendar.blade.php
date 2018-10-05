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
                    <div class="panel-heading">Book Asset</div>
                    <div class="panel-body">
                        <div id='calendar' class="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
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
            events: '{{url('calendar')}}',
            select: function (start, end, allDay) {
                var title = prompt("Enter title");
                var name = prompt("Enter your name");
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
                        succes: function () {
                            calendar.fullCalendar('refetchEvents');
                            console.log("Added Succesfully");
                        },
                    })
                }

            },
        });
        @if($booking)
        @foreach($booking as $book)
        $('#calendar').fullCalendar('renderEvent', {
            title: '{{$book->title()}}',
            name: '{{$book->name()}}',
            start: '{{$book->start_time()}}',
            end: '{{$book->end_time()}}',
        });
        @endforeach
        @endif
    </script>
@endsection