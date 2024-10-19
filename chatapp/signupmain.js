document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    const continueButton = form.querySelector("button");
    const errorTxt = document.querySelector(".error-txt");

    form.onsubmit = (e) => {
        e.preventDefault(); // Prevent default form submission behavior
    };

    continueButton.onclick = () => {
        document.body.style.backgroundColor="blue"
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "signup.php", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let data = xhr.responseText;
                    if (data.trim() === "User registered successfully.") {
                        window.location.href = "users.php"; // Redirect to a success page
                    } else {
                        errorTxt.textContent = data;
                        errorTxt.style.display = "block"; // Display error message
                    }
                }
            }
        };

        let formData = new FormData(form); // Construct FormData object with form data
        xhr.send(formData); // Send form data to signup.php
    };
});
