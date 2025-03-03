document.addEventListener("DOMContentLoaded", function () {
    const logoutBtn = document.querySelector(".logout-btn");

    if (logoutBtn) {
        logoutBtn.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default form submission
            
            let confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                alert("Logout successful!"); // Show logout success message
                document.getElementById("logout-form").submit(); // Submit the form
            }
        });
    }
});
