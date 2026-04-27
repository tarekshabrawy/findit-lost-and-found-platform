console.log("FindIt authentication pages loaded");

// Simple form check
document.querySelectorAll("form").forEach(function(form) {
    form.addEventListener("submit", function(event) {
        const inputs = form.querySelectorAll("input[required]");
        let valid = true;

        inputs.forEach(function(input) {
            if (input.value.trim() === "") {
                valid = false;
            }
        });

        if (!valid) {
            event.preventDefault();
            alert("Please fill in all required fields.");
        }
    });
});