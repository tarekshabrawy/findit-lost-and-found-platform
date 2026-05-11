console.log("menu.js is running");

document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("navToggle");
    const links = document.getElementById("navLinks");
    const themeToggle = document.getElementById("themeToggle");

    if (toggle && links) {
        toggle.addEventListener("click", function () {
            const isOpen = links.classList.toggle("open");
            toggle.classList.toggle("open", isOpen);
            toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
        });
    }

    function applyTheme(theme) {
        if (theme === "dark") {
            document.body.classList.add("dark-mode");
            themeToggle.textContent = "☀️";
        } else {
            document.body.classList.remove("dark-mode");
            themeToggle.textContent = "🌙";
        }
    }

    const savedTheme = localStorage.getItem("finditTheme") || "light";
    applyTheme(savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener("click", function () {
            const currentTheme = document.body.classList.contains("dark-mode") ? "dark" : "light";
            const newTheme = currentTheme === "dark" ? "light" : "dark";

            localStorage.setItem("finditTheme", newTheme);
            applyTheme(newTheme);
        });
    }
});