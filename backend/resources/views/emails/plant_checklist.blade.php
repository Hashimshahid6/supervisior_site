<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Checklist PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Plant Checklist Details</h1>
    <table>
        <tr>
            <th>Plant Type</th>
            <td>{{ $PlantTypes[$DailyChecklist->plant_type] ?? 'Unknown' }}</td>
            <th>Plant Details</th>
            <td>{{ $DailyChecklist->plant_details }}</td>
            <th>Project</th>
            <td>{{ $DailyChecklist->project->name }}</td>
        </tr>
    </table>
    <h2>Items Checked</h2>
    <table>
        <thead>
            <tr>
                <th>Items</th>
                @foreach($Days as $value)
                    <th>{{ $value }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($PlantChecklists as $value)
                <tr>
                    <td>{{ $value }}</td>
                    @foreach($Days as $day)
                        <td>{{ json_decode($DailyChecklist->checklist, true)[$value][$day] ?? '' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2>Defects</h2>
    <table>
        <thead>
            <tr>
                <th>Defect</th>
                <th>Date Reported</th>
                <th>Usable</th>
                <th>Reported To</th>
                <th>Operator</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($DailyChecklist->reports))
                @php
                    $reports = json_decode($DailyChecklist->reports, true);
                @endphp
                @for($i = 0; $i < count($reports['defect']); $i++)
                    <tr>
                        <td>{{ $reports['defect'][$i] ?? '' }}</td>
                        <td>{{ $reports['date_reported'][$i] ?? '' }}</td>
                        <td>{{ $reports['useable'][$i] ?? '' }}</td>
                        <td>{{ $reports['reported_to'][$i] ?? '' }}</td>
                        <td>{{ $reports['operator'][$i] ?? '' }}</td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>
</body>
</html>