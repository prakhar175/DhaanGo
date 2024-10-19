const form = document.querySelector("form");
const continueButton = form.querySelector("button");
const errorTxt = document.querySelector(".error-txt");
const buttontext=continueButton.querySelector("span")
const loader=continueButton.querySelector("div")
form.onsubmit = (e) => {
    e.preventDefault(); // Prevent default form submission behavior
};
continueButton.onclick = () => {
    document.body.style.backgroundColor="red"
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "loginback.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if(data.trim() === "success") {
                    buttontext.style.display="none"
                    loader.style.display="block"
                    window.location.href = "users.php";
                } else {
                    errorTxt.textContent = data;
                    errorTxt.style.display = "block"; // Fix typo here
                }
            }
        }
    };

    // Construct FormData object with form data
    let formData = new FormData(form);

    xhr.send(formData); // Send form data to loginback.php
};
