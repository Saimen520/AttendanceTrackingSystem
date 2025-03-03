    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Attendance Records</h1>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>User Name</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->user_name }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->time_in }}</td>
                    <td>
                        @if($attendance->time_out)
                            {{ $attendance->time_out }}
                        @else
                            <span class="text-danger">Not Checked Out</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No attendance records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
