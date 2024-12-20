@extends('employeer.employee-corner.main')
@section('title', 'Holiday Calender')
@section('css')
    <style>
        #calendar {
            max-width: 100%;
            margin: 40px 10px;
            background: #fff;
            padding: 15px;
        }
         #calendar table{
             width:100%!important;
                 background: #f8f8f8;
                 -webkit-box-shadow: -1px 5px 16px 0px rgba(0,0,0,0.15);
-moz-box-shadow: -1px 5px 16px 0px rgba(0,0,0,0.15);
box-shadow: -1px 5px 16px 0px rgba(0,0,0,0.15);
         }
          #calendar table th{padding:10px 5px; width: 10%;  text-align: center;}
          
         #calendar table th a{
             color:#fff!important;
         }
         .fc-theme-standard th {
    background: #00536f!important;
         }
        .fc-theme-standard th {
            border: 1px solid #ddd;
            border: 1px solid #ccc8c8;
            background: #00bfff;
            color: #ffff;
            
        }
        .alert [data-notify=title]{display:none !important;}
        .alert [data-notify=message], .alert [data-notify=icon]{display:none !important;}
        a.fc-daygrid-day-number {
    background: #eee;
    width: 30px;
    display: block;
    text-align: center;
    height: 30px;
    line-height: 33px;
   margin: 10px auto;
   
}
.fc-button-group{
    margin-top:10px;
    margin-bottom:10px;
}
span.fc-icon.fc-icon-chevron-left,span.fc-icon.fc-icon-chevron-right {
    position: relative;
}
span.fc-icon.fc-icon-chevron-left:after {
    content: "Pre";
}
 
span.fc-icon.fc-icon-chevron-right:after {
    content: "Next";
}
	</style>
@endsection
@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Holiday Calender</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Holiday Calender</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="card mb-0">
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>
    </div>    
@endsection
@section('script')
    <script src="{{ asset('assetsemcor/js/setting-demo2.js')}}"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: '<?=date('Y-m-d');?>',
            eventColor: 'green',
            events: [
            <?php $k=1;
            $couh=count($holidays);
            ?>
            @foreach($holidays as $holiday)
                        {
                            title: '{{ $holiday->holiday_descripion }}',
                            start: '{{ $holiday->from_date }}',
                            end: '{{ $holiday->to_date }}',
                            
                            color: 'purple',
                        }
                        
                        <?php 
                        
            if($couh!=$k && $couh>$k ){
                echo ',' ;
                
            }
            $k ++;
            ?>
                        @endforeach
            
            ]
        });

        calendar.render();
        });
    </script>   
@endsection