const burgerBtn = document.getElementById("burgerBtn");
const menuPanel = document.getElementById("menuPanel");

if (burgerBtn && menuPanel) {
    burgerBtn.addEventListener("click", function () {
        menuPanel.classList.toggle("active");
        burgerBtn.classList.toggle("active");
    });

    document.addEventListener("click", function (event) {
        if (!burgerBtn.contains(event.target) && !menuPanel.contains(event.target)) {
            menuPanel.classList.remove("active");
            burgerBtn.classList.remove("active");
        }
    });
}