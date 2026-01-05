<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Final Selected Athlete List</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
        }
        h3 {
            text-align: center;
            font-weight: normal;
            margin-top: 0;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>
<body>

    <h1>FINAL SELECTED ATHLETE LIST</h1>
    <h3>Generated on {{ now()->format('d M Y') }}</h3>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Matric No</th>
                <th>Event</th>
                <th>Sport</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $index => $app)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $app->user->Name }}</td>
                    <td>{{ $app->user->MatricNo }}</td>
                    <td>{{ $app->event->EventName }}</td>
                    <td>{{ $app->game->GameName }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">
                        No selected athletes found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        System Generated Report<br>
        Athlete Recruitment System
    </div>

</body>
</html>
