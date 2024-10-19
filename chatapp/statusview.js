document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('userid');

    const carousel = document.querySelector(".carousel");
    let xhr = new XMLHttpRequest();
    xhr.open("GET", `detailsstatus.php?userid=${userId}`, true);

    xhr.onload = function() {
        if (xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE) {
            carousel.innerHTML = xhr.responseText; // Update carousel with fetched images and text

            const slides = carousel.querySelectorAll(".status-slide");
            if (slides.length === 0) {
                console.error("No slides found in the carousel");
                return;
            }

            let currentIndex = 0;

            const updateActiveSlide = (index) => {
                slides.forEach((slide, i) => {
                    const img = slide.querySelector("img");
                    const p = slide.querySelector("p");
                    if (img) img.classList.toggle("active", i === index);
                    if (p) p.classList.toggle("active", i === index);
                    slide.style.display = i === index ? 'block' : 'none';
                });
            };

            updateActiveSlide(currentIndex);

            const nextSlide = () => {
                currentIndex = (currentIndex + 1) % slides.length;
                updateActiveSlide(currentIndex);
            };

            const prevSlide = () => {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                updateActiveSlide(currentIndex);
            };

            const leftArrow = document.createElement("span");
            leftArrow.classList.add("arrow", "left");
            leftArrow.innerHTML = "&#10094;";
            leftArrow.addEventListener("click", prevSlide);
            carousel.appendChild(leftArrow);

            const rightArrow = document.createElement("span");
            rightArrow.classList.add("arrow", "right");
            rightArrow.innerHTML = "&#10095;";
            rightArrow.addEventListener("click", nextSlide);
            carousel.appendChild(rightArrow);

            // Add AJAX form submission for reply forms
            const forms = document.querySelectorAll('.reply-form');
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    const formData = new FormData(form);
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', form.action, true);

                    xhr.onload = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                const response = xhr.responseText;
                                console.log(response); // Just log the response for now
                                form.reset(); // Reset the form fields
                            } else {
                                console.error('Error: ' + xhr.status);
                            }
                        }
                    };

                    xhr.send(formData); // Send the form data
                });
            });
        } else {
            console.error('Failed to fetch status details');
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send();
});
