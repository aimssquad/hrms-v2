<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Calendar</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .event {
            font-size: 12px;
            color: #555;
        }
        .holiday {
            background-color: #ffeb3b;
        }
        .off-day {
            background-color: #f8bbd0;
        }
        .week-off {
            background-color: #e1bee7;
        }
        .leave-approved {
            background-color: #c8e6c9;
        }
        .leave-not-approved {
            background-color: #ffccbc;
        }
        .duty {
            background-color: #bbdefb;
        }
    </style>
</head>
<body>
    <h1>Employee Calendar</h1>

    @php
        $year = request()->get('year', date('Y'));
        $month = request()->get('month', date('m'));

        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDayOfWeek = date('w', strtotime("$year-$month-01"));

        // Calculate Previous and Next Months
        $prevMonth = $month - 1;
        $prevYear = $year;
        if ($prevMonth < 1) {
            $prevMonth = 12;
            $prevYear--;
        }

        $nextMonth = $month + 1;
        $nextYear = $year;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }
    @endphp

    <div>
        <a href="?year={{ $prevYear }}&month={{ $prevMonth }}">Previous</a>
        <strong>{{ date('F Y', strtotime("$year-$month-01")) }}</strong>
        <a href="?year={{ $nextYear }}&month={{ $nextMonth }}">Next</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
        </thead>
        <tbody>
            @php $dayCounter = 1; @endphp
            @for ($i = 0; $i < 6; $i++)
                <tr>
                    @for ($j = 0; $j < 7; $j++)
                        @if ($i === 0 && $j < $firstDayOfWeek)
                            <td></td>
                        @elseif ($dayCounter > $numDays)
                            <td></td>
                        @else
                            @php
                                $currentDate = date("Y-m-d", strtotime("$year-$month-$dayCounter"));
                                $events = [];
                                $class = '';

                                // Check for leave applications (Approved & Not Approved)
                                foreach ($calendarData['leave_applications'] as $leave) {
                                    if ($currentDate >= date('Y-m-d', strtotime($leave->from_date)) && 
                                        $currentDate <= date('Y-m-d', strtotime($leave->to_date))) {
                                        if ($leave->status === "APPROVED") {
                                            $events[] = "Leave (Approved)";
                                            $class = 'leave-approved';
                                        } else {
                                            $events[] = "Leave (Not Approved)";
                                            $class = 'leave-not-approved';
                                        }
                                    }
                                }

                                // Check for holidays
                                foreach ($calendarData['holidays'] as $holiday) {
                                    if ($currentDate >= date('Y-m-d', strtotime($holiday->from_date)) && 
                                        $currentDate <= date('Y-m-d', strtotime($holiday->to_date))) {
                                        $events[] = "Holiday: " . $holiday->name;
                                        $class = 'holiday';
                                    }
                                }

                                // Check for off days (from `offday` table)
                                foreach ($calendarData['off_days'] as $offDay) {
                                    $dayOfWeek = strtolower(date('D', strtotime($currentDate))); // Get day name (e.g., "mon", "tue")
                                    if ($offDay->$dayOfWeek === "1") {
                                        $events[] = "Off Day";
                                        $class = 'off-day';
                                    }
                                }

                                // Check for week off days (stored in `offday` table)
                                foreach ($calendarData['off_days'] as $offDay) {
                                    $dayOfWeek = strtolower(date('D', strtotime($currentDate)));
                                    if ($offDay->$dayOfWeek === "weekoff") {
                                        $events[] = "Week Off";
                                        $class = 'week-off';
                                    }
                                }
                            @endphp
                            <td class="{{ $class }}">
                                <strong>{{ $dayCounter }}</strong>
                                @foreach ($events as $event)
                                    <div class="event">{{ $event }}</div>
                                @endforeach
                            </td>
                            @php $dayCounter++; @endphp
                        @endif
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>
