<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toolbox Talk Details</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Toolbox Talk Details</h1>
    <table>
        <tr>
            <th>Project</th>
            <td>{{ $toolboxTalk->project->name }}</td>
        </tr>
        <tr>
            <th>Topic</th>
            <td>{{ $toolboxTalk->topic }}</td>
        </tr>
        <tr>
            <th>Presented By</th>
            <td>{{ $toolboxTalk->presented_by }}</td>
        </tr>
    </table>
    <h2>Attendees</h2>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Surname</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($toolboxTalk->toolbox_talk))
                @php
                    $toolboxTalk = json_decode($toolboxTalk->toolbox_talk, true);
                @endphp
                @for($i = 0; $i < count($toolboxTalk['first_name']); $i++)
                    <tr>
                        <td>{{ $toolboxTalk['first_name'][$i] }}</td>
                        <td>{{ $toolboxTalk['surname'][$i] }}</td>
                        <td>{{ $toolboxTalk['date'][$i] }}</td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>
</body>
</html>