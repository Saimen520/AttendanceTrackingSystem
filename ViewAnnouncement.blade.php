<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcement</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/viewAnnouncement.css') }}">
    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/header.js') }}"></script>
<body>
    @include('partials.header')
    <div class="container">
        <h2>Announcements</h2>
        <div class="pagination">
            <!-- Previous Button -->
            @if ($announcements->onFirstPage())
                <button class="pagination-button previous-button disabled" disabled>Previous</button>
            @else
                <a href="{{ $announcements->previousPageUrl() }}" class="pagination-button previous-button">Previous</a>
            @endif

            <!-- Page Numbers -->
            @for ($i = 1; $i <= $announcements->lastPage(); $i++)
                <a href="{{ $announcements->url($i) }}" class="pagination-button {{ $announcements->currentPage() == $i ? 'active' : '' }}">
                    {{ $i }}
                </a>
            @endfor

            <!-- Next Button -->
            @if ($announcements->hasMorePages())
                <a href="{{ $announcements->nextPageUrl() }}" class="pagination-button next-button">Next</a>
            @else
                <button class="pagination-button next-button disabled" disabled>Next</button>
            @endif
        </div>
        @if(session('success'))
        <div class="alert-success">
                    {{ session('success') }}
                </div>
        @endif
        @if(session('error'))
            <div class="alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <ul class="announcements-list">
            @foreach($announcements as $announcement)
                <li class="announcement-item">
                    <div class="announcement-title">{{ $announcement->title }}</div>
                    <div class="announcement-message">
                        {!! $announcement->message !!} <!-- Render processed message as HTML -->
                    </div>
                    <div class="announcement-meta">
                        Posted by: <strong>{{ $announcement->user->name }}</strong> on {{ $announcement->created_at->format('d M Y, h:i A') }}
                    </div>
                    <div class="attachment">
                    @if ($announcement->document)
                        <a href="{{ asset('storage/' . $announcement->document) }}" target="_blank" class="announcement-document">📄 View Attached Document</a>
                    @endif
                    </div>
                     <!-- Show delete button only if user is an admin -->
                        @if (auth()->user()->role->id == 1)
                            <form action="{{ route('announcement.destroy', $announcement->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">🗑 Delete</button>
                            </form>
                        @endif
                </li>
                 @endforeach
            </ul>
        
           
    </div>
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

  <script>
    function markAnnouncementAsRead(id) {
        fetch('/announcement/' + id + '/markAsRead', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              }
          });
    }
   
</script>

</html>
