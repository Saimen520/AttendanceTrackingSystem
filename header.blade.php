<!-- resources/views/partials/header.blade.php -->
<header>
    <div class="logo">
        <a href="{{ route('HomePage') }}"> 
            <img src="{{ asset('Images/INFINITECH.png') }}" alt="INFINITECH Logo">
        </a>
    </div>

    <nav>
        <a href="{{ route('HomePage') }}">Home</a>
        <div class="dropdown">
            <a href="#" class="dropbtn">Attendance</a>
            <div class="dropdown-content">
                 @if (auth()->user()->role->id == 2 || auth()->user()->role->id == 3 )
                    <a href="{{ route('Announcement') }}">View Attendance</a>
                @endif
                 @if (auth()->user()->role->id == 1 )
                    <a href="{{ route('overall_attendance') }}">Overall Attendance</a>
                @endif
                 @if (auth()->user()->role->id == 1 )
                    <a href="{{ route('attendance.index') }}">Attendance Log</a>
                @endif
                 @if (auth()->user()->role->id == 1 )
                    <a href="{{ route('Announcement') }}">Generate Report</a>
                @endif
                
            </div>
        </div>
        <div class="dropdown">
            <a href="#" class="dropbtn">Application</a>
            <div class="dropdown-content">
                @if (auth()->user()->role->id == 2 || auth()->user()->role->id == 3)
                    <a href="{{ route('LeaveRequest') }}">Request Leave</a>
                @endif
                @if (auth()->user()->role->id == 1)
                    <a href="{{ route('ApproveRequest') }}">Approve Leave</a>
                @endif
                @if (auth()->user()->role->id == 1 || auth()->user()->role->id == 2)
                    <a href="{{ route('Announcement') }}">Create Announcement</a>
                @endif
                @if (auth()->user()->role->id == 1 || auth()->user()->role->id == 2 || auth()->user()->role->id == 3)
                    <a href="{{ route('ViewAnnouncement') }}">View Announcement</a>
                @endif
            </div>
        </div>
        <a href="{{ route('Profile') }}">My Profile</a>
    </nav>
    
    <div class="notification" id="notification">
    <span class="bell" onclick="toggleNotificationBox()">🔔</span>
    @if ($unreadCount > 0)
        <span class="notification-count" id="notificationCount">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
    @endif

    <!-- Notification Dropdown -->
    <div class="notification-box" id="notificationBox">
        <a href="{{ route('ViewAnnouncement') }}" onclick="markAllAsRead()">Check New Announcements</a>
    </div>
</div>

</header>

<script>
    function toggleNotificationBox() {
        let box = document.getElementById("notificationBox");
        box.style.display = (box.style.display === "block") ? "none" : "block";
    }

    function markAllAsRead() {
        fetch("{{ route('announcements.markAsRead') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("notificationCount").style.display = "none"; // Hide red badge
            }
        })
        .catch(error => console.error("Error:", error));
    }

    // Close the notification box when clicking outside
    document.addEventListener("click", function (event) {
        let notificationBox = document.getElementById("notificationBox");
        let bell = document.querySelector(".bell");
        if (event.target !== notificationBox && event.target !== bell) {
            notificationBox.style.display = "none";
        }
    });
</script>
