<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request History</title>
    <link rel="stylesheet" href="{{ asset('css/approve.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    
    <script src="{{ asset('js/header.js') }}"></script>
</head>
<body>
    @include('partials.header')
    <h2>Pending Requests</h2>
    <section class="profile-container">
        <div class="profile-card">
            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif
            @if ($leaves->isEmpty())
                <p class="no-requests">No leave requests found</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
                            <th>Document</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $leave)
                            <tr>
                                <td>{{ $leave->user->name }}</td>
                                <td>{{ $leave->start_date }}</td>
                                <td>{{ $leave->end_date }}</td>
                                <td>{{ $leave->reason }}</td>
                                <td>
                                    @if ($leave->document)
                                        <a href="{{ asset('storage/' . $leave->document) }}" target="_blank">View</a>
                                    @else
                                        No Document
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <form action="{{ route('leave.updateStatus', ['id' => $leave->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="status" value="approved" class="approve-btn">Approve</button>
                                        </form>
                                        <form action="{{ route('leave.updateStatus', ['id' => $leave->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="status" value="rejected" class="reject-btn">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Company IT, All rights reserved</p>
        <div class="links">
            <a href="#">Privacy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="social-media">
            <span>Follow us:</span>
            <a href="#">🔵</a>
            <a href="#">🟠</a>
            <a href="#">🟢</a>
        </div>
    </footer>
</body>
</html>