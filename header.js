/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.querySelector(".dropdown");
    const menu = document.querySelector(".dropdown-menu");

    dropdown.addEventListener("mouseover", function () {
        menu.style.display = "block";
        menu.style.opacity = "1";
        menu.style.transition = "opacity 0.3s ease-in-out";
    });

    dropdown.addEventListener("mouseleave", function () {
        menu.style.opacity = "0";
        setTimeout(() => {
            menu.style.display = "none";
        }, 300);
    });
});
