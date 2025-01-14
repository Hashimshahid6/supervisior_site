<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Checklist PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Plant Checklist Details</h1>
    <table>
        <tr>
            <th>Project</th>
            <td>{{ $DailyChecklist->project->name }}</td>
        </tr>
    </table>
    <h2>Vehicle Data</h2>
    <table>
        <thead>
            <tr>
                @foreach($VehicleData => $value)
                <th>{{ $value }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($VehicleData as $key => $value)
                <td>{{ json_decode($DailyChecklist->vehicle_data, true)[$value] ?? '' }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
    <h2>Items Checked</h2>
    <table>
        <thead>
            <tr>
                <th>Items</th>
                @foreach($Days as $key => $value)
                <th>{{ $value }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($VehicleData as $key => $value)
                <th>
                    <span name="vehicle_data" id="vehicle_data">{{ $value }}:</span>
                </th>
                @endforeach
            </tr>
            @if(isset($DailyChecklist->vehicle_data))
            @php
            $vehicle_data = json_decode($DailyChecklist->vehicle_data, true);
            @endphp
            @for($i = 0; $i < count($vehicle_data['vehicle_registration']); $i++) <tr>
                <td>
                    <input type="text" name="vehicle_registration[]"
                        value="{{ $vehicle_data['vehicle_registration'][$i] ?? '' }}" class="form-control">
                </td>
                <td>
                    <input type="date" name="date[]" value="{{ $vehicle_data['date'][$i] ?? '' }}" class="form-control">
                </td>
                <td>
                    <input type="text" name="driver_name[]" value="{{ $vehicle_data['driver_name'][$i] ?? '' }}"
                        class="form-control">
                </td>
                <td>
                    <input type="text" name="miles[]" value="{{ $vehicle_data['miles'][$i] ?? '' }}"
                        class="form-control">
                </td>
                </tr>
                @endfor
                @endif
        </tbody>
    </table>
    <h2>Defects</h2>
    <table>
        <thead>
            <tr>
                <th>Defect</th>
                <th>Date Reported</th>
                <th>Usable</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($DailyChecklist->reports))
            @php
            $reports = json_decode($DailyChecklist->reports, true);
            @endphp
            @for($i = 0; $i < count($reports['reports'] ?? []); $i++) <tr>
                <td>{{ $reports['defect'][$i] ?? '' }}</td>
                <td>{{ $reports['date_reported'][$i] ?? '' }}</td>
                <td>{{ $reports['useable'][$i] ?? '' }}</td>
                </tr>
                @endfor
                @endif
        </tbody>
    </table>
</body>
</html>