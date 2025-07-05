@extends('employeer.employee-corner.main')
@section('title', 'Holiday Calender')
@section('css')
    <style>
        .calendar-container {
            max-width: 100%;
            margin: 40px 10px;
            background: #fff;
            padding: 15px;
        }
        .calendar-table {
            width: 100% !important;
            background: #f8f8f8;
            -webkit-box-shadow: -1px 5px 16px 0px rgba(0,0,0,0.15);
            -moz-box-shadow: -1px 5px 16px 0px rgba(0,0,0,0.15);
            box-shadow: -1px 5px 16px 0px rgba(0,0,0,0.15);
        }
        .calendar-header {
            background: #00536f !important;
            color: #fff !important;
            padding: 10px 5px;
            text-align: center;
            border: 1px solid #ccc8c8;
        }
        .calendar-header a {
            color: #fff !important;
            text-decoration: none;
        }
        .calendar-day-header {
            background: #fd7e14 !important;
            color: #fff;
            padding: 10px 5px;
            text-align: center;
            border: 1px solid #ccc8c8;
        }
        .calendar-day {
            padding: 10px;
            height: 100px;
            vertical-align: top;
            border: 1px solid #ddd;
        }
        .calendar-day-number {
            background: #eee;
            width: 30px;
            display: block;
            text-align: center;
            height: 30px;
            line-height: 30px;
            margin-bottom: 5px;
        }
        .holiday {
            background-color: #e7ffdd;
            color: rgb(247, 4, 4);
        }   
        .current-day {
            background-color: #fff0d4;
            position: relative;
        }
        .current-day .calendar-day-number {
            background: #00536f;
            color: white;
            font-weight: bold;
        }
        .holiday-event {
            font-size: 12px;
            color: red;
            margin-top: 5px;
        }
        .navigation-buttons {
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: center;
        }
        .navigation-buttons a {
            margin: 0 10px;
            padding: 5px 15px;
            background: #00536f;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Holiday Calendar</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Holiday Calendar</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="card mb-0">
            <div class="card-body">
                <div class="calendar-container">
                    <div class="navigation-buttons">
                        <a href="?year={{ $prevYear }}&month={{ $prevMonth }}">Previous</a>
                        <span style="font-weight:bold; font-size:18px;">{{ $monthName }} {{ $year }}</span>
                        <a href="?year={{ $nextYear }}&month={{ $nextMonth }}">Next</a>
                    </div>
                    
                    <table class="calendar-table">
                        <thead>
                            <tr>
                                <th class="calendar-day-header">Sun</th>
                                <th class="calendar-day-header">Mon</th>
                                <th class="calendar-day-header">Tue</th>
                                <th class="calendar-day-header">Wed</th>
                                <th class="calendar-day-header">Thu</th>
                                <th class="calendar-day-header">Fri</th>
                                <th class="calendar-day-header">Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($weeks as $week)
                                <tr>
                                    @foreach ($week as $day)
                                        @if ($day['date'])
                                            @php
                                                $isHoliday = false;
                                                $holidayName = '';
                                                foreach ($holidays as $holiday) {
                                                    if ($day['date'] >= $holiday->from_date && $day['date'] <= $holiday->to_date) {
                                                        $isHoliday = true;
                                                        $holidayName = $holiday->name;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <td class="calendar-day {{ $isHoliday ? 'holiday' : '' }} {{ $day['isCurrentDate'] ? 'current-day' : '' }}">
                                                <span class="calendar-day-number">{{ $day['day'] }}</span>
                                                @if ($isHoliday)
                                                    <div class="holiday-event">{{ $holidayName }}</div>
                                                @endif
                                            </td>
                                        @else
                                            <td class="calendar-day"></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
@endsection