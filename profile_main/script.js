function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;

    // Display the location
    

    // Send the location data to the server
    sendLocationData(latitude, longitude);
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}

function sendLocationData(latitude, longitude) {
const xhr = new XMLHttpRequest();
xhr.open("POST", "location.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

// Prepare the data to send
const data = "longitude=" + encodeURIComponent(longitude) + "&latitude=" + encodeURIComponent(latitude);

// Send the request
xhr.send(data);

// Handle the response from the server
xhr.onreadystatechange = function() {
if (xhr.readyState === XMLHttpRequest.DONE) {
    if (xhr.status === 200) {
        const response = xhr.responseText;
        
        // Check the response and update the UI accordingly

        console.log(response)
        if (response.trim() === "Succ") {
            document.getElementById("location").textContent = "Location updated successfully.";
        } else {
            document.getElementById("location").textContent = "Couldn't update the location, please try again later.";
        }
    } else {
        console.error('Error sending data: ' + xhr.status);
        document.querySelector(".location").textContent = "An error occurred while sending data.";
    }
}
};
}
// document.get


document.addEventListener("DOMContentLoaded", function () {
    const buttonLocation = document.querySelector(".buttonloc");
    buttonLocation.addEventListener("click", getLocation);
});