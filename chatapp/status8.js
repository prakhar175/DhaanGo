document.addEventListener("DOMContentLoaded", () => {
    const statusInput = document.getElementById('status');
    const previewImageDiv = document.querySelector('.previewimage');
    const statusMessage = document.getElementById('statusmessage');
    const form = document.querySelector(".previewimage form");
    const button = form.querySelector("button");
    const error = document.querySelector(".previewimage .error");

    if (statusInput) {
        statusInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    let previewElement = document.getElementById('preview');
                    if (!previewElement) {
                        previewElement = document.createElement('img');
                        previewElement.id = 'preview';
                        previewElement.classList.add('selected-status');
                        previewImageDiv.insertBefore(previewElement, previewImageDiv.firstChild);
                    }
                    previewElement.src = e.target.result;

                    document.querySelector(".previewimage button").classList.add("active");
                    document.querySelector(".previewimage .cross").classList.add("active");
                    statusMessage.classList.add("display");
                    previewImageDiv.classList.add("active");
                }
                reader.readAsDataURL(file);
            }
        });
    }

    if (form && button) {
        form.onsubmit = (event) => {
            event.preventDefault();

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            xhr.open("POST", "statusinfo.php", true);

            xhr.onload = () => {
                if (xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE) {
                    let response = xhr.responseText;
                    // Handle different responses here based on your PHP script echoes
                    if (response.includes('success')) {
                        const previewElement = document.getElementById('preview');
                        if (previewElement) {
                            previewElement.remove();
                            setTimeout(deletestatus, 3000);
                            // console.log("it is wokring")
                            // document.body.style.backgroundColor = "blue";
                        }
                        form.reset();
                        button.classList.remove("active");
                        statusMessage.classList.remove("display");
                        document.querySelector(".previewimage .cross").classList.remove("active");
                    } else {
                        error.textContent = response;
                    }
                } else {
                    error.textContent = "Request failed. Please try again.";
                }
            };

            xhr.onerror = () => {
                error.textContent = "Request failed. Please try again.";
            };

            xhr.send(formData);
        };
// setTimeout(deletestatus,4000)
        function deletestatus() {
            let xhr = new XMLHttpRequest();
            xhr.open("DELETE", "deletestatus.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    let response = xhr.responseText;
                    // Handle deletion success message if needed
                }
            };
            xhr.send();
        }
    }

    const crossPreview = document.querySelector(".previewimage .cross");
    if (crossPreview) {
        crossPreview.addEventListener("click", () => {
            previewImageDiv.classList.remove('active');
        });
    }

    const statusStories = document.querySelector(".status .stories");
    if (statusStories) {
        statusStories.addEventListener("click", () => {
            document.querySelector(".statusview").classList.add("active");
        });
    }

    const statusViewClose = document.querySelector(".statusview .cro");
    if (statusViewClose) {
        statusViewClose.addEventListener("click", () => {
            document.querySelector(".statusview").classList.remove("active");
            document.querySelector(".status .chat").classList.toggle("active");
            document.querySelector(".status .stories").classList.toggle("active");
        });
    }

    const statusNoteCross = document.querySelector(".statusnote .cross");
    if (statusNoteCross) {
        statusNoteCross.addEventListener("click", () => {
            document.querySelector(".statusnote").classList.remove("active");
        });
    }
});
