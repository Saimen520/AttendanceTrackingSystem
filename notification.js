document.addEventListener('DOMContentLoaded', function() {
    const notificationBell = document.querySelector('.bell');
    const notificationCount = document.querySelector('.notification-count');

    if (notificationBell) {
        notificationBell.addEventListener('click', function() {
            fetch('/announcements/mark-as-read/1', { // Replace '1' with the actual announcement ID
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the notification count to 0
                    notificationCount.textContent = '0';
                }
            });
        });
    }
});