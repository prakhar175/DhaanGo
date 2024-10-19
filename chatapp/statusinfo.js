document.addEventListener("DOMContentLoaded", () => {
    const statusmain = document.querySelector(".statusview .otherstatus");
    const error = document.getElementById("errortxt");

    const fetchStatus = () => {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "statusdisplay.php", true);

        xhr.onload = () => {
            if (xhr.status === 200 && xhr.readyState === XMLHttpRequest.DONE) {
                let data = xhr.responseText;
                statusmain.innerHTML = data;
                error.textContent = ""; // Clear any previous error message
            } else {
                error.textContent = "Failed to load status. Please try again.";
            }
        };

        xhr.onerror = () => {
            error.textContent = "Request failed. Please check your connection.";
        };

        xhr.send();
        console.log("statusone")
    };

    // Fetch status immediately and then every 10 seconds
    fetchStatus();
    setInterval(fetchStatus, 20000);
});
