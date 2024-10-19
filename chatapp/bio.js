document.addEventListener('DOMContentLoaded', function () {
    // Event listener to show update form
    document.querySelector('.editinfo button').addEventListener('click', () => {
        document.querySelector('.updateinfo').classList.add('active');
    });

    // Event listener to hide update form
    document.querySelector('.updateinfo .cross div').addEventListener('click', () => {
        document.querySelector('.updateinfo').classList.remove('active');
    });

    // Form submission handling using XMLHttpRequest
    const form = document.querySelector(".updateinfo form");
    const button = form.querySelector("button");

    form.onsubmit = function (event) {
        event.preventDefault(); // Prevent default form submission

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "bioupdate.php", true);
        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const data = xhr.responseText.trim();
                    if (data === 'Success') {
                        document.querySelector('.updateinfo').classList.remove('active'); // Hide form
                        form.reset(); // Reset form fields
                        // document.body.style.backgroundColor="Red"
                    } else {
                        console.error('Update failed: ' + data);
                    }
                } else {
                    console.error('Request failed. Status: ' + xhr.status);
                }
            }
        };

        xhr.onerror = function () {
            console.error('Request failed');
        };

        // Send FormData
        const formData = new FormData(form);
        xhr.send(formData);
    };
});
document.querySelector(".status .stories").addEventListener("click", () => {
    document.querySelector(".statusview").classList.toggle("active");
    document.querySelector(".status .chat").classList.toggle("active")
    document.querySelector(".status .stories").classList.toggle("active")
})