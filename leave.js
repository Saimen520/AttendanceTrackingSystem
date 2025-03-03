/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


    document.addEventListener("DOMContentLoaded", function() {
        let today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
        document.getElementById("start_date").setAttribute("min", today);
        document.getElementById("end_date").setAttribute("min", today);

        document.getElementById("start_date").addEventListener("change", function() {
            let startDate = this.value;
            document.getElementById("end_date").setAttribute("min", startDate);
        });
    });

