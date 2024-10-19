let notes = document.querySelector(".statusnote");
let selected;

function backgroundcolor() {
    let r = Math.floor(Math.random() * 256);
    let g = Math.floor(Math.random() * 256);
    let b = Math.floor(Math.random() * 256);
    let color = "rgb(" + r + "," + g + "," + b + ")";
    notes.style.backgroundColor = color;
    selected = color;
    console.log("deleted")
    return color;
    
}

const form = document.querySelector(".statusnote form");

document.querySelector(".note").addEventListener("click", () => {
    notes.classList.add("active");
    selected = backgroundcolor();
});

document.querySelector(".colorchange").addEventListener("click", backgroundcolor);

const error = document.querySelector(".statusnote .error");
const button = document.querySelector(".statusnote button");

form.addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    let color = selected;

    formData.append("color", color);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "statusinfo.php", true);

    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let response = (xhr.responseText);
            console.log(response)
            if (response === 'success') {
                button.innerHTML = "Sharing";
                notes.classList.remove("active");
                form.reset();
                setTimeout(deletestatus, 3000); // Schedule deletion after 3 seconds
            } else {
                error.innerHTML = "Please enter a note";
            }
        }
    };

    xhr.send(formData);
});

function deletestatus() {
    let xhr = new XMLHttpRequest();
    xhr.open("DELETE", "deletestatus.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                console.log(response.message);
                // Optionally, update the UI to reflect the deletion
                // window.location.href="deletestatus.php"
            } else {
                console.error(response.message);
            }
        }
    };
    xhr.send();
}
