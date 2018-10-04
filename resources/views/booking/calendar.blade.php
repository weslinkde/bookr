@extends('dashboard')

@section('content')
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
            eventColor: '#64eae8',
            eventBorderColor: '#5dccca',
            select: function (start, end) {
                var duration = (end - start) / 1000;
                if (duration == 1800) {
                    end = start.add(30, 'mins');
                    return calendar.fullCalendar('select', start, end);
                }
                var title = prompt('Event Title:');
                var eventData;
                if (title && title.trim()) {
                    eventData = {
                        title: title,
                        start: start,
                        end: end
                    };
                    calendar.fullCalendar('renderEvent', eventData);
                }
                calendar.fullCalendar('unselect');
            },
            eventRender: function (event, element) {
                var start = moment(event.start).fromNow();
                element.attr('title', start);
            },
            loading: function () {
                //
            },
        });
    </script>
@endsection