/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


document.addEventListener("DOMContentLoaded", function () {
let today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

    // Set min attributes to prevent selecting past dates
    document.getElementById("start_date").setAttribute("min", today);
    document.getElementById("end_date").setAttribute("min", today);

    // Ensure end date cannot be before start date
    document.getElementById("start_date").addEventListener("change", function () {
        document.getElementById("end_date").setAttribute("min", this.value);
    });
});






