// public/js/menu.js
document.addEventListener('DOMContentLoaded', function () {
    const toggleMenu = document.getElementById('toggleMenu');
    const sideMenu = document.getElementById('sideMenu');

    toggleMenu.addEventListener('click', function () {
        sideMenu.classList.toggle('show');
    });
});
