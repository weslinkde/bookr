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
            $('#calendar').fullCalendar({
                header: { center: 'month,agendaWeek' }, // buttons for switching between views

                views: {
                    month: { // name of view
                        titleFormat: 'YYYY, MM, DD',
                    },
                    agendaWeek: {
                        titleFormat: 'YYYY, MM, DD',
                    },
                }
            });
    </script>
@endsection