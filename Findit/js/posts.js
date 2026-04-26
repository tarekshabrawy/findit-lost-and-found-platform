document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.querySelector('#image');
    const previewImage = document.querySelector('#previewImage');

    if (!imageInput || !previewImage) {
        return;
    }

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (!file) {
            previewImage.style.display = 'none';
            previewImage.src = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
});