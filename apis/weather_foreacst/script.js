const search = document.querySelector('.search');
const temp = document.querySelector('.temp');
const city = document.querySelector('.city');
const humidity = document.querySelector('.humidity');
const wind = document.querySelector('.wind');
const input = search.querySelector("input");
const button = search.querySelector("button");
const feels_like = document.querySelector(".feelslike");
const apiKey = "fc3b1eb09d67c9ebd2d39e4fc7d2bb41";
const class3 = document.querySelector(".class");
const sunrise = document.querySelector(".sunrise");
const sunset = document.querySelector(".sunset");
const windeg = document.querySelector(".windeg");
const error = document.querySelector(".error");
const image = document.querySelector(".weather img");
const windimage = document.getElementById("windimage");
const humidityimage = document.getElementById("humidityimage");
const current = document.querySelector(".current button");

windimage.style.display = "none";
humidityimage.style.display = "none";

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    if (position && position.coords) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        currentweather(lat, lon);
    } else {
        console.log("Position object is undefined or missing 'coords'.");
    }
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            console.log("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            console.log("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            console.log("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            console.log("An unknown error occurred.");
            break;
    }
}

async function currentweather(lat, lon) {
    const apiid = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`;
    const response = await fetch(apiid);
    const data = await response.json();
    
    if (response.status === 404) {
        displayError();
    } else {
        updateWeather(data);
    }
}

async function checkWeather(cityName) {
    const api = `https://api.openweathermap.org/data/2.5/weather?units=metric&q=${cityName}&appid=${apiKey}`;
    const response = await fetch(api);
    const data = await response.json();

    if (response.status === 404) {
        displayError();
    } else {
        updateWeather(data);
    }
}

function displayError() {
    error.textContent = "Oops!!! City not found. Check the name again.";
    temp.textContent = "";
    feels_like.textContent = "";
    city.textContent = "";
    humidity.textContent = "";
    wind.textContent = "";
    class3.textContent = "";
    sunrise.textContent = "";
    sunset.textContent = "";
    windeg.textContent = "";
    image.src = "";
    windimage.style.display = "none";
    humidityimage.style.display = "none";
}

function updateWeather(data) {
    image.style.width = "150px";
    image.style.height = "140px";
    error.textContent = "";
    temp.textContent = Math.round(data.main.temp) + "°C";
    feels_like.textContent = "Feels Like: " + Math.round(data.main.feels_like) + "°C";
    city.textContent = data.name + ", " + data.sys.country;
    humidity.textContent = data.main.humidity + "%";
    wind.textContent = Math.floor(data.wind.speed * 3.6) + " km/h";
    class3.textContent = "Weather: " + data.weather[0].main;
    sunrise.textContent = "Sunrise: " + new Date(data.sys.sunrise * 1000).toLocaleTimeString();
    sunset.textContent = "Sunset: " + new Date(data.sys.sunset * 1000).toLocaleTimeString();
    image.src = getImageForWeather(data.weather[0].main);
    humidityimage.style.display = "block";
    windimage.style.display = "block";
}

function getImageForWeather(weather) {
    switch (weather.toLowerCase()) {
        case "clear":
            return "clear.png";
        case "clouds":
            return "clouds.png";
        case "rain":
            return "rain.png";
        case "snow":
            return "snow.png";
        case "thunderstorm":
            return "thunderstormmain.png";
        case "drizzle":
            return "drizzlemain.png";
        case "mist":
            return "mist.png";
        case "haze":
            return "haze.png";
        case "fog":
            return "fog9.png";
        default:
            return "default.png";
    }
}

current.addEventListener("click", getLocation);

button.addEventListener("click", () => {
    const cityName = input.value;
    checkWeather(cityName);
});

// Check initial weather for Delhi
checkWeather("Delhi");
