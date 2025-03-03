<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request History</title>
    <link rel="stylesheet" href="{{ asset('css/leaverequest.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <script src="{{ asset('js/header.js') }}"></script>
</head>
<body>
    @include('partials.header')
    <section class="profile-container">
        <div class="profile-card">
            <h2>Leave Request</h2>

            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif
            
            @if (session('error'))
                <div class="error-messages">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

                <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label>Start Date:</label>
                    <input type="date" name="start_date" required>

                    <label>End Date:</label>
                    <input type="date" name="end_date" required>

                    <label>Reason:</label>
                    <textarea name="reason" required></textarea>

                    <label>Upload Document:</label>
                    <p style="color: red">upload on PDF/JPG/PNG/DOC only</p>
                    <input type="file" name="document">

                    <button type="submit">Submit</button>
                </form>
            
           <div class="pagination">
    <!-- Previous Button -->
    @if ($leaves->onFirstPage())
        <button class="pagination-button previous-button disabled" disabled>Previous</button>
    @else
        <a href="{{ $leaves->previousPageUrl() }}" class="pagination-button previous-button">Previous</a>
    @endif

    <!-- Page Numbers -->
    @for ($i = 1; $i <= $leaves->lastPage(); $i++)
        <a href="{{ $leaves->url($i) }}" class="pagination-button {{ $leaves->currentPage() == $i ? 'active' : '' }}">
            {{ $i }}
        </a>
    @endfor

    <!-- Next Button -->
    @if ($leaves->hasMorePages())
        <a href="{{ $leaves->nextPageUrl() }}" class="pagination-button next-button">Next</a>
    @else
        <button class="pagination-button next-button disabled" disabled>Next</button>
    @endif
</div>

@if ($leaves->isEmpty())
    <p class="no-requests">No leave requests found</p>
@else
    <table border="1">
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Document</th>
        </tr>
        @foreach ($leaves as $leave)
            <tr>
                <td>{{ $leave->start_date }}</td>
                <td>{{ $leave->end_date }}</td>
                <td>{{ $leave->reason }}</td>
                <td>{{ $leave->status }}</td>
                <td>
                    @if ($leave->document)
                        <a href="{{ asset('storage/' . $leave->document) }}" target="_blank">View</a>
                    @else
                        No Document
                    @endif
                </td>
            </tr>
        @endforeach
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
    <script src="{{ asset('leave.js') }}"></script>
    
</body>
</html>
